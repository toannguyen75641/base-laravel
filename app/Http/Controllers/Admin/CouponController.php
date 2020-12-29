<?php

namespace App\Http\Controllers\Admin;

use App\Constants\CouponManagementConstant;
use App\Constants\CouponMasterConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponManagementRequest;
use App\Http\Requests\ImportCsvFileRequest;
use App\Imports\CouponImport;
use App\Repositories\ChannelRepository;
use App\Repositories\CouponManagementRepository;
use App\Repositories\CouponMasterRepository;
use App\Repositories\CouponRepository;
use App\Repositories\PartnerRepository;
use http\Env\Response;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Illuminate\View\View;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use App\Http\Requests\CouponMasterRequest;
use App\Helpers\FileHelper;

class CouponController extends Controller
{
    protected $couponMasterRepository;
    protected $couponManagementRepository;
    protected $partnerRepository;
    protected $channelRepository;

    /**
     * CouponController constructor.
     *
     * @param CouponMasterRepository $couponMasterRepository
     * @param CouponManagementRepository $couponManagementRepository
     * @param PartnerRepository $partnerRepository
     * @param ChannelRepository $channelRepository
     */
    public function __construct
    (
        CouponMasterRepository $couponMasterRepository,
        CouponManagementRepository $couponManagementRepository,
        PartnerRepository $partnerRepository,
        ChannelRepository $channelRepository
    )
    {
        $this->couponMasterRepository = $couponMasterRepository;
        $this->couponManagementRepository = $couponManagementRepository;
        $this->partnerRepository = $partnerRepository;
        $this->channelRepository = $channelRepository;
    }

    /**
     * Get the list of coupons.
     *
     * @param Request $request
     *
     * @return Factory|View
     */
    public function getList(Request $request)
    {
        $condition = $request->only([
            CouponMasterConstant::INPUT_MEASURE_CODE,
            CouponMasterConstant::INPUT_FLG,
            CouponMasterConstant::INPUT_SYS_PERIOD_FROM,
            CouponMasterConstant::INPUT_SYS_PERIOD_TO
        ]);
        $columns = [
            FIELD_ID,
            CouponMasterConstant::INPUT_FLG,
            CouponMasterConstant::INPUT_SYS_PERIOD_FROM,
            CouponMasterConstant::INPUT_SYS_PERIOD_TO,
            CouponMasterConstant::INPUT_MEASURE_CODE,
            CouponMasterConstant::INPUT_MEASURE_NAME,
            CouponMasterConstant::INPUT_FORCED_FLG,
        ];
        $couponMasters = $this->couponMasterRepository->getList($columns, $condition);

        return view('page.coupon.list', compact('couponMasters', 'condition'));
    }

    /**
     * View add CSV file.
     *
     * @return Factory|View
     */
    public function addCsv()
    {
        return view('page.coupon.add_csv');
    }

    /**
     * Upload CSV file.
     *
     * @return RedirectResponse
     */
    public function uploadCsv(ImportCsvFileRequest $request)
    {
        try {
            HeadingRowFormatter::default('CouponMaster');
            $headings = (new HeadingRowImport())->toArray($request->file('file'));
            if(!empty(array_diff($headings[0][0], array_keys(CouponMasterConstant::HEADER_CSV)))
                    && !empty(array_diff(array_keys(CouponMasterConstant::HEADER_CSV), $headings[0][0]))) {
                $messageBag = new MessageBag();
                $messageBag->getMessageBag()->add('file', __('validation.custom.csv.heading'));
                return back()->withInput()->withErrors($messageBag);
            }
            $import = new CouponImport(
                new CouponMasterRepository(),
                new CouponRepository()
            );

            $import->import($request->file('file'));
            if (!$import->failures()->isEmpty()) {
                $messageBag = new MessageBag();
                foreach ($import->failures() as $failure) {
                    foreach($failure->errors() as $err) {
                        $messageBag->getMessageBag()->add('file', $failure->row().'行目'.$err);
                    }
                }

                return back()->withInput()->withErrors($messageBag);
            }

            return redirect()
                ->route('coupon.list')
                ->with(KEY_NOTIFICATION, __('message.kddi.coupon.csv.success'));
        } catch (\Exception $exception) {
            Log::error('[Import coupon CSV]: ' . $exception->getMessage());

            return back()->withErrors(__('message.error.500'));
        }
    }

    /**
     * View edit coupons master.
     *
     * @param $id
     *
     * @return Factory|View
     */
    public function editMaster($id)
    {
        $couponMaster = $this->couponMasterRepository->getDetail($id);
        if(!$couponMaster) {
            return view('error.404');
        }
        return view('page.coupon.update', compact('couponMaster'));
    }

    /**
     * Update coupons master.
     *
     * @param CouponMasterRequest $request
     * @param int $id
     *
     * @return RedirectResponse|Factory|View
     */
    public function updateMaster(CouponMasterRequest $request, int $id)
    {
        $couponMaster = $this->couponMasterRepository->getDetail($id);
        if (!$couponMaster) {
            return view('error.404');
        }

        $checkBoxInput = $request->only(CouponMasterConstant::CHECK_BOX_COLUMN);
        $input = $request->only(CouponMasterConstant::SELECT_COLUMN);
        $input[CouponMasterConstant::INPUT_FORCED_FLG] = count($checkBoxInput) == 1 ? array_shift($checkBoxInput) : (count($checkBoxInput) == 2 ? CouponMasterConstant::SELECT_BOTH : CouponMasterConstant::UNSELECTED);

        if ($request->hasFile(CouponMasterConstant::INPUT_COUPON_IMG)) {
            $oldFile = $couponMaster->{CouponMasterConstant::INPUT_COUPON_IMG};
            $file = $request->file(CouponMasterConstant::INPUT_COUPON_IMG);
            $filePath = FileHelper::storage($file);
            if (empty($filePath)) {
                return redirect()
                    ->back()
                    ->with(KEY_NOTIFICATION, __('message.coupon.update.fail'));
            }
            $input[CouponMasterConstant::INPUT_COUPON_IMG] = $filePath;
        }

        $result = $this->couponMasterRepository->update($couponMaster, $input);

        if ($result) {
            if(!empty($oldFile)) {
                FileHelper::delete($oldFile);
            }
            return redirect()
                ->route('coupon.list')
                ->with(KEY_NOTIFICATION, __('message.coupon.update.success'));
        }

        if (isset($filePath) && !empty($filePath)) {
            FileHelper::delete($filePath);
        }
        return redirect()
            ->back()
            ->with(KEY_NOTIFICATION, __('message.coupon.update.fail'));
    }

    /**
     * Get the list of coupon management.
     *
     * @return Factory|View
     */
    public function getListManagement()
    {
        $listCouponManagement = $this->couponManagementRepository->getList();

        return view('page.coupon_management.list',  compact('listCouponManagement'));
    }

    /**
     * Get the add coupon management.
     *
     * @return Factory|View
     */
    public function addManagement()
    {
        $condition = [
            CouponManagementConstant::INPUT_PARTNER_ID,
            CouponManagementConstant::INPUT_CHANNEL_ID,
            CouponManagementConstant::INPUT_COUPON_MASTER_ID
        ];
        $partners = $this->partnerRepository->getList();
        $channels = $this->channelRepository->getList();
        $couponMasters = $this->couponMasterRepository->getList();

        return view('page.coupon_management.add', compact('partners','channels', 'couponMasters', 'condition'));
    }

    /**
     * Get the create coupon management.
     *
     * @param CouponManagementRequest $request
     *
     * @return RedirectResponse
     */
    public function createManagement(CouponManagementRequest $request)
    {
        $input = $request->only([
            CouponManagementConstant::INPUT_PARTNER_ID,
            CouponManagementConstant::INPUT_CHANNEL_ID,
            CouponManagementConstant::INPUT_COUPON_MASTER_ID
        ]);

        $result = $this->couponManagementRepository->create($input);
        if ($result) {
            return redirect()
                ->route('coupon.coupon_management.list')
                ->with(KEY_NOTIFICATION, __('message.business.user.create.success'));
        }

        return redirect()
            ->route('coupon.coupon_management.add')
            ->with(KEY_NOTIFICATION,  __('message.business.user.create.fail'));
    }

    /**
     * View update coupon management.
     *
     * @param $id
     *
     * @return Factory|View
     */
    public function editManagement($id)
    {
        $couponManagement = $this->couponManagementRepository->getDetail($id);
        if (!$couponManagement) {
            return view('error.404');
        }
        $couponMasters = $this->couponMasterRepository->getList();

        return view('page.coupon_management.add', compact('couponManagement', 'couponMasters'));
    }

    /**
     * Update coupon management.
     *
     * @param int $id
     * @param CouponManagementRequest $request
     *
     * @return RedirectResponse|Factory|View
     */
    public function updateManagement($id, CouponManagementRequest $request)
    {
        $couponManagement = $this->couponManagementRepository->getDetail($id);
        if (!$couponManagement) {
            return view('error.404');
        }
        $input = $request->only([
            CouponManagementConstant::INPUT_COUPON_MASTER_ID
        ]);
        $result = $this->couponManagementRepository->update($couponManagement, $input);
        if ($result) {
            return redirect()
                ->route('coupon.coupon_management.list')
                ->with(KEY_NOTIFICATION, __('message.business.user.update.success'));
        }

        return redirect()
            ->route('coupon.coupon_management.edit', $couponManagement->id)
            ->with(KEY_NOTIFICATION,  __('message.business.user.update.fail'));
    }
}

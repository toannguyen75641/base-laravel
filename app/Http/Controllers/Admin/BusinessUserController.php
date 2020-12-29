<?php

namespace App\Http\Controllers\Admin;

use App\Constants\DepartmentConstant;
use App\Constants\OfficeConstant;
use App\Constants\RegionConstant;
use App\Constants\SalesPersonConstant;
use App\Constants\BusinessUserConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessUserRequest;
use App\Http\Requests\ImportCsvFileRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Repositories\BusinessUserRepository;
use App\Repositories\OfficeRepository;
use App\Repositories\RegionRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\SalesPersonRepository;
use App\Services\Export;
use App\Imports\BusinessUserImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Support\MessageBag;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class BusinessUserController extends Controller
{
    protected $businessUserRepository;
    protected $officeRepository;
    protected $regionRepository;
    protected $departmentRepository;
    protected $salesPersonRepository;

    public function __construct
    (
        BusinessUserRepository $businessUserRepository,
        OfficeRepository $officeRepository,
        RegionRepository $regionRepository,
        DepartmentRepository $departmentRepository,
        SalesPersonRepository $salesPersonRepository
    )
    {
        $this->businessUserRepository = $businessUserRepository;
        $this->officeRepository = $officeRepository;
        $this->regionRepository = $regionRepository;
        $this->departmentRepository = $departmentRepository;
        $this->salesPersonRepository = $salesPersonRepository;
    }

    /**
     * View list of business persons.
     *
     * @param Request $request
     *
     * @return Factory|View
     */
    public function getList(Request $request)
    {
        $condition = $request->only([
            BusinessUserConstant::INPUT_OFFICES_ID,
            BusinessUserConstant::INPUT_REGIONS_ID,
            BusinessUserConstant::INPUT_DEPARTMENTS_ID,
            BusinessUserConstant::INPUT_NAME,
            BusinessUserConstant::INPUT_AUTHORITY,
            BusinessUserConstant::INPUT_STATUS,
        ]);
        $columns = [
            FIELD_ID,
            BusinessUserConstant::INPUT_OFFICES_ID,
            BusinessUserConstant::INPUT_REGIONS_ID,
            BusinessUserConstant::INPUT_DEPARTMENTS_ID,
            BusinessUserConstant::INPUT_USER_ID,
            BusinessUserConstant::INPUT_NAME,
            BusinessUserConstant::INPUT_STATUS,
            FIELD_UPDATED_AT
        ];
        $businessUsers = $this->businessUserRepository->getList($columns, $condition);
        $offices = $this->officeRepository->getList(OfficeConstant::COLUMNS_SELECT);
        $regions = $this->regionRepository->getList(RegionConstant::COLUMNS_SELECT);
        $departments = $this->departmentRepository->getList(DepartmentConstant::COLUMNS_SELECT);

        return view('page.user.business.list', compact('businessUsers', 'offices', 'regions', 'departments', 'condition'));
    }

    /**
     * View create business person.
     *
     * @return Factory|View
     */
    public function add()
    {
        $offices = $this->officeRepository->getList(OfficeConstant::COLUMNS_SELECT);
        $regions = $this->regionRepository->getList(RegionConstant::COLUMNS_SELECT);
        $departments = $this->departmentRepository->getList(DepartmentConstant::COLUMNS_SELECT);
        $salesPersons = $this->salesPersonRepository->getList(SalesPersonConstant::COLUMNS_SELECT);

        return view('page.user.business.create', compact('offices', 'regions', 'departments', 'salesPersons'));
    }

    /**
     * Create new business user.
     *
     * @param BusinessUserRequest $request
     *
     * @return RedirectResponse
     */
    public function create(BusinessUserRequest $request)
    {
        $input = $request->only([
            BusinessUserConstant::INPUT_AUTHORITY,
            BusinessUserConstant::INPUT_OFFICES_ID,
            BusinessUserConstant::INPUT_REGIONS_ID,
            BusinessUserConstant::INPUT_DEPARTMENTS_ID,
            BusinessUserConstant::INPUT_SALES_PERSONS_ID,
            BusinessUserConstant::INPUT_USER_ID,
            BusinessUserConstant::INPUT_NAME,
            BusinessUserConstant::INPUT_PASUWADO
        ]);
        $result = $this->businessUserRepository->create($input);
        if ($result) {
            return redirect()
                ->route('business_user.list')
                ->with(KEY_NOTIFICATION, __('message.business.user.create.success'));
        }

        return redirect()
            ->route('business_user.list')
            ->with(KEY_NOTIFICATION,  __('message.business.user.create.fail'));
    }

    /**
     * View update business user.
     *
     * @param $id
     *
     * @return Factory|View
     */
    public function edit($id)
    {
        $businessUser = $this->businessUserRepository->getDetail($id);
        if(!$businessUser) {
            return view('error.404');
        }

        $offices = $this->officeRepository->getList(OfficeConstant::COLUMNS_SELECT);
        $regions = $this->regionRepository->getList(RegionConstant::COLUMNS_SELECT);
        $departments = $this->departmentRepository->getList(DepartmentConstant::COLUMNS_SELECT);
        $salesPersons = $this->salesPersonRepository->getList(SalesPersonConstant::COLUMNS_SELECT);

        return view('page.user.business.update', compact('businessUser', 'offices', 'regions', 'departments', 'salesPersons'));
    }

    /**
     * Update business user.
     *
     * @param BusinessUserRequest $request
     * @param int $id
     *
     * @return RedirectResponse|Factory|View
     */
    public function update(BusinessUserRequest $request, int $id)
    {
        $businessPerson = $this->businessUserRepository->getDetail($id, [
            FIELD_ID,
            BusinessUserConstant::INPUT_USER_ID,
            BusinessUserConstant::INPUT_NAME,
            BusinessUserConstant::INPUT_AUTHORITY,
            BusinessUserConstant::INPUT_PASUWADO,
            BusinessUserConstant::INPUT_OFFICES_ID,
            BusinessUserConstant::INPUT_REGIONS_ID,
            BusinessUserConstant::INPUT_DEPARTMENTS_ID,
            BusinessUserConstant::INPUT_SALES_PERSONS_ID,
            BusinessUserConstant::INPUT_STATUS,
            FIELD_UPDATED_AT
        ]);
        if (!$businessPerson) {
            return view('error.404');
        }

        $input = $request->only([
            BusinessUserConstant::INPUT_USER_ID,
            BusinessUserConstant::INPUT_AUTHORITY,
            BusinessUserConstant::INPUT_NAME,
            BusinessUserConstant::INPUT_PASUWADO,
            BusinessUserConstant::INPUT_OFFICES_ID,
            BusinessUserConstant::INPUT_REGIONS_ID,
            BusinessUserConstant::INPUT_DEPARTMENTS_ID,
            BusinessUserConstant::INPUT_SALES_PERSONS_ID,
            BusinessUserConstant::INPUT_STATUS
        ]);
        $result = $this->businessUserRepository->update($businessPerson, $input);

        if ($result) {
            return redirect()
                ->route('business_user.list')
                ->with(KEY_NOTIFICATION, __('message.kddi.user.update.success'));
        }

        return redirect()
            ->back()
            ->with(KEY_NOTIFICATION, __('message.kddi.user.update.fail'));
    }

    /**
     * Delete business user.
     *
     * @param $id
     *
     * @return JsonResponse
     */
    public function delete(int $id)
    {
        $result = $this->businessUserRepository->delete($id);
        if ($result) {
            $response = response()->json([
                KEY_NOTIFICATION => __('message.business.user.delete.success')
            ]);
        } else {
            $response = response()->json([
                KEY_NOTIFICATION => __('message.business.user.delete.fail')
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response;
    }

    /**
     * View add CSV file.
     *
     * @return Factory|View
     */
    public function addCsv()
    {
        return view('page.user.add_csv');
    }

    /**
     * Dowload CSV file.
     *
     * @return CSV
     */
    public function downloadCsv()
    {
        try {
            $businessUsers = $this->businessUserRepository->getAll(array_keys(BusinessUserConstant::CSV_HEADER));
            $password = '';
            $bodyRows = [];
            foreach($businessUsers as $businessUser) {
                $bodyRows[] = [
                    $businessUser->id,
                    BusinessUserConstant::AUTHORITY[$businessUser->authority],
                    isset($businessUser->offices->name) ? $businessUser->offices->name : '',
                    isset($businessUser->regions) ? $businessUser->regions->name : '',
                    isset($businessUser->departments) ? $businessUser->departments->name : '',
                    isset($businessUser->salesPersons) ? $businessUser->salesPersons->name : '',
                    $businessUser->name,
                    $businessUser->user_id,
                    $password,
                    BusinessUserConstant::STATUS[$businessUser->status],
                    $businessUser->deleted_at
                ];
            }
            $export = new Export($bodyRows, array_values(BusinessUserConstant::CSV_HEADER));
            $fileName = 'business_users_file_'.date('YmdHis');
            return Excel::download($export, $fileName.'.csv');
        } catch (\Exception $exception) {
            Log::error('[ExportCsv]: ' . $exception->getMessage());
        }
    }

    /**
     * Upload CSV file.
     *
     * @return Factory|View
     */
    public function uploadCsv(ImportCsvFileRequest $request) 
    {
        try {
            HeadingRowFormatter::default('BusinessUser');
            $headings = (new HeadingRowImport)->toArray($request->file('file'));
            if(!empty(array_diff($headings[0][0], array_keys(BusinessUserConstant::CSV_HEADER))) || !empty(array_diff(array_keys(BusinessUserConstant::CSV_HEADER), $headings[0][0]))) {
                $error = new MessageBag();
                $error->getMessageBag()->add('file', __('validation.custom.csv.heading'));
                return back()->withInput()->withErrors($error);
            }
            $import = new BusinessUserImport(
                            new BusinessUserRepository,
                            new OfficeRepository,
                            new RegionRepository,
                            new DepartmentRepository,
                            new SalesPersonRepository
            );

            $import->import($request->file('file'));
            if (!$import->failures()->isEmpty()) {
                $error = new MessageBag();
                foreach ($import->failures() as $failure) {
                    foreach($failure->errors() as $err) {
                        $error->getMessageBag()->add('file', $failure->row().'行目'.$err);
                    }
                }
                return back()->withInput()->withErrors($error);
            }
            return redirect()
                ->route('business_user.list')
                ->with(KEY_NOTIFICATION, __('message.business.csv.success'));
        } catch (\Exception $exception) {
            Log::error('[ExportCsv]: ' . $exception->getMessage());
        }
    }
}

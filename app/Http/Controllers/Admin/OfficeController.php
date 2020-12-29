<?php

namespace App\Http\Controllers\Admin;

use App\Constants\OfficeConstant;
use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Repositories\OfficeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OfficeController extends Controller
{
    protected $officeRepository;

    public function __construct
    (
        OfficeRepository $officeRepository
    )
    {
        $this->officeRepository = $officeRepository;
    }

    /**
     * Show logo department.
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLogo($id)
    {
        $column = [
            FIELD_ID,
            OfficeConstant::INPUT_LOGO
        ];
        $office = $this->officeRepository->getDetail($id, $column);

        return view('page.office.logo', compact('office'));
    }

    /**
     * Upload logo department.
     *
     * @param $id
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadLogo($id, Request $request)
    {
        $input = $request->all();
        $office = $this->officeRepository->getDetail($id);
        if (!$office) {
            return view($this->notFoundPage);
        }
        Session::flash('error');
        if ($request->hasFile('logo')) {
            $filePath = FileHelper::storage($input['logo']);
            if (empty($filePath)) {
                return redirect()
                    ->back()
                    ->with(KEY_NOTIFICATION, __('message.error.update'));
            }
            $result = $this->officeRepository->update($office, [OfficeConstant::INPUT_LOGO => $filePath]);
            if ($result) {
                return redirect()
                    ->route('department.list')
                    ->with(KEY_NOTIFICATION, __('message.kddi.user.update.success'));
            }
        }

        return redirect()
            ->back()
            ->with(KEY_NOTIFICATION, __('message.kddi.user.update.fail'));
    }
}

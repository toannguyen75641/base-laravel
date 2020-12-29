<?php

namespace App\Http\Controllers\Admin;

use App\Constants\DepartmentConstant;
use App\Constants\OfficeConstant;
use App\Constants\RegionConstant;
use App\Http\Controllers\Controller;
use App\Repositories\DepartmentRepository;
use App\Repositories\OfficeRepository;
use App\Repositories\RegionRepository;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $officeRepository;
    protected $regionRepository;
    protected $departmentRepository;

    public function __construct
    (
        OfficeRepository $officeRepository,
        RegionRepository $regionRepository,
        DepartmentRepository $departmentRepository
    )
    {
        $this->officeRepository = $officeRepository;
        $this->regionRepository = $regionRepository;
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * View list of department.
     *
     * @param Request $request
     *
     * @return Factory|View
     */
    public function getList(Request $request)
    {
        $condition = $request->only([
            RegionConstant::INPUT_OFFICES_ID,
            OfficeConstant::INPUT_CODE,
            DepartmentConstant::INPUT_REGIONS_ID,
            DepartmentConstant::INPUT_ID,
            OfficeConstant::INPUT_NAME
        ]);
        $offices = $this->officeRepository->getList(OfficeConstant::COLUMNS_SELECT);
        $regions = $this->regionRepository->getList(RegionConstant::COLUMNS_SELECT);
        $departments = $this->departmentRepository->getList(DepartmentConstant::COLUMNS_SELECT, $condition);

        return view('page.user.department.list', compact('offices', 'regions', 'departments', 'condition'));
    }

    /**
     * View update department.
     *
     * @param $id
     *
     * @return Factory|View
     */
    public function edit($id)
    {

    }

    /**
     * Delete department.
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $result = $this->departmentRepository->delete($id);
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
}

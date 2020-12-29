<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AdminUserConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUserRequest;
use App\Repositories\AdminUserRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    protected $adminUserRepository;

    /**
     * AdminUserController constructor.
     *
     * @param AdminUserRepository $adminUserRepository
     */
    public function __construct(AdminUserRepository $adminUserRepository)
    {
        $this->adminUserRepository = $adminUserRepository;
    }

    /**
     * View list of admin users.
     *
     * @param Request $request
     *
     * @return Factory|View
     */
    public function getList(Request $request)
    {
        $condition = $request->only([
            AdminUserConstant::INPUT_USER_ID,
            AdminUserConstant::INPUT_NAME,
            AdminUserConstant::INPUT_STATUS
        ]);
        $columns = [
            FIELD_ID,
            AdminUserConstant::INPUT_USER_ID,
            AdminUserConstant::INPUT_NAME,
            AdminUserConstant::INPUT_STATUS,
            FIELD_UPDATED_AT,
            AdminUserConstant::INPUT_DELETE_AT
        ];
        $adminUsers = $this->adminUserRepository->getList($columns, $condition);
        $authId = Auth::id();

        return view('page.user.admin.list', compact('adminUsers', 'condition', 'authId'));
    }

    /**
     * View create admin user.
     *
     * @return Factory|View
     */
    public function add()
    {
        return view('page.user.admin.create');
    }

    /**
     * Create admin user.
     *
     * @param AdminUserRequest $request
     *
     * @return RedirectResponse
     */
    public function create(AdminUserRequest $request)
    {
        $input = $request->only([
            AdminUserConstant::INPUT_USER_ID,
            AdminUserConstant::INPUT_NAME,
            AdminUserConstant::INPUT_PASUWADO
        ]);

        $result = $this->adminUserRepository->create($input);
        if ($result) {
            return redirect()
                ->route('admin_user.list')
                ->with(KEY_NOTIFICATION, __('message.kddi.user.create.success'));
        }

        return redirect()
            ->back()
            ->with(KEY_NOTIFICATION, __('message.kddi.user.create.fail'));
    }

    /**
     * View update admin user.
     *
     * @param $id
     *
     * @return Factory|View
     */
    public function edit($id)
    {
        $adminUser = $this->adminUserRepository->getDetail($id, [
            FIELD_ID,
            AdminUserConstant::INPUT_USER_ID,
            AdminUserConstant::INPUT_NAME,
            AdminUserConstant::INPUT_STATUS,
        ]);
        if (!$adminUser) {
            return view('error.404');
        }

        return view('page.user.admin.update', compact('adminUser'));
    }

    /**
     * Update admin user.
     *
     * @param int $id
     * @param AdminUserRequest $request
     *
     * @return RedirectResponse|Factory|View
     */
    public function update(int $id, AdminUserRequest $request)
    {
        // Check if admin user is exists
        $adminUser = $this->adminUserRepository->getDetail($id, [
            FIELD_ID,
            AdminUserConstant::INPUT_USER_ID,
            AdminUserConstant::INPUT_NAME,
            AdminUserConstant::INPUT_STATUS,
            AdminUserConstant::INPUT_PASUWADO,
            FIELD_UPDATED_AT
        ]);
        if (!$adminUser) {
            return view('error.404');
        }

        $input = $request->only([
            AdminUserConstant::INPUT_USER_ID,
            AdminUserConstant::INPUT_NAME,
            AdminUserConstant::INPUT_STATUS,
            AdminUserConstant::INPUT_PASUWADO
        ]);

        $result = $this->adminUserRepository->update($adminUser, $input);
        if ($result) {
            return redirect()
                ->route('admin_user.list')
                ->with(KEY_NOTIFICATION, __('message.kddi.user.update.success'));
        }

        return redirect()
            ->back()
            ->with(KEY_NOTIFICATION, __('message.kddi.user.update.fail'));
    }

    /**
     * Delete admin user.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id)
    {
        $auth = Auth::user();
        $result = $this->adminUserRepository->delete($id, $auth);
        if ($result) {
            $response = response()->json([
                KEY_NOTIFICATION => __('message.kddi.user.delete.success')
            ]);
        } else {
            $response = response()->json([
                KEY_NOTIFICATION => __('message.kddi.user.delete.fail')
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response;
    }
}

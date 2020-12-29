<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AdminUserConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\AdminUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\Factory;
use Illuminate\View\View;

class AuthController extends Controller
{
    protected $modelAdmin;

    public function __construct(AdminUser $modelAdmin)
    {
        $this->modelAdmin = $modelAdmin;
    }
    /**
     * View login.
     *
     * @return Factory|View|RedirectResponse
     */
    public function viewLogin()
    {
        if (Auth::user()) {
            return redirect()->route('dashboard');
        }

        return view('page.auth.login');
    }

    /**
     * Login.
     *
     * @param Request $request
     *
     * @return Factory|View
     */
    public function login(Request $request)
    {
        $data = $request->only('user_id', 'password');
        $validateUser = $this->checkLoginValidation(null, 'user_id', $data);
        if (!empty($validateUser)) {
            return view('page.auth.login', ['errors' => $validateUser]);
        }
        $getAdmin = $this->modelAdmin->getAdmin($data['user_id']);
        if ($getAdmin == null ) {
            $errors = [__('message.error.not_found.admin')];

            return view('page.auth.login', ['errors' => $errors]);
        }
        $adminId = $getAdmin->id;
        if ($getAdmin->status == AdminUserConstant::STATUS_INACTIVE) {
            $error = [ __('message.error.not_found.lock_admin')];

            return view('page.auth.login', ['errors' => $error]);
        }
        if ($getAdmin->locked == AdminUserConstant::LOCK) {
            $checkLock = $this->checkLockLogin($getAdmin);
            if (!empty($checkLock)) {
                return view('page.auth.login', ['errors' => $checkLock]);
            }
        }
        $validatePass = $this->checkLoginValidation($getAdmin, 'password', $data);
        if (!empty($validatePass)) {
            return view('page.auth.login', ['errors' => $validatePass]);
        }
        if (!Hash::check($data['password'], $getAdmin->password)) {
            $this->updateFailedCount($getAdmin, $adminId);
            $errors = [__('message.error.not_found.user_password')];

            return view('page.auth.login', ['errors' => $errors]);
        }
        if (!Auth::attempt($data)) {
            $error = [__('message.error.not_found.user_password'),];

            return view('page.auth.login', ['errors' => $error]);
        }
        $adminUpdate = [
            'last_login_date' => now(),
            'failed_count' => AdminUserConstant::DEFAULT_FAILED_COUNT
        ];
        $this->modelAdmin->updateAdmin($adminUpdate, $adminId);

        return redirect('/admin');
    }

    private function checkLockLogin($getAdmin)
    {
        $error = [];
        $dateLock = date('Y-m-d H:i:s', strtotime('+30 minutes', strtotime($getAdmin->lock_date)));
        if (now() > $dateLock) {
            $adminUpdate = [
                'locked' => AdminUserConstant::UNLOCK
            ];

            $this->modelAdmin->updateAdmin($adminUpdate, $getAdmin->id);
        } else {
            $error = [
                __('message.error.not_found.admin_password'),
                __('message.error.not_found.admin_password_30'),
            ];
        }

        return $error;
    }

    private function checkLoginValidation($getAdmin, $request, $data)
    {
        $rules = [];
        $mess = [];
        $errors = [];
        if ($request == 'user_id') {
            $rules = ['user_id' => 'required|min:1|max:30'];
            $mess = [
                'user_id.required' => __('message.error.required.admin_user_id'),
                'user_id.min' => __('message.error.min_max.admin_user_id'),
                'user_id.max' => __('message.error.min_max.admin_user_id')
            ];
        }
        if ($request == 'password') {
            $rules = [
                'password' => [ 'required','min:8',
                    'regex:/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z0-9]*$/']
            ];
            $mess = [
                'password.required' => __('message.error.required.admin_password'),
                'password.min' => __('message.error.min_max.admin_password'),
                'password.regex' => __('message.error.regex.admin_password'),
            ];
        }
        $validator = Validator::make($data, $rules, $mess);
        if ($validator->fails()) {
            if ($getAdmin != null) {
                $this->updateFailedCount($getAdmin, $getAdmin->id);
            }
            $errors = $validator->errors()->all();

        }

        return $errors;
    }

    private function updateFailedCount($getAdmin, $adminId)
    {
        $adminUpdate = [
            'failed_count' => $getAdmin->failed_count + 1
        ];

        if ($getAdmin->failed_count >= (AdminUserConstant::QUANTITY_OF_LOGIN_FAILED - 1)) {
            $adminUpdate = array_merge($adminUpdate,  [
                'locked' => AdminUserConstant::LOCK,
                'lock_date' => now(),
                'failed_count' => AdminUserConstant::DEFAULT_FAILED_COUNT
            ]);
        }
        return $this->modelAdmin->updateAdmin($adminUpdate, $adminId);
    }

    /**
     * Logout.
     *
     * @return Factory|View
     */
    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }

    /**
     * View change password.
     *
     * @return Factory|View
     */
    public function setting()
    {
        return view('page.auth.change-password');
    }

    /**
     * Change password.
     *
     * @param ChangePasswordRequest $request
     *
     * @return Factory|View
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $data = $request->only('old_password', 'new_password', 'new_password_confirm');
        $admin = Auth::user();
        $adminId  = $admin->id;

        $adminUpdate = ['password' => Hash::make($data['new_password'])];
        $this->modelAdmin->updateAdmin($adminUpdate, $adminId);

        return view('page.auth.change-password', ['message' => __('message.success.change_password')]);
    }
}

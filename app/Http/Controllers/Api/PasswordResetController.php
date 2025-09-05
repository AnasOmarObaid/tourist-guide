<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PasswordResetService;
use App\Traits\RequestRulesTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PasswordResetController extends Controller
{
    use ResponseTrait, RequestRulesTrait;

    protected PasswordResetService $reset_password_service;

    public function __construct(PasswordResetService $reset_password_service)
    {
        $this->reset_password_service = $reset_password_service;
    }

    /**
     * sendCode
     *
     * @param  Request $request
     * @return Response|ResponseTrait
     */
    public function sendCode(Request $request): Response|ResponseTrait
    {
        try {

            // validate the email input
            $validator = $this->apiValidationHandel($request, $this->sendPasswordResetCodeRules());

            if ($validator)
                return $this->errorResponse('The request cannot be fulfilled due to bad syntax.', $validator->errors(), 422);

            // check if there is user
            $user = $this->reset_password_service->thereIsUser($request);

            if (!$user)
                return $this->errorResponse('There is no user with this email. try with correct account', null, 404);

            // now there is account with this email, so send code to reset password
            $this->reset_password_service->sendPasswordResetCode($user, $request);

            return $this->successResponse('A reset password code has been sent to your email.', null, 200);

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e, 400);
        }
    }

    /**
     * reset
     *
     * @param  Request $request
     * @return Response|ResponseTrait
     */
    public function reset(Request $request): Response|ResponseTrait
    {
        // validate the request
        $validator = $this->apiValidationHandel($request, $this->passwordResetRules());

        if ($validator)
            return $this->errorResponse('The request cannot be fulfilled due to bad syntax.', $validator->errors(), 422);

        // reset the password
        $is_reset = $this->reset_password_service->resetPassword($request);

        if (!$is_reset)
            return $this->errorResponse('The reset password code is invalid or has expired, tray again !', null, 404);

        return $this->successResponse('Your password has been reset successfully.', null, 200);
    }
}

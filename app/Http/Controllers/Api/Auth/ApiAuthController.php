<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Services\AuthService;
use App\Traits\ResponseTrait;
use App\Traits\RequestRulesTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Exception;

class ApiAuthController extends Controller

{
    use ResponseTrait, RequestRulesTrait;

    protected AuthService $auth_service;

    public function __construct(AuthService $auth_service)
    {
        $this->auth_service = $auth_service;
    }

    /**
     * login
     *
     * @param  Request $request
     * @return Response|Response
     */
    public function login(Request $request): Response|ResponseTrait
    {
        try {

            // validate the request
            $validator = $this->apiValidationHandel($request, $this->loginRules());

            if ($validator)
                return $this->errorResponse('The request cannot be fulfilled due to bad syntax.', $validator->errors()->toArray(), 422);

            // attempt to login
            $credentials = $request->only('email', 'password');

            // call attemptLogin
            $user = $this->auth_service->attemptLogin($credentials, false);

            // check if theres no user
            if (!$user)
                return $this->errorResponse('Unauthorized', 'Invalid credentials. try again !', $code = 401);

            // delete old tokens (optional, if we want only 1 session per user)
            $user->tokens()->delete();

            // make token for this user
            $token = $user->createToken('auth_token')->plainTextToken;

            // make collection for user
            $data = [
                'token' => $token,
                'user' => UserCollection::make($user)->resolve()
            ];

            return $this->successResponse('User login successfully', $data, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e, 400);
        }
    } //-- end login function

    /**
     * register
     *
     * @param  Request $request
     * @return Response|ResponseTrait
     */
    public function register(Request $request): Response|ResponseTrait
    {
        try {

            // validate the request
            $validator = $this->apiValidationHandel($request, $this->registerRules());

            if ($validator)
                return $this->errorResponse('The request cannot be fulfilled due to bad syntax.', $validator->errors()->toArray(), 422);

            // register the user
            $credentials = $request->only('full_name', 'email', 'password');

            $user = $this->auth_service->register($credentials);

            if (!$user)
                return $this->errorResponse('User registration failed', 'Unable to register user at this time', 500);

            // create token for the user
            $token = $user->createToken('auth_token')->plainTextToken;

            // make collection for user
            $data = [
                'token' => $token,
                'user' => UserCollection::make($user)->resolve()
            ];

            return $this->successResponse('User registered successfully', $data, 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e, 400);
        }
    }

    /**
     * verify
     *
     * @param  Request $request
     * @return Response|ResponseTrait
     */
    public function verify(Request $request): Response|ResponseTrait
    {
        try {
            // validate the code that comes from request
            $validator = $this->apiValidationHandel($request, $this->verifyEmailRules());

            if ($validator)
                return $this->errorResponse('The request cannot be fulfilled due to bad syntax.', $validator->errors()->toArray(), 422);

            // call verifyEmail
            $is_verified = $this->auth_service->verifyEmail(Auth::guard('sanctum')->user(), $request);

            if (!$is_verified)
                return $this->errorResponse('Expired verification code. Please try again.', null, 422);

            return $this->successResponse('Email verified successfully.', null, 200);

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e, 400);
        }
    }

    /**
     * resend
     *
     * @return Response|ResponseTrait
     */
    public function resend(): Response|ResponseTrait
    {
        try{
            // resend verify email
            $this->auth_service->resendVerifyEmail(Auth::guard('sanctum')->user());

            // return success message
            return $this->successResponse('Verification code resent successfully.', null, 200);

        }catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e, 400);
        }
    }

    /**
     * logout
     *
     * @return Response|ResponseTrait
     */
    public function logout(): Response|ResponseTrait
    {
        try {
            // Revoke the token that was used to authenticate the current request
            Auth::guard('sanctum')->user()->currentAccessToken()->delete();
            return $this->successResponse('User logged out successfully', null, 200);

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e, 400);
        }
    } //-- end logout function

}//-- End ApiAuthController class

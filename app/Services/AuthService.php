<?php

namespace App\Services;

use App\Models\EmailVerification;
use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\ResetPasswordCodeNotification;
use App\Notifications\SendEmailVerificationCode;
use App\Traits\ResponseTrait;
use App\Traits\RequestRulesTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidatorResponse;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    use ResponseTrait, RequestRulesTrait;

    /**
     * attemptLogin
     *
     * @param  array $credentials
     * @param  bool $is_admin
     * @return User|null
     */
    public function attemptLogin(array $credentials, bool $is_admin): ?User
    {

        $user = User::where(['email' => $credentials['email'], 'is_admin' => $is_admin])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password))
            return null;

        return $user;
    }

    /**
     * register
     *
     * @param  array $credentials
     * @return User|null
     */
    public function register(array $credentials): User|null
    {

        // create user
        $user = User::create([
            'full_name' => $credentials['full_name'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password'])
        ]);

        // Send Email Verification Code
        $this->sendEmailVerificationCode($user);

        return $user;
    }

    /**
     * sendEmailVerificationCode
     *
     * @param  User $user
     * @return void
     */
    protected function sendEmailVerificationCode(User $user): void
    {
        // get random code
        $code = rand(1000, 9999);

        EmailVerification::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(10)
        ]);

        // send email verification code to user
        $user->notify(new SendEmailVerificationCode($code, $user->full_name));
    }

    /**
     * verifyEmail
     *
     * @param  User $user
     * @param  Request $request
     * @return bool
     */
    public function verifyEmail(User $user, Request $request) : bool
    {
        // get the code for auth user
        $verification = EmailVerification::where('user_id', $user->id)
            ->where('code', $request->code)
            ->latest()
            ->first();

        if (!$verification or $verification->isExpired()){
            $verification?->delete();
            return false;
        }

        // mark email as verified
        $user->markEmailAsVerified();

        // delete the code from database
        $verification->delete();

        return true;
    }

    /**
     * resendVerifyEmail
     *
     * @param  User $user
     * @return void
     */
    public function resendVerifyEmail(User $user): void
    {
        // delete the old code if exists
        EmailVerification::where('user_id', $user->id)?->delete();

        // send verify email code
        $this->sendEmailVerificationCode($user);
    }

}

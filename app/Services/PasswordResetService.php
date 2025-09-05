<?php

namespace App\Services;

use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\ResetPasswordCodeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Mockery\Generator\StringManipulation\Pass\Pass;

class PasswordResetService
{
    /**
     * sendPasswordResetCode
     *
     * @param  User $user
     * @param  Request $request
     * @return void
     */
    public function sendPasswordResetCode(User $user, Request $request): void
    {
        // make random code
        $code = rand(1000, 9999);

        // delete the old code for this email
        PasswordReset::where('email', $request->email)?->delete();

        // store the code in database
        PasswordReset::create([
            'email' => $user->email,
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
        ]);

        // send the email
        $user->notify(new ResetPasswordCodeNotification($code));
    }

    /**
     * resetPassword
     *
     * @param  Request $request
     * @return bool
     */
    public function resetPassword(Request $request): bool
    {

         // check if the user is exist or not
        $user = $this->thereIsUser($request);
        if (!$user)
            return false;

        // get the reset code
        $reset_code = PasswordReset::where(['code' => $request->code, 'email' => $request->email])->latest()->first();

        if (!$reset_code or $reset_code->isExpired()) {
            $reset_code?->delete();
            return false;
        }

        // password update
        $this->passwordUpdate($user, $request);

        // delete the code after reset the password
        $reset_code?->delete();

        return true;
    }


    /**
     * thereIsUser
     *
     * @param  Request $request
     * @return User|bool
     */
    public function thereIsUser(Request $request): User | bool
    {
        return User::where('email', $request->email)->first() ?? false;
    }

    /**
     * passwordUpdate
     *
     * @param  User $user
     * @param  Request $request
     * @return void
     */
    public function passwordUpdate(User $user, Request $request): void
    {
        $user->password = Hash::make($request->password);

        $user->save();
    }
}

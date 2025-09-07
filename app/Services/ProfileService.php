<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;

class ProfileService
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Update user profile
     *
     * @param User $user
     * @param array $data
     * @param UploadedFile|null $image
     * @return User
     * @throws ValidationException
     */
    public function updateProfile(User $user, array $credentials, Request $request): User
    {

        // Update user basic information (excluding password and is_admin)
        $credentials = collect($credentials)->toArray();

        $user->update($credentials);

        // Handle image upload if provided
        if($request->hasFile('image'))
            $this->imageService->update($request, $user, 'users');

        return $user->fresh();
    }

    /**
     * Update user password
     *
     * @param User $user
     * @param string $currentPassword
     * @param string $newPassword
     * @return User
     * @throws ValidationException
     */
    public function updatePassword(User $user, string $currentPassword, string $newPassword): User
    {
        // Verify current password
        if (!Hash::check($currentPassword, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The current password is incorrect.']
            ]);
        }

        // Validate new password
        $validator = Validator::make(['password' => $newPassword], [
            'password' => ['required', Rules\Password::defaults()]
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Update password
        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        return $user->fresh();
    }

}

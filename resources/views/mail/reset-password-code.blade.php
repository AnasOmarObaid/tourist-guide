<x-mail::message>
{{-- Header --}}
# 🔑 Password Reset Request

Hello **{{ $user->full_name }}**,

Use the code below to reset your password:

<x-mail::panel>
# 🔐 Your Verification Code
## {{ $code }}
</x-mail::panel>


---

This code will expire in **10 minutes**.
If you didn’t request a password reset, ignore this email.

<x-mail::button :url="config('app.url')">
Open {{ config('app.name') }}
</x-mail::button>

Thanks for trusting us,
The **{{ config('app.name') }}** Team

</x-mail::message>

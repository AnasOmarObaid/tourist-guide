<x-mail::message>
{{-- Header --}}
# 👋 Welcome to {{ config('app.name') }}

Hello **{{ $full_name }}**,
Thanks for joining our community! 🚀

---

<x-mail::panel>
# 🔐 Your Verification Code
## {{ $code }}
</x-mail::panel>


---

This code is valid for **10 minutes**.
Please enter it in the app to verify your email address.

If you didn’t request this, you can safely ignore this email.

<x-mail::button :url="config('app.url')">
Open {{ config('app.name') }}
</x-mail::button>

Thanks for trusting us,
The **{{ config('app.name') }}** Team
</x-mail::message>

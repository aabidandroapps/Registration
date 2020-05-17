@component('mail::message')
# Hello {{ $user }} Welcome,

This is your OTP {{ $otp }}.
Please don't share with anyone.


Thanks,<br>
{{ config('app.name') }}
@endcomponent

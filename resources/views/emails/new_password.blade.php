@component('mail::message')
# Password Changed!

Hello {{ $user->name }},

Your account password has been successfully changed. Here are your new credentials:

@component('mail::panel')
**Email:** {{ $user->email }}  
**Password:** {{ $password }}
@endcomponent

> Please make sure to change your password regularly.

@component('mail::button', ['url' => url('/login')])
Login Now
@endcomponent

Thanks,<br>
**QuickPick : Automated Pre-Enlistment System**
@endcomponent

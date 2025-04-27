@component('mail::message')
# Welcome to QuickPick!

Hello {{ $user->name }},

Your account has been successfully created. Here are your credentials:

@component('mail::panel')
**Email:** {{ $user->email }}  
**Password:** {{ $password }}
@endcomponent

> Please make sure to change your password after your first login.

@component('mail::button', ['url' => url('/login')])
Login Now
@endcomponent

Thanks,<br>
**QuickPick : Automated Pre-Enlistment System**
@endcomponent

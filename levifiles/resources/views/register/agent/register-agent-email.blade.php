<h3>Holidayku.com</h3>

Hello {{ $username }}<br>
Please activate your account by click below link<br><br>

<a href="{{ url('register/agent/activation') . '?key='. $activatedLink }}">Click For Activation</a>
<br>

Login after activation<br>
username : {{ $username }}<br>
password : {{ $newPassword }}<br>

Note.<br>
<small>
This email is auto sender, please do not reply this email</small>

<x-mail::message>
# Password Diatur Ulang

Password Akun Anda Berhasil Diatur Ulang

<x-mail::panel>
ID Login : <b>{{ $user->email . ' | ' . $user->username }}</b><br>
Password : <b>{{ $new_password }}</b>
</x-mail::panel>

<x-mail::button :url="$url" color='primary'>
Masuk
</x-mail::button>

Harap ingat kredensial akun Anda!

Terimakasih,<br>
{{ config('app.name') }}
</x-mail::message>

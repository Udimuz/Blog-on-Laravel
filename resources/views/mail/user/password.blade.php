<x-mail::message>
    Пароль для пользователя {{ $username }}
    <br>{{ $password }}

    С благодарностью,
    {{ config('app.name') }}
</x-mail::message>

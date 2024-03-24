<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecimiento de contraseña</title>
    <style>
        @import url('https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css');
    </style>
</head>
<body>
    <div class="bg-gray-100 p-6 rounded-lg shadow-2xl">
        <h1 class="text-center text-2xl font-semibold mb-4 text-gray-900">Restablecimiento de contraseña</h1>
        <p class="text-gray-600 leading-relaxed">
            Hola {{ $user->name }},
        </p>
        <p class="text-gray-600 leading-relaxed">
            Has solicitado restablecer tu contraseña para tu cuenta en {{ config('app.name') }}.
        </p>
        <p class="text-gray-600 leading-relaxed">
            Para restablecer tu contraseña, haz clic en el siguiente enlace:
        </p>
        <a href="{{ env('FRONTEND_URL') }}/password-reset/?token={{ $user->token  }}" class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-lg font-semibold">
            Restablecer contraseña
        </a>
        <p class="text-gray-600 leading-relaxed mt-4">
            Este enlace solo es válido por {{ config('auth.passwords.users.reset_token_lifetime') }} minutos.
        </p>
        <p class="text-gray-600 leading-relaxed">
            Si no has solicitado restablecer tu contraseña, ignora este correo electrónico.
        </p>
        <p class="text-gray-600 leading-relaxed mt-4">
            Atentamente,
        </p>
        <p class="text-gray-600 leading-relaxed">
            {{ config('app.name') }}
        </p>
    </div>
</body>
</html>

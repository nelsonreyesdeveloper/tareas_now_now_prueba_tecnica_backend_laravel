<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Correo Electrónico</title>
    <style>
        @import url('https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css');
    </style>
</head>
<body>
    <div class="bg-gray-100 p-6 rounded-lg shadow-2xl">
        <h2 class="text-center text-2xl font-semibold mb-4 text-gray-900">Now Now | Nelson Reyes Prueba Tecnica</h2>
        <p class="text-gray-600 leading-relaxed">
            Hola <span class="font-semibold text-gray-700">{{$data['name']}}</span> ,

            Este es un correo electrónico te noticamos que un super administrador creo una cuenta con tu email.
        </p>

        <br>
        <p class="text-gray-600 leading-relaxed">
            <span class="font-semibold text-gray-700" >Email:</span>  {{$data['email']}} <br>
            <span class="font-semibold text-gray-700" >Contraseña Temporal:</span> {{ $data['contrasena-temporal']}}<br>
            <span class="font-semibold text-gray-700" >Tipo de Cuenta:</span> {{$data['tipo-rol']}}
        </p>
        <br>
        <a href="{{ env('FRONTEND_URL') }}?user={{ $data['email'] }}&password={{$data['contrasena-temporal'] }"class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-lg font-semibold">
            Haz clic aquí para acceder al sistema.
        </a>
    </div>
</body>
</html>
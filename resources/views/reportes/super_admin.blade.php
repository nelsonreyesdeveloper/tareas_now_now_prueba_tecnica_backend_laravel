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

            En Este correo te notificamos que acabas de generar un nuevo reporte de la fecha {{$data['fecha_inicio']}} a {{$data['fecha_fin']}}.
        </p>

       
    </div>
</body>
</html>
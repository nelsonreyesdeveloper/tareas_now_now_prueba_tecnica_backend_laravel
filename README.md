# BackEnd Laravel Now Now

## Pasos para la implementacion 

- Paso 1 :  debemos clonar el repositorio a nuestro servidor local

- Paso 2 : Debemos crear un archivo .env y configurarlo tomando como ejemplo .env.example 

- Paso 2 : Debemos comprobar que APP_URL=http://localhost:8000 FRONTEND_URL=http://localhost:5173 esten de acuerdo a nuestro servidor local. 

- Paso 2 : Para el envio de emails de PRUEBA podemos configurar las siguientes variables de entorno:

MAIL_MAILER=smtp

MAIL_HOST=sandbox.smtp.mailtrap.io

MAIL_PORT=2525

MAIL_USERNAME= *user*  ->aqui debe de ir la de nuestra cuenta de mailtrap

MAIL_PASSWORD= *password* ->aqui debe de ir la de nuestra cuenta de mailtrap

- Paso 3 : Debemos configurar correctamente nuesta base de datos local : 

DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=prueba-tecnica-now-now   ->Nuestra BD

DB_USERNAME=root  -> Nuestro user de acceso a mysql

DB_PASSWORD=    ->nuestro password en caso de tener


- Paso 4 : Debemos ejecutar el comando: php artisan storage:link 

- Paso 5 : Debemos ejecutar las migraciones con : php artisan migrate

- Paso 6 : Debemos ejecutar el comando : php artisan db:seed    
-> esto nos dara un administrador por default que es  email: admin@gmail.com  password : 12345678 que tiene permisos de super usuarios, ademas creara 200 usuarios adicionales para poder ver el comportamiento del sistema con varios usuarios estos usuarios tendran roles de super-admin y roles de empleado de forma random, ademas se crearan 200 tareas asignadas aleatoriamente a los usuarios.

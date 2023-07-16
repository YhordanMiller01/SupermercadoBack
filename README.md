## Acerca de la prueba
Prueba Back (OrusSystem)
Esta es una prueba backend para construir un api rest, que nos permita realizar procesos para un supermercado


## Pre-requisitos

1. Php 7.4.* con phpCli habilitado para la ejecución de comando.
2. Mysql
3. Composer
4. Extensión pdo_pgsql habilitada.

## Instalación

1. Clonar el repositorio en la carperta del servidor web.
2. por HTTPS git clone git@github.com/YhordanMiller01/SupermercadoBack.git
3. Por Ssh git clone git@github.com:YhordanMiller01/SupermercadoBack.git


Instalar paquetes.
composer install


Configurar archivo .env

Configure las variables de entorno para base de datos
1. DB_HOST= Variable de entorno para el host de BD.
2. DB_PORT= Variable de entorno para el puerto de BD.
3. DB_DATABASE= Variable de entorno para el nombre de BD.
4. DB_USERNAME= Variable de entorno para el usuario de BD.
5. DB_PASSWORD= Variable de entorno para la contraseña de BD.

### En la raíz del sitio ejecutar.

1. php artisan key:generate Genera la llave para el cifrado del proyecto.
2. composer install Instala dependencias de PHP
3. php artisan migrate:refresh --seed Ejecuta migraciones y seeders
4. php artisan serve Para correr el proyecto

## Proceso



1. Se pueden crear frutas
2. Se pueden editar frutas
3. Se pueden eliminar frutas
4. Se pueden buscar todos las  frutas registrados
5. Se pueden crear pedidos

## Nota
En la carpeta EndPoints esta el .json, creado en Postman para los diferentes endpoints.


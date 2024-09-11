# Backend: Capi Examen José Adrián Martínez Sánchez

## Descripción

Este es el backend de la aplicación de libreta de direcciones, desarrollado utilizando Laravel. La API proporciona endpoints para gestionar contactos, incluyendo operaciones CRUD para agregar, editar, eliminar y obtener detalles de contactos. La API también permite la búsqueda y filtrado de contactos.

## Requisitos

- *PHP*: Versión 8.0 o superior. PHP es el lenguaje de programación utilizado para el backend.
- *Laravel*: Versión 11.0 o superior.
- *Composer*: Versión 2.x o superior. Composer es el gestor de dependencias de PHP utilizado para instalar las dependencias del proyecto.
- *MySQL*: La base de datos utilizada por la aplicación. Asegúrate de tener una base de datos MySQL configurada y accesible.

## Instalación y Ejecución

### 1. Clonar el Repositorio

Primero, clona el repositorio desde GitHub a tu máquina local. Abre una terminal y ejecuta el siguiente comando:

```bash
git clone https://github.com/Adrian12348/capi_examen_back.git
```
Instalar dependencias 
composer install

Configuración del Archivo .env
cp .env.example .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_base_de_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña

Generar Clave de Aplicación
php artisan key:generate

Migraciones y Seeders
php artisan migrate
php artisan db:seed

Iniciar el Servidor de Desarrollo
php artisan serve

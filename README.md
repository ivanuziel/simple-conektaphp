# Conekta API - PHP
Ejemplo desarrollado en laravel versión 8.*

### Paquetes utilizados

| Package | README |
| ------ | ------ |
| conekta/conekta-php | https://github.com/conekta/conekta-php |

## Instalación del sistema
- Renombrar el archivo `.env.example` a `.env` 
- Configuración de la base de datos en el archivo `.env`.
- Configuración de variable `CONEKTA_API_SECRET` y `CONEKTA_API_PUBLIC` en el archivo `.env`
- Ejecutar los siguientes comandos en la terminal situándote dentro la carpeta del proyecto:

```sh
$ composer install
$ npm install
$ php artisan key:generate
$ php artisan migrate
```

## Estructura del Proyecto


## Notas del proyecto

- El proyecto inicia con un enlace que redirige a una ruta de prueba la cual crea un usuario y un producto simple en la base de datos `http://localhost:3000/demo/login`

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
| Ruta | Descripción |
| ------ | ------ |
| app/Conekta/Billable | Trait aplicable sobre entidades que se pueden comprar (representa la orden de compra) |
| app/Conekta/Customer | Trait aplicable sobre la entidad que representa al comprador |
| app/Conekta/Payment | Clase que construye los objetos de Conekta para realizar el pago |
| app/event/ProcessPurchase.php | Evento que procesa los datos de pagos y hace conexión con conekta |
| resources/js/components/ConektaCardPayment.vue | Componente de vue js para imprimir el formulario de pago con tarjeta, tokenizarla y hacer la petición al servidor |
| resources/js/components/ConektaOxxoPayment.vue | Componente de vue js para hacer la petición de pago al servidor e imprimir el comprobante de pago |

## Notas del proyecto

- El proyecto inicia con un enlace que redirige a una ruta de prueba la cual crea un usuario y un producto simple en la base de datos `http://localhost:3000/demo/login`
- El proyecto cuenta con un endpoint de prueba para llamar al evento de procesamiento `App\Events\ProcessPurchase` en el controlador `PaymentController@charge`

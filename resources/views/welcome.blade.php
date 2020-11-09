<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <script type="text/javascript" data-conekta-public-key="{{ config('conekta.public_key') }}" src="https://cdn.conekta.io/js/latest/conekta.js"></script>

    </head>
    <body>

        @if(\Auth::guest())
            <a href="{{ route('demo.login') }}">Demo CONEKTA APP</a>
        @else
            <div id="app">
                <div class="container">
                    <span>Ejemplo Formulario de pago</span>
                    <hr>
                    <div>
                        <label>Concepto de pago:</label>
                        <span v-text="order.subject"></span>
                    </div>

                    <div>
                        <label>Tipo de bien:</label>
                        <span v-text="order.meta.asset"></span>
                    </div>

                    <div>
                        <label>ID del evento:</label>
                        <span v-text="order.id"></span>
                    </div>

                    <div>
                        <label>Importe del servicio: </label>
                        <span v-text="order.total"></span>
                    </div>

                    <div>
                        <label>Fecha de adjudicación:</label>
                        <span v-text="order.meta.date_award"></span>
                    </div>

                    <div>
                        <label>Hora de adjudicación:</label>
                        <span v-text="order.meta.hour_award"></span>
                    </div>

                    <div>
                        <label>Huso-horario deseado:</label>
                        <span v-text="order.meta.timezone"></span>
                    </div>
                    <hr>
                    <p>Seleccione un método de pago:</p>
                    <br>
                    <a href="" @click.prevent="paymentMethod = 'conekta-card-payment'">Tarjeta</a>
                    <a href="" @click.prevent="paymentMethod = 'conekta-oxxo-payment'">Oxxo</a>
                    <br><br>

                    <component :is="paymentMethod"
                    :order="order"
                    payment_callback="{{ route('payment.charge') }}"
                    ></component>

                    <br>
                    <br>
                    <label>Teléfono</label>
                    <input type="text" :value="order.meta.phone" name="teléfono">
                    <br><br>
                    <button @click.prevent="pay()">Pagar</button>
                </div>
            </div>
        @endif

        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>

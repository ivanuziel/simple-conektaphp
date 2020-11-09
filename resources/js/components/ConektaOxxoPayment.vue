<template>
    <div>
    	<div v-if="response.status == 'success'" class="opps">
			<div class="opps-header">
				<div class="opps-reminder">Ficha digital. No es necesario imprimir.</div>
				<div class="opps-info">
					<div class="opps-brand"><img src="https://lh3.googleusercontent.com/proxy/hMnCjNjgqoOlcWXxc1ph6JiB3SNkGaVaRHt2-J6N70gv1p0M0qmDkba7hnWk_31CMY7JDor1UJgOJ_PMnm-gFrYJh7LXkpPmx-numBo2dGUddnzdxTAZJgF82eAFBOYoYZK28Q" alt="OXXOPay"></div>
					<div class="opps-ammount">
						<h3>Monto a pagar</h3>
						<h2>$ {{response.data.order.amount / 100}} <sup> {{response.data.order.currency}} </sup></h2>
						<p>OXXO cobrará una comisión adicional al momento de realizar el pago.</p>
					</div>
				</div>
				<div class="opps-reference">
					<h3>Referencia</h3>
					<h1> {{ this.response.data.order.charges.data[0].payment_method.reference }} </h1>
				</div>
			</div>
			<div class="opps-instructions">
				<h3>Instrucciones</h3>
				<ol>
					<li>Acude a la tienda OXXO más cercana. <a href="https://www.google.com.mx/maps/search/oxxo/" target="_blank">Encuéntrala aquí</a>.</li>
					<li>Indica en caja que quieres realizar un pago de <strong>OXXOPay</strong>.</li>
					<li>Dicta al cajero el número de referencia en esta ficha para que tecleé directamete en la pantalla de venta.</li>
					<li>Realiza el pago correspondiente con dinero en efectivo.</li>
					<li>Al confirmar tu pago, el cajero te entregará un comprobante impreso. <strong>En el podrás verificar que se haya realizado correctamente.</strong> Conserva este comprobante de pago.</li>
				</ol>
				<div class="opps-footnote">Al completar estos pasos recibirás un correo de <strong>Nombre del negocio</strong> confirmando tu pago.</div>
			</div>
		</div>
		<p v-else>{{ response.message }}</p>
    </div>
</template>

<script>
    export default {
        props: ["order", "payment_callback"],
        created(){
        	this.response.message = 'Pagando con oxxo';
            EventBus.$on("conektaOxxoPayment", () => this.conektaPay());
        },
        beforeDestroy(){
            EventBus.$off("conektaOxxoPayment");
        },
        data(){
            return {
                errors: [],
                response: {message : "", status: "error", charge: {}}
            }
        },
        methods : {
            conektaPay(){
            	this.response.message = 'Generando comprobante ...';
            	const params = {
                    order : this.order,
                    payment : {
                        method : "oxxo_cash",
                    }
                };

            	axios.post(this.payment_callback, params)
                .then(res => {
                    console.log(res.data);
                    this.response = res.data;
                } )
                .catch(err => {
                	response.message = 'Error';
                    console.log(err);
                });
            }
        },
    }
</script>

<style>
* { margin: 0;padding: 0; }
body { font-size: 14px; }


h3 {
	margin-bottom: 10px;
	font-size: 15px;
	font-weight: 600;
	text-transform: uppercase;
}

.opps {
	width: 496px; 
	border-radius: 4px;
	box-sizing: border-box;
	padding: 0 45px;
	margin: 40px auto;
	overflow: hidden;
	border: 1px solid #b0afb5;
	font-family: 'Open Sans', sans-serif;
	color: #4f5365;
}

.opps-reminder {
	position: relative;
	top: -1px;
	padding: 9px 0 10px;
	font-size: 11px;
	text-transform: uppercase;
	text-align: center;
	color: #ffffff;
	background: #000000;
}

.opps-info {
	margin-top: 26px;
	position: relative;
}

.opps-info:after {
	visibility: hidden;
	display: block;
	font-size: 0;
	content: " ";
	clear: both;
	height: 0;

}

.opps-brand {
	width: 45%;
	float: left;
}

.opps-brand img {
	max-width: 150px;
	margin-top: 2px;
}

.opps-ammount {
	width: 55%;
	float: right;
}

.opps-ammount h2 {
	font-size: 36px;
	color: #000000;
	line-height: 24px;
	margin-bottom: 15px;
}

.opps-ammount h2 sup {
	font-size: 16px;
	position: relative;
	top: -2px
}

.opps-ammount p {
	font-size: 10px;
	line-height: 14px;
}

.opps-reference {
	margin-top: 14px;
}

h1 {
	font-size: 27px;
	color: #000000;
	text-align: center;
	margin-top: -1px;
	padding: 6px 0 7px;
	border: 1px solid #b0afb5;
	border-radius: 4px;
	background: #f8f9fa;
}

.opps-instructions {
	margin: 32px -45px 0;
	padding: 32px 45px 45px;
	border-top: 1px solid #b0afb5;
	background: #f8f9fa;
}

ol {
	margin: 17px 0 0 16px;
}

li + li {
	margin-top: 10px;
	color: #000000;
}

a {
	color: #1155cc;
}

.opps-footnote {
	margin-top: 22px;
	padding: 22px 20 24px;
	color: #108f30;
	text-align: center;
	border: 1px solid #108f30;
	border-radius: 4px;
	background: #ffffff;
}
</style>
<template>
    <div>
        <form v-if="response.status != 'success'">
            <p v-if="errors.length">
                <b>Please correct the following error(s):</b>
                <ul>
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </p>
            <div class="card-inputs">
                <div>
                    <label for="">Nombre del tarjetahabiente</label>
                    <input type="text" v-model="card.name" name="propietario">
                </div>
                <div>
                    <label for="">Número de la tarjeta</label>
                    <input type="text" v-model="card.number" name="tarjeta">
                </div>
                <div>
                    <label for="">Fecha de expiración (MM/AA)</label>
                    <input type="text" v-model="card.exp_month" name="mes">
                    <input type="text" v-model="card.exp_year" name="año">
                </div>
                <div>
                    <label for="">CVC</label>
                    <input type="text" v-model="card.cvc" name="CVC">
                </div>
            </div>
        </form>
        <h2 v-else>{{response.message}}</h2>
    </div>
</template>

<script>
    export default {
        props: ["order", "payment_callback"],
        created(){
            EventBus.$on("conektaCardPayment", () => this.conektaPay());
        },
        beforeDestroy(){
            EventBus.$off("conektaCardPayment");
        },
        data(){
            return {
                errors: [],
                response: {message : "", status: "error"},
                card : {
                    number : "4242424242424242",
                    name : "Pedrito",
                    exp_year : "26",
                    exp_month : "10",
                    cvc : "123",
                    address: null
                }
            }
        },
        methods : {
            conektaPay(){
                if(this.validForm()) {
                    Conekta.Token.create({card: this.card}, this.conektaSuccess, this.conektaError);
                }
            },
            conektaSuccess(token){
                const params = {
                    order : this.order,
                    payment : {
                        method : "card",
                        card : this.card.number,
                        conektaTokenId : token.id
                    }
                };
                axios.post(this.payment_callback, params)
                .then(res => {
                    console.log(res.data);
                    this.response = res.data;
                } )
                .catch(err => {
                    console.log(err);
                });
            },
            conektaError(res){
                console.log(res);
            },
            validForm(){
                var res = true;
                this.errors = [];
                if(!Conekta.card.validateNumber(this.card.number)){
                    this.errors.push("El formato de la tarjeta no parece válido");
                    res = false;
                }
                if(!Conekta.card.validateExpirationDate(this.card.exp_month, this.card.exp_year)){
                    this.errors.push("La fecha de expiración no es una fecha válida o futura");
                    res = false;
                }
                return res;
            }
        },
    }
</script>

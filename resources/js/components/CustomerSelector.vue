<template>
    <input type="text" class="form-control" placeholder="Nombre, Telefono o Instagram de la clienta" required>
</template>

<script>
    export default {
        props: {
            mode: {
                /* To define is the component is being used in Create, View or Edit Mode */
                type: String
            }
        },

        data() {
            return {
                /* Initial Empty Array of Customers */
                customers: [],
                /* Search Field for Customer */
                form: {
                    search_value: '',
                },
            };
        },

        mounted() {
            this.prepareComponent();
        },

        methods: {

        },
    }
</script>


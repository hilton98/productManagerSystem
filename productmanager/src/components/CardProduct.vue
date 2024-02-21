<template>
    <div class="card p-2" style="width: 250px;">
        <img class="card-img-top" :src=image_url alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title">Descrição</h5>
            <p class="card-text">{{ description }}</p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Nome: {{ name }}</li>
            <li class="list-group-item">Preço: {{ price }}</li>
            <li class="list-group-item">Validade: {{ expiration_dt }}</li>
        </ul>
    </div>
</template>
  
<script lang="ts">
  import { defineComponent } from 'vue';

  export default defineComponent({
    name: 'CardProduct',
    props: {
        name: String,
        description: String,
        price: String,
        image_url: String,
        expiration_dt: String
    },
    data(){
        return {}
    },
    methods: {},
  });
</script>
  
<style scoped>

</style>
  
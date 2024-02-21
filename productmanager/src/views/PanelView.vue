
<template>
  <div class="container">
    <div class="row">
        <div v-for="(product, index) in products" :key="index" class="col p-2">
          <CardProduct
            :name=product.name
            :description=product.description
            :price=product.price.toString()
            :image_url=product.image
            :expiration_dt=product.expiration_dt 
          />
        </div>
    </div>
  </div>

</template>
  
<script lang="ts">
import { defineComponent } from 'vue';
import CardProduct from '@/components/CardProduct.vue';
import apiService from '@/services/apiService';

interface Product {
  id: number;
  name: string;
  description: string;
  price: number;
  expiration_dt: string;
  image: string;
}

export default defineComponent({
  name: 'LoginView',
  components: {
    CardProduct,
  },
  data(){
    return {
      products: [] as Product[],
    }
  },
  created() {
    this.getProducts();
  },
  methods: {
    async getProducts() {
      try {
        const data = await apiService.get<Product[]>('product');
        this.products = data;
      } catch (error) {
        console.error('Erro ao buscar dados:', error);
      }
    }
  },
});
</script>
  
<template>
    <div class="d-flex flex-wrap">
      <div v-for="(product, index) in consultProducts(products)" :key="index" class="p-2">
        <CardProduct
          :product="product" 
        />
      </div>
    </div>
</template>
  
<script lang="ts">
import { Product } from '@/types';
import { defineComponent } from 'vue';
import CardProduct from '@/components/CardProduct.vue';
import apiService from '@/services/apiService';

export default defineComponent({
  name: 'DashboardCards',
  props: {
    queryParam: String,
  },
  components: {
    CardProduct
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
    },
    consultProducts(products: Product[]){
      const lowercaseQueryParam = this.queryParam?this.queryParam.toLowerCase():'';
      return products.filter((product) => {
        const lowercaseName= product.name.toLowerCase();
        const lowercaseDescription = product.description.toLowerCase();
        return lowercaseName.includes(lowercaseQueryParam) || lowercaseDescription.includes(lowercaseQueryParam);
      });
    },
  },
});
</script>
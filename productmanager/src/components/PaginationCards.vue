<template>
    <div class="d-flex flex-wrap">
      <div v-for="(product, index) in consultProducts(products)" :key="index" class="p-2">
        <CardProduct
          :name=product.name
          :description=product.description
          :price=product.price.toString()
          :image_url=product.image
          :expiration_dt=product.expiration_dt 
        />
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
  name: 'PaginationCards',
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
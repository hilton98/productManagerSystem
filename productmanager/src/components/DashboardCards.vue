<template>
  <div class="d-flex flex-wrap justify-content-center p-4">
    <div v-for="(product, index) in consultProducts(products)" :key="index" class="p-2">
      <CardProduct :product="product" />
    </div>
  </div>
</template>
  
<script lang="ts">
import { Product } from '@/types';
import { defineComponent, ref, onMounted } from 'vue';
import CardProduct from '@/components/CardProduct.vue';
import apiService from '@/services/apiService';
import Cookies from 'js-cookie';


const CREDENTIAL = Cookies.get(process.env.VUE_APP_TOKEN_API);

export default defineComponent({
  name: 'DashboardCards',
  props: {
    queryParam: String,
  },
  components: {
    CardProduct
  },
  methods: {
    consultProducts(products: Product[]) {
      const lowercaseQueryParam = this.queryParam ? this.queryParam.toLowerCase() : '';
      return products.filter((product) => {
        const lowercaseName = product.name.toLowerCase();
        const lowercaseDescription = product.description.toLowerCase();
        return lowercaseName.includes(lowercaseQueryParam) || lowercaseDescription.includes(lowercaseQueryParam);
      });
    },
  },

  setup() {
    const products = ref([] as Product[]);

    const getProducts = async () => {
      try {
        const data = await apiService.get<Product[]>('stock', CREDENTIAL);
        products.value = data;
      } catch (error) {
        console.error('Erro ao buscar dados:', error);
      }
    };
    onMounted(getProducts);
    return {
      products
    }

  }
});
</script>
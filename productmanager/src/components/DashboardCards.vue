<template>
  <div class="d-flex flex-wrap justify-content-center p-4">
    <h1 v-if="products.length < 1">Sem produtos cadastrados!</h1>
    <div v-for="(product, index) in consultProducts(products)" :key="index" class="p-2">
      <CardProduct :product="product" />
    </div>
  </div>
</template>
  
<script lang="ts">
import { Product } from '@/types';
import { defineComponent, ref, onMounted, onUpdated } from 'vue';
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
  data() {
    return {
      noResultsSearch: false
    }

  },
  methods: {
    consultProducts(products: Product[]) {
      const lowercaseQueryParam = this.queryParam ? this.queryParam.toLowerCase() : '';
      if (products) {
        const result = products.filter((product) => {
          const lowercaseName = product.name.toLowerCase();
          const lowercaseDescription = product.description.toLowerCase();
          return lowercaseName.includes(lowercaseQueryParam) || lowercaseDescription.includes(lowercaseQueryParam);
        });
        return result;
      }
    },
  },

  setup() {
    const products = ref([] as Product[]);

    const getProducts = async () => {
      try {
        const data = await apiService.get<Product[]>('stock', CREDENTIAL);
        if (data) {
          products.value = data;
        } else {
          products.value = [];
        }
      } catch (error) {
        console.error('Erro ao buscar dados:', error);
      }
    };
    onMounted(getProducts);
    onUpdated(getProducts);
    return {
      products
    }

  }
});
</script>
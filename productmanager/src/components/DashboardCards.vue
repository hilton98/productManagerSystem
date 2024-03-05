<template>
  <div class="d-flex flex-wrap justify-content-center p-4">
    <h1 v-if="userProducts.length < 1">Sem produtos cadastrados!</h1>
    <div v-for="(product, index) in consultProducts(userProducts)" :key="index" class="p-2">
      <CardProduct :product="product" />
    </div>
  </div>
</template>

<script lang="ts">
import { Product } from '@/types';
import { mapGetters, mapActions, useStore } from 'vuex';
import { defineComponent, ref, onMounted } from 'vue';
import CardProduct from '@/components/CardProduct.vue';

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
  computed: {
    ...mapGetters([
      'userProducts'
    ])
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
    ...mapActions([
      'fetchProducts'
    ]),
  },

  setup() {
    const products = ref([] as Product[]);
    const store = useStore();
    onMounted(async () => {
      await store.dispatch('fetchProducts');
    });

    return {
      products
    }

  }
});
</script>
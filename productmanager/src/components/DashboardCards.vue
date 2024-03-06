<template>
  <div class="d-flex flex-wrap justify-content-center p-4">
    <h1 v-if="userProducts.length < 1">Sem produtos cadastrados!</h1>
    <div v-for="(product, index) in consultProducts(userProducts).slice(
      currentPage * itemsPerPage, currentPage * itemsPerPage + itemsPerPage
    )" :key="index" class="p-2">
      <CardProduct :product="product" />
    </div>
  </div>

  <div v-if="userProducts.length > 0" class="d-flex justify-content-center">
    <nav aria-label="...">
      <ul class="pagination">
        <li :class="{ 'page-item': true, 'disabled': isDisablePrevious }">
          <button class="page-link" @click="handlerGoAndback(-1)">Anterior</button>
        </li>
        <li v-for="(value, index) in [...Array(Math.ceil(userProducts.length / itemsPerPage)).keys()]" :key="index"
          :class="{ 'page-item': true, 'active': index === currentPage }">
          <button @click="handlerGoToPage(index)" class="page-link">{{ index + 1 }}</button>
        </li>
        <li :class="{ 'page-item': true, 'disabled': isDisableNext }">
          <button class="page-link" @click="handlerGoAndback(1)">Próximo</button>
        </li>
      </ul>
    </nav>
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
      isDisablePrevious: true,
      isDisableNext: false,
      noResultsSearch: false,
      currentPage: 0,
      itemsPerPage: 3,
    }
  },
  computed: {
    ...mapGetters([
      'userProducts'
    ])
  },
  methods: {
    getItemsPerPage() {
      const totalPages = Math.ceil(this.userProducts.length / this.itemsPerPage) - 1;
      return totalPages;
    },
    handlerGoAndback(direction: number) {
      const totalNumberPages = this.getItemsPerPage();
      this.currentPage = this.currentPage + direction;
      if (this.currentPage <= 0)
        this.handlerGoToPage(0);
      if (totalNumberPages <= this.currentPage)
        this.handlerGoToPage(totalNumberPages);
    },
    handlerGoToPage(numberPage: number) {
      const totalNumberPages = this.getItemsPerPage();
      const isFirstPage = numberPage === 0;
      const isLastPage = totalNumberPages === numberPage;
      const isMiddlePage = 0 < numberPage && numberPage < totalNumberPages;
      const isOnlyPage = isFirstPage && isLastPage;
      this.currentPage = numberPage;

      if (isFirstPage) {
        this.isDisablePrevious = true;
        this.isDisableNext = false;
      }
      if (isLastPage) {
        this.isDisablePrevious = false;
        this.isDisableNext = true;
      }
      if (isMiddlePage) {
        this.isDisablePrevious = false;
        this.isDisableNext = false;
      }
      if (isOnlyPage) {
        this.isDisablePrevious = true;
        this.isDisableNext = true;
      }
    },
    consultProducts(products: Product[]) {
      const lowercaseQueryParam = this.queryParam ? this.queryParam.toLowerCase() : '';
      if (products) {
        const result = products.filter((product) => {
          const lowercaseName = product.name.toLowerCase();
          const lowercaseDescription = product.description.toLowerCase();
          return lowercaseName.includes(lowercaseQueryParam) || lowercaseDescription.includes(lowercaseQueryParam);
        });
        this.currentPage = lowercaseQueryParam.length > 0 ? 0 : this.currentPage;
        return result;
      }
      return [];
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
import { createStore, Commit } from 'vuex';
import { Product } from '@/types';
import apiService from '@/services/apiService';
import Cookies from 'js-cookie';

interface State {
  userProducts: Product[];
}

export default createStore({
  state: {
    userProducts: [] as Product[],
  } as State,
  mutations: {
    setProducts(state: State, products: Product[]) {
      state.userProducts = products;
    },
    addProduct(state: State, product: Product) {
      state.userProducts.push(product);
    },
    updateProduct(state: State, updatedProduct: Product) {
      const index = state.userProducts.findIndex((p) => p.id === updatedProduct.id);
      if (index !== -1) {
        state.userProducts[index] = updatedProduct;
      }
    },
    deleteProduct(state: State, productId: number) {
      state.userProducts = state.userProducts.filter((p) => p.id !== productId);
    },
  },
  actions: {
    async fetchProducts({ commit }: { commit: Commit }) {
      const CREDENTIAL = Cookies.get(process.env.VUE_APP_TOKEN_API);
      const products = await apiService.get<Product[]>('stock', CREDENTIAL);
      commit('setProducts', products);
    }
  },
  getters: {
    userProducts: (state: State) => state.userProducts,
  },
});

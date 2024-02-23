<template>
  <div class="modal fade show" tabindex="-1" role="dialog" style="display: block;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ title }}</h5>
        </div>
        <div class="modal-body">
          {{ message }}
        </div>
        <div class="modal-footer">
          <button @click="callback(false)" type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <form @submit.prevent="submit">
            <button type="submit" class="btn btn-primary">Confirmar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
  
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import { useRouter } from 'vue-router';
import apiService from '@/services/apiService';
import Cookies from 'js-cookie';
const CREDENTIAL = Cookies.get(process.env.VUE_APP_TOKEN_API);

export default defineComponent({
  name: "SaveProduct",
  props: {
    title: {
      type: String,
      required: true
    },
    message: {
      type: String,
      required: true
    },
    callback: {
      type: Function as PropType<(open: boolean) => void>,
      required: true,
    },
    productId: {
      type: Number,
      required: true,
    }
  },
  data() {
    return {
      modalTitle: this.tittle,
      categorySelected: "",
    };
  },
  methods: {
    async submit() {
      try {
        const response = await apiService.delete<null>(
          `product/${this.productId}`,
          CREDENTIAL
        );
        console.log(response);
      } catch (error) {
        console.error('Erro ao realizar o registro:', error);
      }
      this.callback(false);
      this.goToDashboard();
    },
  },
  setup() {
    const router = useRouter();

    const goToDashboard = () => {
      window.location.reload();
      // const products = `t=${Date.now()}`;
      // router.replace({ name: 'dashboard', query: { products } });
    };

    return {
      goToDashboard,
    };
  },

});

</script>
  
<style scoped></style>
  
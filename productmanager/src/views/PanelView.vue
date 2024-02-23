
<template>
  <SaveProduct v-if="isOpenModalUpdate" :title=titleModal :callback=viewModal />

  <div class="">

    <div class="d-flex justify-content-evenly">

      <div>
        <input class="form-control mr-sm-2" v-model="serachText" type="search" placeholder="Filtrar produtos"
          aria-label="Search">
      </div>

      <div class="d-flex gap-3">
        <div>
          <button @click="viewModal(true)" class="btn btn-outline-primary">+Produto</button>
        </div>

        <div>
          <button @click="logout()" class="btn btn-outline-dark">Sair</button>
        </div>

      </div>

    </div>

    <div>
      <DashboardCards :queryParam=serachText />
    </div>
  </div>
</template>
  
<script lang="ts">
import DashboardCards from '@/components/DashboardCards.vue';
import SaveProduct from '@/components/SaveProduct.vue';
import { defineComponent } from 'vue';
import { useRouter } from 'vue-router';
import Cookies from 'js-cookie';

export default defineComponent({
  name: 'PanelView',
  components: {
    DashboardCards,
    SaveProduct
  },
  data() {
    return {
      serachText: '',
      titleModal: 'Criar Produto',
      isOpenModalUpdate: false,
    }
  },
  methods: {
    viewModal(command: boolean) {
      this.isOpenModalUpdate = command;
    },
    logout() {
      Cookies.remove(process.env.VUE_APP_TOKEN_API);
      this.goToLogin();
    },
  },
  setup() {
    const router = useRouter();
    const goToLogin = () => {
      router.replace('/');
    };
    return {
      goToLogin,
    };
  },
});
</script>
  
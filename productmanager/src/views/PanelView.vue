
<template>
  <SaveProduct v-if="isOpenModalUpdate" :title=titleModal :callback=viewModal />
  <button @click="viewModal(true)" class="btn btn-outline-primary">Criar Produto</button>
  <div class="d-flex justify-content-center">
    <div class="w-75">
      <input class="form-control mr-sm-2" v-model="serachText" type="search" placeholder="Search" aria-label="Search">
      <DashboardCards :queryParam=serachText />
    </div>
  </div>
</template>
  
<script lang="ts">
import DashboardCards from '@/components/DashboardCards.vue';
import SaveProduct from '@/components/SaveProduct.vue';
import { defineComponent } from 'vue';

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
      isOpenModalUpdate: false
    }
  },
  methods: {
    viewModal(command: boolean) {
      this.isOpenModalUpdate = command;
    },
  }
});
</script>
  
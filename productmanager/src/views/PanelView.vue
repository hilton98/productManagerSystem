
<template>
  <SaveProduct v-if="isOpenModalUpdate" :title=titleModal :callback=viewModal />

  <div class="">

    <div class="d-flex justify-content-evenly">
      <div>
        <input class="form-control mr-sm-2" v-model="serachText" type="search" placeholder="Search" aria-label="Search">
      </div>
      <div>
        <button @click="viewModal(true)" class="btn btn-outline-primary">Criar Produto</button>
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
  
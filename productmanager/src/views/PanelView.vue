
<template>
  <div class="d-flex justify-content-center w-100">
    <div class="w-50">
      <input class="form-control mr-sm-2" v-model="serachText" type="search" placeholder="Search" aria-label="Search">
    </div>
  </div>
  <div class="w-100 d-flex justify-content-center">
    <div class="justify-content-center">
      <PaginationCards
        :queryParam=serachText
      />
    </div>
  </div>
</template>
  
<script lang="ts">
import PaginationCards from '@/components/PaginationCards.vue';
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'PanelView',
  components: {
    PaginationCards,
  },
  data(){
    return {
      serachText: '',
    }
  },
});
</script>
  
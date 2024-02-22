
<template>
  <div class="d-flex justify-content-center">
    <div class="w-75">
      <input class="form-control mr-sm-2" v-model="serachText" type="search" placeholder="Search" aria-label="Search">
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
  
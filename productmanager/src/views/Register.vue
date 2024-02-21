
<template>
    <div class="register">
      <FormRegister/>
    </div>
  </template>
  
  <script lang="ts">
  import { defineComponent } from 'vue';
  import FormRegister from '@/components/FormRegister.vue';
  
  export default defineComponent({
    name: 'RegisterView',
    components: {
      FormRegister,
    },
  });
  </script>
  
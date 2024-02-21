
<template>
    <div class="login">
      <FormLogin msg="Welcome to Your Vue.js + TypeScript App"/>
    </div>
  </template>
  
  <script lang="ts">
  import { defineComponent } from 'vue';
  import FormLogin from '@/components/FormLogin.vue'; // @ is an alias to /src
  
  export default defineComponent({
    name: 'LoginView',
    components: {
      FormLogin,
    },
  });
  </script>
  
<template>
    <div v-if="showMessage" class="alert alert-danger" role="alert">{{message}}</div>
    <div class="d-flex justify-content-center">
        <form class=" w-50 p-4" @submit.prevent="submit">
            <div class="form-group p-2">
                <label for="exampleInputEmail1">Endereço de email</label>
                <input v-model="postData.email" required type="email" class="form-control" placeholder="Fulanotal@gmail.com">
            </div>
            <div class="form-group p-2">
                <label for="exampleInputPassword1">Definir senha</label>
                <input v-model="postData.password" required type="password" class="form-control" id="exampleInputPassword1" placeholder="Senha Definitiva">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</template>
  
<script lang="ts">
  import { defineComponent } from 'vue';
  import apiService from '@/services/apiService';

  interface ReponseData {
    access_token: string;
    token_type: string;
    expires_in: number;
  }

  export default defineComponent({
    name: 'FormLogin',
    props: {
      msg: String,
    },
    data(){
        return {
            showMessage: false,
            message: '',
            postData : {
                email: '',
                password: '',
            }
        }
    },
    methods: {
        async submit() {
            try {
                const response = await apiService.post<ReponseData>('api/login', this.postData);                
                console.log(response);
            } catch (error) {
                this.message = 'Erro ao submeter dados de criação';
                this.showMessage = true;
                setTimeout(() => {
                    this.showMessage = false;
                }, 1500);
                console.error('Erro ao realizar o registro:', error);
            }
        }
  },
  });
</script>
  
<style scoped>

</style>
  
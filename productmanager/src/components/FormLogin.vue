<template>
    <div v-if="showMessage" class="z-3 position-absolute p-1 alert alert-danger w-100" role="alert">{{message}}</div>
    <div class="d-flex justify-content-center">
        <form class=" w-50 p-4" @submit.prevent="submit">
            <div class="form-group p-2">
                <label for="EmailLogin">Email</label>
                <input v-model="postData.email" required type="email" class="form-control" id="EmailLogin" placeholder="Fulanotal@gmail.com">
            </div>
            <div class="form-group p-2">
                <label for="passLogin">Senha de acesso</label>
                <input v-model="postData.password" required type="password" class="form-control" id="passLogin" placeholder="Senha">
            </div>
            <button type="submit" class="btn btn-primary">
                <div v-if="!showLoading">Entrar</div>
                <div  v-if="showLoading" class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                    </div>
                </div>
            </button>
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
            showLoading: false,
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
            this.showLoading = true;
            try {
                const response = await apiService.post<ReponseData>('api/login', this.postData);                
                console.log(response);
            } catch (error) {
                this.message = 'Erro ao submeter dados de criação!';
                this.showMessage = true;
                setTimeout(() => {
                    this.showMessage = false;
                }, 2000);
                console.error('Erro ao realizar o registro:', error);
            }
            this.showLoading = false;
        }
  },
  });
</script>
  
<style scoped>

</style>
  
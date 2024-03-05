<template>
    <h1>Registrar-se</h1>
    <div v-if="showMessage" class="z-3 position-absolute p-1 alert alert-danger w-100" role="alert">{{ message }}</div>
    <div class="d-flex justify-content-center">
        <form class=" w-50 p-4" @submit.prevent="submit">
            <div class="form-group p-2">
                <label for="exampleInputEmail1">Nome completo</label>
                <input v-model="postData.name" required type="text" class="form-control" placeholder="Fulano de tal">
            </div>

            <div class="form-group p-2">
                <label for="exampleInputEmail1">Endereço de email</label>
                <input v-model="postData.email" required type="email" class="form-control"
                    placeholder="Fulanotal@gmail.com">
            </div>
            <div class="form-group p-2">
                <label for="exampleInputPassword1">Definir senha</label>
                <input v-model="postData.password" required type="password" class="form-control"
                    id="exampleInputPassword1" placeholder="Senha Definitiva">
            </div>

            <div class="form-group p-2">
                <label for="exampleInputPassword1">Repetir senha</label>
                <input v-model="postData.confirmationPass" required type="password" class="form-control"
                    id="exampleInputPassword1" placeholder="Confirmar Senha">
            </div>
            <div>
                <button type="submit" class="btn btn-primary">
                    <div v-if="!showLoading">Enviar dados</div>
                    <div v-if="showLoading" class="d-flex justify-content-center">
                        <div class="spinner-border" role="status">
                        </div>
                    </div>
                </button>

                <div class="p-2">
                    <button :disabled="showLoading" @click="goToLogin" class="btn btn-primary">
                        <div>Voltar</div>
                        <div class="d-flex justify-content-center">
                            <div role="status">
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { useRouter } from 'vue-router';
import apiService from '@/services/apiService';

interface ReponseData {
    access_token: string;
    token_type: string;
    expires_in: number;
}

export default defineComponent({
    name: 'FormRegister',
    data() {
        return {
            message: '',
            showLoading: false,
            showMessage: false,
            postData: {
                name: '',
                email: '',
                password: '',
                confirmationPass: ''
            }
        }
    },
    methods: {
        async submit() {
            this.showLoading = true;
            if (this.validatePass()) {
                try {
                    const response = await apiService.post<ReponseData>('user', this.postData);
                    console.log(response);
                    this.goToLogin();
                } catch (error) {
                    this.showNotification("Erro ao submeter dados de criação.");
                    console.error('Erro ao realizar o registro:', error);
                }
            }
            this.showLoading = false;
            this.showNotification("Senhas divergentes. Inserir senhas coincidentes.");
        },
        validatePass() {
            let isValidPass = this.postData.password === this.postData.confirmationPass;
            return isValidPass;
        },
        showNotification(message: string) {
            this.message = message;
            this.showMessage = true;
            setTimeout(() => {
                this.showMessage = false;
            }, 2000);
        }
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

<style scoped></style>
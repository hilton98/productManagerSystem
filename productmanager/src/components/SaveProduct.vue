<template>
  <div>
    <div class="modal fade show" tabindex="-1" role="dialog" style="display: block;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ title }}</h5>
            <button @click="callback(false)" type="button" class="btn-close" data-bs-dismiss="modal"
              aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="name" class="form-label">Nome</label>
              <input v-model="postData.name" type="text" class="form-control" id="name">
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Descrição</label>
              <input v-model="postData.description" type="text" class="form-control" id="description">
            </div>

            <div class="mb-3">
              <label for="price" class="form-label">Preço</label>
              <input v-model="postData.price" type="number" class="form-control" id="price">
            </div>

            <div class="mb-3">
              <label for="senha" class="form-label">Data validade</label>
              <input v-model="postData.expirationDt" type="date" class="form-control" id="senha">
            </div>

            <div class="input-group mb-3">
              <label class="input-group-text" for="image">Image</label>
              <input type="file" ref="file" v-on:change="handleFileUpload()" accept="image/*" class="form-control" id="image">
            </div>

          </div>
          <div class="modal-footer">
            <button @click="submit" type="button" class="btn btn-primary">Salvar</button>
            <button @click="callback(false)" type="button" class="btn btn-secondary"
              data-bs-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
<script lang="ts">
import { Product } from '@/types';
import { defineComponent, PropType, ref } from 'vue';
import apiService from '@/services/apiService';

interface ReponseData {
  "isSuccess": boolean,
  "message": string
}

export default defineComponent({
  name: "SaveProduct",
  props: {
    title: {
      type: String,
      required: true
    },
    callback: {
      type: Function as PropType<(open: boolean) => void>,
      required: true,
    },
    product: {
      type: Object as () => Product,
      default: null,
    }
  },
  data() {
    return {
      modalTitle: this.tittle,
      postData: {
        id: this.product ? this.product.id : '',
        name: this.product ? this.product.name : '',
        description: this.product ? this.product.description : '',
        price: (this.product ? this.product.price : 0.0),
        expirationDt: this.product ? this.product.expiration_dt : '',
        image: this.product ? this.product.image : ''
      }
    };
  },
  methods: {
    closeModal() {
      this.callback(false);
    },
    async submit() {
      console.log(this.stringBase64);
      try {
        this.postData.image = this.stringBase64;
        const response = await apiService.put<ReponseData>(`product/${this.postData.id}`, this.postData);                
        console.log(response);
        return;
      } catch (error) {
        console.error('Erro ao realizar o registro:', error);
      }
      //this.closeModal();
    },
  },
  setup() {
      const file = ref(null);
      const stringBase64 = ref('');
      const handleFileUpload = async() => {
        const files = file.value? file.value['files']: null;
        const reader = new FileReader();
        reader.onload = (e) => {
          const base64String = (e.target?.result as string)?.split(',')[1];
          stringBase64.value = base64String;
        };
        files? reader.readAsDataURL(files[0]) : null;
      }
      return {
        handleFileUpload,
        file,
        stringBase64
      }
  }


});

</script>
  
<style scoped></style>
  
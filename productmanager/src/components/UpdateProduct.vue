<template>
    <div>
      <div class="modal fade show" tabindex="-1" role="dialog" style="display: block;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Atualizar dados do Produto</h5>
              <button @click="callback(false)" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>  
            <div class="modal-body">
              
                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input v-model="name" type="text" class="form-control" id="name">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descrição</label>
                    <input v-model="description" type="text" class="form-control" id="description">
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Preço</label>
                    <input v-model="price" type="text" class="form-control" id="price">
                </div>

                <div class="mb-3">
                    <label for="senha" class="form-label">Data validade</label>
                    <input v-model="expirationDt" type="date" class="form-control" id="senha">
                </div>

                <div class="input-group mb-3">
                    <label class="input-group-text" for="image">Image</label>
                    <input type="file" class="form-control" id="image">
                </div>
            
            </div>  
            <div class="modal-footer">
              <button @click="saveData" type="button" class="btn btn-primary">Salvar</button>
              <button @click="callback(false)" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script lang="ts">
  import { defineComponent, PropType} from 'vue';
  
  export default defineComponent({
    name: "UpdateProduct",
    props: {
        callback: {
            type: Function as PropType<(open:boolean) => void>,
            required: true,
        },
    },
    data() {
      return {
        modalOpen: true,
        name: '',
        description: '',
        price: null,
        expirationDt: null,
        image_url: null
      };
    },
    methods: {
      closeModal() {
        this.callback(false);
        console.log("no componente update", this.modalOpen);
        this.modalOpen = false;
      },
      saveData() {
        this.closeModal();
      },
    },
  });
  </script>
  
  <style scoped>
  </style>
  
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
              <input v-model="postData.expiration_dt" type="date" class="form-control" id="senha">
            </div>

            <div class="input-group mb-3">
              <label for="image">Selecione a imagem</label>
              <input type="file" ref="file" v-on:change="handleFileUpload()" accept="image/*" id="image">
            </div>

            <div class="dropdown">
              <h4>Selecione a categoria</h4>
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ categories.find((element) => element.id == postData.categoryId)?.name }}
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" v-for="(category, index) in categories" :key="index"
                  @click="handleActionClick(category.id)">{{ category.name }}</a>
              </div>

            </div>

          </div>
          <div class="modal-footer">
            <button @click="save" type="button" class="btn btn-primary">Salvar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
<script lang="ts">
import { Product, Category } from '@/types';
import { defineComponent, PropType, ref, onMounted } from 'vue';
import apiService from '@/services/apiService';
import { useRouter } from 'vue-router';


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
      categorySelected: "",
      postData: {
        id: this.product ? this.product.id : '',
        name: this.product ? this.product.name : '',
        description: this.product ? this.product.description : '',
        price: (this.product ? this.product.price : 0.0),
        expiration_dt: this.product ? this.product.expiration_dt : '',
        image: this.product ? this.product.image : '',
        categoryId: this.product ? this.product.category.id : 0
      }
    };
  },
  methods: {
    closeModal() {
      this.callback(false);
    },

    handleActionClick(categoryId: number) {
      this.postData.categoryId = categoryId;
    },

    async getCategories() {
      try {
        const data = await apiService.get<Category[]>('category');
        this.categories = data;
      } catch (error) {
        console.error('Erro ao buscar dados:', error);
      }
    },

    async save() {
      this.postData.image = this.stringBase64;
      if (this.postData.id !== '') {
        await this.update();
      } else {
        await this.create();
      }
      this.goToDashboard();
    },

    async update() {
      try {
        const response = await apiService.put<ReponseData>(`product/${this.postData.id}`, this.postData);
        console.log(response);
        return;
      } catch (error) {
        console.error('Erro ao realizar o registro:', error);
      }
      this.closeModal();
    },

    async create() {
      try {
        const response = await apiService.post<ReponseData>('product', this.postData);
        console.log(response);
        return;
      } catch (error) {
        console.error('Erro ao realizar o registro:', error);
      }
    }
  },

  setup() {
    const file = ref(null);
    const stringBase64 = ref('');
    const categories = ref([] as Category[]);
    const router = useRouter();

    const handleFileUpload = async () => {
      const files = file.value ? file.value['files'] : null;
      const reader = new FileReader();
      reader.onload = (e) => {
        const base64String = (e.target?.result as string)?.split(',')[1];
        stringBase64.value = base64String;
      };
      files ? reader.readAsDataURL(files[0]) : null;
    };

    const getCategories = async () => {
      try {
        const data = await apiService.get<Category[]>('category');
        categories.value = data;
      } catch (error) {
        console.error('Erro ao buscar dados:', error);
      }
    };

    const goToDashboard = () => {
      router.replace('/dashboard');
    };

    onMounted(getCategories);
    return {
      handleFileUpload,
      goToDashboard,
      file,
      stringBase64,
      categories
    }
  }
});

</script>
  
<style scoped></style>
  
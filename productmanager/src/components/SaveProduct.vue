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
              <input v-model="postData.name" required type="text" class="form-control" id="name">
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Descrição</label>
              <input v-model="postData.description" required type="text" class="form-control" id="description">
            </div>

            <div class="mb-3">
              <label for="price" class="form-label">Preço</label>
              <input v-model="postData.price" required type="text" @keyup="handleInsertMoney" class="form-control"
                id="price">
            </div>

            <div class="mb-3">
              <label for="senha" class="form-label">Data validade</label>
              <input v-model="postData.expiration_dt" required type="date" class="form-control" id="senha">
            </div>

            <div class="input-group mb-3">
              <label for="image">Selecione a imagem</label>
              <input type="file" ref="file" required v-on:change="handleFileUpload()" accept="image/*" id="image">
            </div>

            <div class="d-flex gap-3">
              <div>
                <label for="newCategory" class="form-label">Crie categoria</label>
                <input v-model="postData.newCategory" required type="text" class="form-control"
                  placeholder="Nome categoria" id="newCategory">
              </div>

              <div class="dropdown">
                <label for="dropdownMenuButton" class="form-label">Selecione categoria</label>
                <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{ categories.find((element) => element.id == postData.categoryId)?.name }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" v-for="(category, index) in categories" :key="index"
                    @click="handleActionClick(category.id)">{{ category.name }}</a>
                </div>
              </div>
            </div>
          </div>


          <div class="modal-footer">
            <button @click="submit" class="btn btn-primary">Salvar</button>
          </div>

        </div>


      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Product, Category } from '@/types';
import { mapActions } from 'vuex';
import { defineComponent, PropType, ref, onMounted } from 'vue';
import apiService from '@/services/apiService';
import Cookies from 'js-cookie';

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
        price: (this.product ? this.insertMasMoney(this.product.price) : this.insertMasMoney(0.0)),
        expiration_dt: this.product ? this.product.expiration_dt : '',
        image: this.product ? this.product.image : '',
        categoryId: this.product ? this.product.category.id : 0,
        newCategory: ''
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
    handleInsertMoney(event: KeyboardEvent) {
      const caractere = event.key;
      const regexLettersSpecialChar = /[\p{L}]/u;
      let price = this.removeMask(this.postData.price);

      if (caractere === 'Backspace' || caractere === 'Delete') {
        this.postData.price = this.getMoneyMounted(price);
        return;
      }

      if (regexLettersSpecialChar.test(caractere))
        price = price.replace(caractere, '');

      this.postData.price = this.getMoneyMounted(price);
    },
    getMoneyMounted(priceText: string) {
      const newPrice = priceText.replace('.', '');
      const integerPart = priceText.replace('.', '').split('').slice(0, -2).join().replaceAll(',', '');
      const decimalPart = `${newPrice[newPrice.length - 2]}${newPrice[newPrice.length - 1]}`;
      return this.insertMasMoney(Number(`${integerPart}.${decimalPart}`));
    },
    removeMask(value: string) {
      return value.replace('R$', '').replaceAll('.', '').replace(',', '.');
    },
    insertMasMoney(value: number) {
      return value.toLocaleString('pt-BR', { minimumFractionDigits: 2, style: 'currency', currency: 'BRL' });
    },
    async getCategories() {
      try {
        const data = await apiService.get<Category[]>('category');
        this.categories = data;
      } catch (error) {
        console.error('Erro ao buscar dados:', error);
      }
    },
    handleImage() {
      let data = {};
      if (this.stringBase64.length > 0) {
        this.postData.image = this.stringBase64;
        const { ...dataUpdate } = this.postData;
        data = dataUpdate;
      } else {
        const { image, ...dataUpdate } = this.postData;
        data = dataUpdate;
      }
      return data;
    },
    async submit() {
      this.postData.price = Number(this.removeMask(this.postData.price));
      const dataUpdate = this.handleImage();
      if (this.postData.id !== '' && dataUpdate) {
        await this.update(dataUpdate);
      } else {
        await this.create();
      }
      this.fetchProducts();
      this.callback(false);
    },

    async update(data: object) {
      try {
        const response = await apiService.put<ReponseData>(
          `product/${this.postData.id}`,
          data,
          Cookies.get(process.env.VUE_APP_TOKEN_API)
        );
        console.log(response);
        return;
      } catch (error) {
        console.error('Erro ao realizar o registro:', error);
      }
      this.closeModal();
    },
    async create() {
      try {
        const response = await apiService.post<ReponseData>(
          'product',
          this.postData,
          Cookies.get(process.env.VUE_APP_TOKEN_API)
        );
        console.log(response);
        return;
      } catch (error) {
        console.error('Erro ao realizar o registro:', error);
      }
    },
    ...mapActions([
      'fetchProducts'
    ]),
  },

  setup() {
    const file = ref(null);
    const stringBase64 = ref('');
    const categories = ref([] as Category[]);

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
    onMounted(getCategories);
    return {
      handleFileUpload,
      file,
      stringBase64,
      categories
    }
  }
});

</script>

<style scoped></style>
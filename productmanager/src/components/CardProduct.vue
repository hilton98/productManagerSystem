<template>
    <SaveProduct v-if="isOpenModalUpdate" :title=titleModal :callback=viewModal :product=product />
    <DeleteModal v-if="isOpenPopup" title="Deletar produto" :callback="confirmDeletion" :productId="product.id"
        :message="warningMessage" />
    <div class="card" style="width: 250px;">
        <div class="default-image p-2">
            <img class="card-img-top" :src="`${baseUrlImage}/images/${product.image}`" alt="Card image cap">
        </div>
        <div class="card-body" style="height: 100px;">
            <p class="card-text"><span style="font-weight: bold">Descrição: </span>{{ product.description }}</p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-truncate"><span style="font-weight: bold">Nome:</span> {{ product.name }}
            </li>
            <li class="list-group-item text-truncate"><span style="font-weight: bold">Preço:</span> {{
        product.price.toLocaleString('pt-BR', { minimumFractionDigits: 2, style: 'currency', currency: 'BRL' })
    }}</li>
            <li class="list-group-item text-truncate"><span style="font-weight: bold">Validade:</span> {{
            product.expiration_dt }}</li>
        </ul>
        <div class="d-flex justify-content-between card-body">
            <div>
                <button @click="confirmDeletion(true)" class="border-0 ">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 64 64">
                        <path fill="#afc4e1" d="M50,21H14v36c0,1.105,0.895,2,2,2h32c1.105,0,2-0.895,2-2V21z"></path>
                        <path fill="#becde8" d="M39,59V21H14v36c0,1.104,0.895,2,2,2H39z"></path>
                        <path fill="#cad8ed" d="M25,59V21H14v36c0,1.104,0.895,2,2,2H25z"></path>
                        <path fill="#afc4e1" d="M14 21H50V24H14z"></path>
                        <path fill="#8d6c9f"
                            d="M48,60H16c-1.654,0-3-1.346-3-3V21c0-0.553,0.448-1,1-1h36c0.552,0,1,0.447,1,1v36 C51,58.654,49.654,60,48,60z M15,22v35c0,0.552,0.449,1,1,1h32c0.551,0,1-0.448,1-1V22H15z">
                        </path>
                        <path fill="#a8b7d1"
                            d="M53,11H11c-1.105,0-2,0.895-2,2v6c0,1.105,0.895,2,2,2h42c1.105,0,2-0.895,2-2v-6 C55,11.895,54.105,11,53,11z">
                        </path>
                        <path fill="#8d6c9f"
                            d="M53,22H11c-1.654,0-3-1.346-3-3v-6c0-1.654,1.346-3,3-3h42c1.654,0,3,1.346,3,3v6 C56,20.654,54.654,22,53,22z M11,12c-0.551,0-1,0.448-1,1v6c0,0.552,0.449,1,1,1h42c0.551,0,1-0.448,1-1v-6c0-0.552-0.449-1-1-1H11 z">
                        </path>
                        <path fill="#8d6c9f"
                            d="M41 12c-.38 0-.743-.218-.911-.586l-2.335-5.137C37.57 6.1 37.323 6 37.063 6H26.937c-.26 0-.506.1-.691.277l-2.335 5.137c-.229.503-.822.726-1.324.496-.502-.229-.725-.821-.496-1.324l2.4-5.28c.037-.081.084-.157.142-.226C25.204 4.394 26.043 4 26.937 4h10.127c.893 0 1.733.394 2.305 1.08.057.068.105.145.142.226l2.4 5.28c.229.503.006 1.096-.496 1.324C41.28 11.972 41.139 12 41 12zM14 18c-.552 0-1-.447-1-1v-2c0-.553.448-1 1-1s1 .447 1 1v2C15 17.553 14.552 18 14 18zM19 18c-.552 0-1-.447-1-1v-2c0-.553.448-1 1-1s1 .447 1 1v2C20 17.553 19.552 18 19 18zM24 18c-.552 0-1-.447-1-1v-2c0-.553.448-1 1-1s1 .447 1 1v2C25 17.553 24.552 18 24 18zM29 18c-.552 0-1-.447-1-1v-2c0-.553.448-1 1-1s1 .447 1 1v2C30 17.553 29.552 18 29 18zM35 18c-.552 0-1-.447-1-1v-2c0-.553.448-1 1-1s1 .447 1 1v2C36 17.553 35.552 18 35 18zM40 18c-.552 0-1-.447-1-1v-2c0-.553.448-1 1-1s1 .447 1 1v2C41 17.553 40.552 18 40 18zM45 18c-.552 0-1-.447-1-1v-2c0-.553.448-1 1-1s1 .447 1 1v2C46 17.553 45.552 18 45 18zM50 18c-.552 0-1-.447-1-1v-2c0-.553.448-1 1-1s1 .447 1 1v2C51 17.553 50.552 18 50 18zM38 56H14c-.552 0-1-.447-1-1s.448-1 1-1h24c.552 0 1 .447 1 1S38.552 56 38 56zM46 56h-4c-.552 0-1-.447-1-1s.448-1 1-1h4c.552 0 1 .447 1 1S46.552 56 46 56zM20 42c-.552 0-1-.447-1-1V29c0-.553.448-1 1-1s1 .447 1 1v12C21 41.553 20.552 42 20 42zM20 50c-.552 0-1-.447-1-1v-4c0-.553.448-1 1-1s1 .447 1 1v4C21 49.553 20.552 50 20 50zM28 50c-.552 0-1-.447-1-1V29c0-.553.448-1 1-1s1 .447 1 1v20C29 49.553 28.552 50 28 50zM36 50c-.552 0-1-.447-1-1V29c0-.553.448-1 1-1s1 .447 1 1v20C37 49.553 36.552 50 36 50zM44 50c-.552 0-1-.447-1-1V37c0-.553.448-1 1-1s1 .447 1 1v12C45 49.553 44.552 50 44 50zM44 34c-.552 0-1-.447-1-1v-4c0-.553.448-1 1-1s1 .447 1 1v4C45 33.553 44.552 34 44 34z">
                        </path>
                    </svg>
                </button>
            </div>
            <div>
                <button @click="viewModal(true)" class="border-0 ">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 40 40">
                        <path fill="#98ccfd"
                            d="M20,38.5C9.799,38.5,1.5,30.201,1.5,20S9.799,1.5,20,1.5S38.5,9.799,38.5,20S30.201,38.5,20,38.5z">
                        </path>
                        <path fill="#4788c7"
                            d="M20,2c9.925,0,18,8.075,18,18s-8.075,18-18,18S2,29.925,2,20S10.075,2,20,2 M20,1 C9.507,1,1,9.507,1,20s8.507,19,19,19s19-8.507,19-19S30.493,1,20,1L20,1z">
                        </path>
                        <path fill="#fff"
                            d="M20,30.5c-2.64,0-5.129-0.965-7.064-2.729l2.126-2.126C16.43,26.845,18.165,27.5,20,27.5 c4.136,0,7.5-3.369,7.5-7.51v-0.5h-3.29L29,14.707l4.793,4.793H30.5V20C30.5,25.79,25.79,30.5,20,30.5z">
                        </path>
                        <path fill="#fff"
                            d="M29,15.414L32.586,19H31h-1v1c0,5.514-4.486,10-10,10c-2.337,0-4.55-0.794-6.331-2.255l1.425-1.424 C16.491,27.41,18.2,28,20,28c4.411,0,8-3.593,8-8.01v-1h-1h-1.58l1.498-1.493L29,15.414 M29,14l-2.79,2.79L23,19.99h4 c0,3.86-3.14,7.01-7,7.01c-1.93,0-3.68-0.78-4.95-2.05l-2.83,2.83C14.21,29.77,16.96,31,20,31c6.08,0,11-4.92,11-11h4l-5.43-5.43 L29,14L29,14z">
                        </path>
                        <g>
                            <path fill="#fff"
                                d="M6.207,20.5H9.5V20c0-5.79,4.71-10.5,10.5-10.5c2.64,0,5.129,0.965,7.064,2.728l-2.126,2.126 C23.571,13.155,21.836,12.5,20,12.5c-4.136,0-7.5,3.364-7.5,7.5v0.5h3.293L11,25.293L6.207,20.5z">
                            </path>
                            <path fill="#fff"
                                d="M20,10c2.337,0,4.55,0.794,6.331,2.255l-1.425,1.425C23.509,12.59,21.8,12,20,12 c-4.411,0-8,3.589-8,8v1h1h1.586L11,24.586L7.414,21H9h1v-1C10,14.486,14.486,10,20,10 M20,9C13.92,9,9,13.92,9,20H5l5.43,5.43 L11,26l6-6h-4c0-3.86,3.14-7,7-7c1.93,0,3.68,0.78,4.95,2.05l2.83-2.83C25.79,10.23,23.04,9,20,9L20,9z">
                            </path>
                        </g>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { Product } from '@/types';
import SaveProduct from '@/components/SaveProduct.vue';
import DeleteModal from '@/components/DeleteModal.vue';
import { defineComponent } from 'vue';

export default defineComponent({
    name: 'CardProduct',
    props: {
        product: {
            type: Object as () => Product,
            required: true,
        },
    },
    components: {
        SaveProduct,
        DeleteModal
    },
    data() {
        return {
            baseUrlImage: process.env.VUE_APP_BASE_URL,
            warningMessage: "Você tem certeza que deseja prosseguir? Os dados serão deletados e não poderão ser recuperados.",
            titleModal: "Atualizar dados do Produto",
            isOpenModalUpdate: false,
            isOpenPopup: false,
        }
    },
    methods: {
        viewModal(signal: boolean) {
            this.isOpenModalUpdate = signal;
        },
        confirmDeletion(signal: boolean) {
            this.isOpenPopup = signal;
        }
    },
});
</script>

<style scoped>
.default-image {
    width: 250px;
    height: 200px;
    overflow: hidden;
}

.default-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>
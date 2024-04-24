<script setup>
import { useUser } from '@/stores/user';
import axios from 'axios';
import * as bootstrap from 'bootstrap'
import { onMounted, ref } from 'vue';


const user = useUser()
const createSparepartModal = ref(null)
const categories = ref(null)

const formAdd = ref({
    name: "",
    price: 0,
    stock: 0,
    category_id: NaN,
    image: null
})

const addImage = (e) => {
    formAdd.value.image = e.target.files[0]
}

const submitCreateSparepart = () => {
    let data = new FormData();
    data.append('name', formAdd.value.name);
    data.append('price', formAdd.value.price);
    data.append('stok', formAdd.value.stock);
    data.append('category_id', formAdd.value.category_id);
    data.append('image', formAdd.value.image)
    axios.post('/api/v1/sparepart', data, {
        headers: {
            Authorization: 'Bearer ' + user.token
        }
    }).then(() => {
        let modal = bootstrap.Modal.getInstance(createSparepartModal.value)
        modal.hide()
    })
}

onMounted(async () => {
    await axios.get('api/v1/category', {
        headers: {
            Authorization: 'Bearer ' + user.token
        }
    }).then(({ data }) => {
        categories.value = data.categories
    })
})
</script>
<template>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSparepartModal">
        Tambah Sparepart
    </button>
    <!-- Modal -->
    <div class="modal fade" id="createSparepartModal" ref="createSparepartModal" tabindex="-1"
        aria-labelledby="createSparepartModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createSparepartModalLabel">Tambah Sparepart</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addSparepart" ref="addSparepartForm" @submit.prevent="submitCreateSparepart">
                        <div class="row">
                            <div class="mb-2">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" v-model="formAdd.name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-2 col-6">
                                <label for="price" class="form-label">Harga</label>
                                <input type="number" name="price" class="form-control" v-model="formAdd.price">
                            </div>
                            <div class="mb-2 col-6">
                                <label for="stock" class="form-label">Stok</label>
                                <input type="number" name="stock" class="form-control" v-model="formAdd.stock">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-2">
                                <label for="category_id" class="form-label">Kategori</label>
                                <select name="category_id" class="form-select" v-model="formAdd.category_id">
                                    <option v-for="category in categories" :key="category.id" :value="category.id">
                                        {{ category.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="">
                                <label for="image" class="form-label">Gambar</label>
                                <input type="file" name="image" class="form-control" @change="addImage">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="addSparepart" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>
</template>
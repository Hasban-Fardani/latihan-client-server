<script setup>
import AddSparepart from '@/components/AddSparepart.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';


const spareparts = ref([]);
onMounted(async () => {
    await axios.get('/api/v1/sparepart/list')
        .then(({ data }) => {
            spareparts.value = data.spareparts
        })
})

// Utilites
const format = (harga) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR"
    }).format(harga)
}
</script>
<template>
    <AdminLayout>
        <template v-slot:title>
            <h2>Sparepart</h2>
        </template>
        <AddSparepart></AddSparepart>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Stok</th>
                    <th scope="col">aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="sparepart in spareparts" :key="sparepart.id">
                    <th scope="row">
                        <img :src="sparepart.image" :alt="sparepart.name" width="150px" class="img-fluid">
                    </th>
                    <td>
                        <p>{{ sparepart.name }}</p>
                    </td>
                    <td>
                        <p>{{ sparepart.category.name }}</p>
                    </td>
                    <td>
                        <p>{{ format(sparepart.price) }}</p>
                    </td>
                    <td>
                        <p>{{ sparepart.stok }}</p>
                    </td>
                    <td class="f-flex gap-1">
                        <button class="btn btn-primary">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-warning">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </AdminLayout>
</template>
<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { useUser } from '@/stores/user';


const user = useUser()
const transaction_details = ref([])
const route = useRoute()
const id = route.params.id
onMounted(async () => {
    await axios.get('api/v1/transaction/' + id + '/detail', {
        headers: {
            Authorization: "Bearer " + user.token
        }
    }).then(({data}) => {
        console.log(data)
    })
})
</script>
<template>
    <AdminLayout>
        <template v-slot:title>
            <h2>Transaction Detail</h2>
        </template>
        <div class="mt-2">
            <button class="btn btn-primary">Tambah</button>
            <RouterLink class="btn" to="/admin/transaction">Kembali</RouterLink>
        </div>
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">sparepart</th>
                        <th scope="col">jumlah</th>
                        <th scope="col">subtotal</th>
                        <th scope="col">aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="detail in transaction_details" :key="detail.id">
                        <td scope="row">
                            <p>{{ detail.sparepart.name }}</p>
                        </td>
                        <td>
                            <p>{{ detail.qty }}</p>
                        </td>
                        <td>
                            <p>{{ format(detail.subtotal) }}</p>
                        </td>
                        <td class="f-flex gap-1">
                            <RouterLink class="btn btn-warning" :to="'/admin/transaction/' + transaction.id">
                                <i class="bi bi-pencil"></i>
                            </RouterLink>
                            <button class="btn btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>
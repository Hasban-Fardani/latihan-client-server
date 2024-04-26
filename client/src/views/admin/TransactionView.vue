<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';
import CreateTransaction from '@/components/CreateTransaction.vue'
import { useUser } from '@/stores/user';
import { onMounted, ref } from 'vue';
import axios from 'axios';

const format = (harga) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR"
    }).format(harga)
}


const user = useUser()
const transactions = ref([]);
onMounted(async () => {
    await axios.get('/api/v1/transaction', {
        headers: {
            Authorization: "Bearer " + user.token
        }
    }).then(({ data }) => {
        console.log(data)
        transactions.value = data.transactions
    })
})
</script>
<template>
    <AdminLayout>
        <template v-slot:title>
            <h2>Transaction</h2>
        </template>
        <CreateTransaction/>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">customer</th>
                    <th scope="col">total</th>
                    <th scope="col">operator</th>
                    <th scope="col">aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="transaction in transactions" :key="transaction.id">
                    <td scope="row">
                        <p>{{ transaction.customer.name }}</p>
                    </td>
                    <td>
                        <p>{{ format(transaction.total) }}</p>
                    </td>
                    <td>
                        <p>{{ transaction.user.name }}</p>
                    </td>
                    <td class="f-flex gap-1">
                        <a class="btn btn-primary"
                            :href="`http://localhost:8000/api/v1/transaction/invoice/${transaction.id}?view=true`"
                            target="_blank">
                            <i class="bi bi-printer-fill"></i>
                        </a>
                        <RouterLink class="btn btn-warning" :to="'/admin/transaction/' + transaction.id">
                            <i class="bi bi-pencil"></i>
                        </RouterLink>
                        <button class="btn btn-danger">
                            <i class="bi bi-trash" ></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </AdminLayout>
</template>
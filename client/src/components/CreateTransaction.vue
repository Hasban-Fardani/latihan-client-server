<script setup>
import { ref, onMounted } from 'vue';
import { useUser } from '@/stores/user';
import axios from 'axios';

const customer_id = ref()
const customers = ref([]);
const user = useUser()
onMounted(async () => {
    await axios.get('/api/v1/customers', { 
        headers: {
            Authorization: "Bearer " + user.token
        }
    }).then(({data}) => {
        customers.value = data.customers
    })
})

const createTransaction = async () => {
    await axios.post('api/v1/transaction', {
        customer_id: customer_id.value
    }, {
        headers: {
            Authorization: "Bearer " + user.token
        }
    }).then(() => {
        
    })
}
</script>
<template>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Buat
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Buat Transaksi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <form action="">
                            <label for="" class="form-label">Customer</label>
                            <select class="form-select" v-model="customer_id">
                                <option v-for="customer in customers" :key="customer.id" :value="customer.id">
                                    {{ customer.name }}
                                </option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="createTransaction">Save changes</button>
                </div>
            </div>
        </div>
    </div>

</template>
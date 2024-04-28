<script setup>
import Navbar from '@/components/NavBar.vue'
import Footer from '@/components/Footer.vue'
import { computed, onMounted, ref } from 'vue';
import axios from 'axios';
import { useUser } from '@/stores/user';
import router from '@/router';


const user = useUser()
let carts = ref([])
let customers = ref([])
let selectedCustomer = ref('')

const total = computed(() => {
  let t = 0
  carts.value.forEach(cart => {
    t = cart.sparepart.price * cart.qty
  });
  return t
})

const transaction_id = ref()
const submit = async () => {
  if (!selectedCustomer.value) {
    return
  }
  await axios.post('/api/v1/transaction', {
    customer_id: selectedCustomer.value
  }, {
    headers: {
      Authorization: "Bearer " + user.token
    }
  }).then(async ({ data }) => {
    transaction_id.value = data.transaction.id
  })

  await axios.post('api/v1/transaction/' + transaction_id.value + '/detail', {
    values: carts.value.map((v) => {
      return {
        sparepart_id: v.sparepart.id,
        qty: v.qty,
        cart_id: v.id,
      }
    })
  }, {
    headers: {
      Authorization: 'Bearer ' + user.token
    }
  }).then(() => {
    router.push('/admin/transaction')
  })
}

onMounted(async () => {
  await axios.get('api/v1/cart', {
    headers: {
      Authorization: "Bearer " + user.token
    }
  }).then(({ data }) => {
    carts.value = data.carts
  })

  await axios.get('/api/v1/customers', {
    headers: {
      Authorization: "Bearer " + user.token
    }
  }).then(({ data }) => {
    customers.value = data.customers
  })
});

const format = (harga) => {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR"
  }).format(harga)
}
</script>

<template>
  <Navbar />
  <div class="container-fluid">
    <h2 class="mt-3 text-center"> Keranjang </h2>
    <div class="container">
      <p>Select Customer</p>
      <select v-model="selectedCustomer">
        <option v-for="customer in customers" :key="customer.id" :value="customer.id">{{ customer.name }}</option>
      </select>
    </div>
    <table class="table container">
      <thead>
        <tr>
          <th>gambar</th>
          <th>Nama</th>
          <th>harga</th>
          <th>jumlah</th>
          <th>total</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="cart in carts" :key="cart.id">
          <td>
            <img :src="cart.sparepart.image" :alt="cart.sparepart.name" width="150" />
          </td>
          <td>
            <p>{{ cart.sparepart.name }}</p>
          </td>
          <td>
            <p>{{ format(cart.sparepart.price) }}</p>
          </td>
          <td>
            <div class="border count" style="">
              <button class="btn" @click="cart.qty += 1">+</button>
              <input type="number" :value="cart.qty" class="w-25 border-0 text-center">
              <button class="btn" @click="cart.qty -= 1">-</button>
            </div>
          </td>
          <td>
            <p>{{ format(cart.qty * cart.sparepart.price) }}</p>
          </td>
          <td>
            <button class="btn">x</button>
          </td>
        </tr>
      </tbody>
    </table>
      <div class="card w-50 d-flex float-end">
        <div class="card-body w-50">
          <h3>Total</h3>
          {{ format(total) }}
        </div>
        <button @click="submit" class="btn btn-submit text-white">Submit</button>
      </div>
  
  </div>
  <Footer />
</template>

<style scoped>
main {
  position: relative;
}

div.banner {
  padding: 0 !important;
}

.banner-img {
  height: 150px;
  object-fit: cover;
}

.banner-text {
  position: absolute;
  top: 40%;
  left: 40%;
  right: 40%;
  width: 100%;
  margin: 0 auto;
  z-index: 10;
  /* transform: translate(-50%, -50%); */
  color: white;
}

.count {
  display: flex;
  justify-content: space-between;
  width: 110px;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type=number] {
  -moz-appearance: textfield;
}

.btn-submit {
  background-color: var(--color-primary)
}
</style>
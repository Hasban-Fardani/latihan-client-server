<script setup>
import { useRoute } from 'vue-router';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import NavBar from '@/components/NavBar.vue';
import Footer from '@/components/Footer.vue';

const route = useRoute()
const sparepartId = route.params.id

let sparepart = ref({
    id: 0,
    category: {},
    image: "",
    name: "",
    price: 0,
    stok: 0  
})

onMounted(async () => {
    await axios.get('/api/v1/sparepart/1' + sparepartId).then(({data}) => {
        sparepart.value = data.sparepart
        console.log(data)
    })
})

const format = (harga) => {
    return new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR"
    }).format(harga)
}
</script>
<template>
    <NavBar/>
    <main class="container-fluid d-flex justify-content-center gap-3 mt-3">
        <div class="card card-left">
            <div class="row">
                <div class="col-md-6">
                    <img :src="sparepart.image" class="card-img-top" :alt="sparepart.name">
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                      <h3 class="card-title fw-bold">{{ sparepart.name }}</h3>
                      <span class="badge bg-primary">{{ sparepart['category']['name'] }}</span>
                      <p class="card-text mt-2">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h3 class="card-title fw-bold">{{ format(sparepart.price) }}</h3>
                <div class="d-flex w-100 justify-content-between mt-3">
                    <button class="btn btn-checkout">Checkout</button>
                    <button class="btn"><i class="bi bi-cart-fill"></i></button>
                </div>
            </div>
        </div>
    </main>
    <Footer/>
</template>
<style scoped>
.card-left {
    width: 70%;
}
.btn-checkout {
    background-color: var(--color-primary);
    color: white;
    border: none;
}
</style>
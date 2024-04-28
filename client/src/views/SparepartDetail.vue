<script setup>
import { useRoute } from 'vue-router';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import NavBar from '@/components/NavBar.vue';
import Footer from '@/components/Footer.vue';
import router from '@/router';
import { useUser } from '@/stores/user';

const user = useUser()
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

const countOnCart = ref(1);

onMounted(async () => {
    await axios.get('/api/v1/sparepart/1' + sparepartId).then(({ data }) => {
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

const addCart = async () => {
    await axios.post('api/v1/cart', {
        sparepart_id: sparepartId,
        qty: countOnCart.value
    }, {
        headers: {
            Authorization: "Bearer " + user.token
        }
    }).then((response) => {
        alert(response.data.message)
        router.push('/cart')
        console.log(response);
    }).catch((e) => {
        alert(e.response.data.message)
        router.push('/login')
    });
}
</script>
<template>
    <NavBar />
    <main class="container-fluid d-flex justify-content-center gap-3 mt-3 flex-grow">
        <div class="card card-left">
            <div class="row">
                <div class="col-md-6">
                    <img :src="sparepart.image" class="card-img-top" :alt="sparepart.name">
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h3 class="card-title fw-bold">{{ sparepart.name }}</h3>
                        <span class="badge bg-primary">{{ sparepart['category']['name'] }}</span>
                        <p class="card-text mt-2">

                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h3 class="card-title fw-bold">{{ format(sparepart.price) }}</h3>
                <div>
                    <button class="btn" @click="countOnCart += 1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-plus-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                        </svg>
                    </button>
                    <input type="number" placeholder="count" class="w-25" min="1" v-model="countOnCart">
                    <button class="btn" @click="countOnCart -= countOnCart > 1 ? 1 : 0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-dash-square" viewBox="0 0 16 16">
                            <path
                                d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                            <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8" />
                        </svg>
                    </button>
                </div>
                <div class="d-flex w-100 justify-content-between mt-3">
                    <button class="btn btn-checkout" @click="addCart">Checkout</button>
                    <button class="btn"><i class="bi bi-cart-fill"></i></button>
                </div>
            </div>
        </div>
    </main>
    <Footer/>
</template>
<style scoped>
main {
    display: flex !important;
    flex: 1;
}
.card-left {
    width: 70%;
}

.btn-checkout {
    background-color: var(--color-primary);
    color: white;
    border: none;
}
</style>
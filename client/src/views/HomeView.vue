<script setup>
import Navbar from '@/components/NavBar.vue'
import SparepartCard from '@/components/SparepartCard.vue'
import Footer from '@/components/Footer.vue'
import { onMounted, ref } from 'vue';
import axios from 'axios';


const getSparepart = async (search) => {
  let url = 'api/v1/sparepart/list?limit=8'
  if (search) {
    url = 'api/v1/sparepart/list?limit=8&q=' + search
  }

  return axios.get(url).then(({ data }) => {
    spareparts.value = data.spareparts
  })
}

let spareparts = ref([])

onMounted(async () => {
  await getSparepart()
});

const doSearch = (q) => {
  getSparepart(q.value)
}
</script>

<template>
  <Navbar @search="doSearch" />
  <div class="container-fluid">
    <div class="row position-relative">
      <div class="col-12 banner">
        <img src="/images/banner.jpg" class="w-100 banner-img" alt="">
      </div>
      <div class="banner-text">
        <h2>HFOtoparts</h2>
      </div>
    </div>
  </div>
  <main class="container  mt-4">
    <h2 class="text-center">Produk</h2>
    <div class="d-flex justify-content-center flex-wrap gap-4 mt-3" v-if="spareparts.value == null">
      <SparepartCard v-for="sparepart in spareparts" :key="sparepart.id" :id="sparepart.id" :image="sparepart.image"
        :title="sparepart.name" :description="sparepart.name" :price="sparepart.price" />
    </div>
    <div class="d-flex justify-content-center mt-5" v-else>
      <h4>Datanya gak ada</h4>
    </div>
  </main>
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
</style>
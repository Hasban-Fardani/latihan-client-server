<script setup>
import Navbar from '@/components/NavBar.vue'
import SparepartCard from '@/components/SparepartCard.vue'
import Footer from '@/components/Footer.vue'
import { onMounted, ref } from 'vue';
import axios from 'axios';

let spareparts = ref([])
onMounted(async () => {
  await axios.get('api/v1/sparepart/list?limit=8').then(({data}) => {
    spareparts.value = data.spareparts
  })
});
</script>

<template>
  <Navbar/>
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
    <h2 class="text-center">Produk Pilihan</h2>
    <div class="d-flex justify-content-center flex-wrap gap-4 mt-3">
      <SparepartCard
        v-for="sparepart in spareparts"
        :key="sparepart.id" 
        :id="sparepart.id"
        :image="sparepart.image" 
        :title="sparepart.name" 
        :description="sparepart.name" 
        :price="sparepart.price" 
        />
    </div>
  </main>
  <Footer/>
</template>

<style scoped>
main {
  position: relative;
}

div.banner {
  padding: 0 !important;
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
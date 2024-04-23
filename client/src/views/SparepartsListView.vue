<script setup>
import NavBar from '@/components/NavBar.vue';
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
<NavBar/>
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
<Footer/>
</template>
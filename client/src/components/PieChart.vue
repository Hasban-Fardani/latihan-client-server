<script setup>
import { Pie } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement, Colors } from 'chart.js'
import { ref, onMounted } from 'vue';
import { useUser } from '@/stores/user'
import axios from 'axios'

ChartJS.register(Title, Tooltip, Legend, ArcElement, Colors)
let data = ref({
    labels: [],
    datasets: [
        {
            label: 'Data Penjualan',

        },
    ]
})

const user = useUser()
onMounted(async () => {
    await axios.get('/api/v1/admin/category-analytics', {
        headers: {
            Authorization: 'Bearer ' + user.token
        }
    }).then((res) => {
        console.log(res)
        data.value = res.data
    })
})
</script>
<template>
    <Pie :data="data" class="w-auto" />
</template>
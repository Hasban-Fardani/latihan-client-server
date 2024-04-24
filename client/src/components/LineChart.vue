<script setup>
import { Line } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, PointElement, CategoryScale, LinearScale } from 'chart.js'
import { onMounted, ref } from 'vue';
import { useUser } from '@/stores/user'
import axios from 'axios';


ChartJS.register(Title, Tooltip, Legend, LineElement, PointElement, CategoryScale, LinearScale)
let data = ref({
    labels: ["2024-04-30", "2024-04-27", "2024-04-29", "2024-04-28", "2024-04-27", "2024-04-26"],
    datasets: [
        {
            label: 'Data Penjualan',
            backgroundColor: '#2772f5',
        },
    ]
})

const user = useUser()
onMounted(async () => {
    await axios.get('/api/v1/admin/transaction-analytics', {
        headers: {
            Authorization: 'Bearer ' + user.token
        }
    }).then((res) => {
        console.log(res)
        data.value = res.data
        // console.log(data.value)
    })
})

</script>
<template>
    <Line :data="data" class="w-auto" />
</template>
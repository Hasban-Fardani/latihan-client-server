<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';
import LineChart from '@/components/LineChart.vue';
import PieChart from '@/components/PieChart.vue';

</script>
<template>
    <AdminLayout>
        <template v-slot:title>
            <h2>Dashboard</h2>
        </template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <LineChart />
                </div>
                <div class="col-md-4">
                    <PieChart />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
<style scoped>
.container {
    min-height: 80vh;
}
</style>
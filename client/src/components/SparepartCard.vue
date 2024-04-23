<script setup>
defineProps(['id', 'title', 'image', 'description', 'price'])
const format = (harga) => {
    return new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR"
    }).format(harga)
}
</script>
<template>
    <div class="card">
        <div class="card-img">
            <img :src="image" class="card-img-top" :alt="title">
        </div>
        <div class="card-body">
            <div class="card-description">
                <h5 class="card-title">{{ title }}</h5>
                <p>{{ description }}</p>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <b>{{ format(price) }}</b>
                <RouterLink 
                    class="btn text-light" 
                    style="background-color: var(--color-primary);" 
                    :to="'/spareparts/details/' + id"
                >
                    Beli
                </RouterLink>
            </div>
        </div>
    </div>
</template>
<style scoped>
.card {
    width: 100%;
    min-width: 230px;
    max-width: 260px
}

.card-img {
    min-height: 195px;
}

.card-img-top {
    height: 100%
}

.card-description {
    height: 100px
}
</style>
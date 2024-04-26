<script setup>
import SideBar from '@/components/SideBar.vue';
import router from '@/router';
import { useUser } from '@/stores/user';
import { onMounted } from 'vue';

const user = useUser()
onMounted(() => {
    user.verify().catch(()=>{
        user.clear()
    })
})

const logout = async () => {
    user.logout().then(() => {
        router.push('/')
    })
}
</script>

<template>
    <div class="d-flex flex-nowrap wrapper">
        <SideBar />
        <div class="container mt-3">
            <div class="d-flex justify-content-between">
                <div>
                    <slot name="title" />
                </div>
                <div class="dropdown">
                    <RouterLink to="#"
                        class="d-flex gap-2 align-items-center link-body-emphasis text-decoration-none dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"> </i>
                        <strong>{{ user.name }}</strong>
                    </RouterLink>
                    <ul class="dropdown-menu text-small shadow">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><button class="dropdown-item" @click="logout">Sign out</button></li>
                    </ul>
                </div>
            </div>
            <slot />
        </div>
    </div>
</template>
<style scoped>
.wrapper {
    min-height: 100vh;
}
</style>
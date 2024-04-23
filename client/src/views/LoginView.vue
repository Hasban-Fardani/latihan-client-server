<script setup>
import { useUser } from '@/stores/user';
import { onBeforeMount, ref } from 'vue'
import NavBar from '@/components/NavBar.vue';
import router from '@/router';


const user = useUser();
const formData = ref({
  email: "",
  password: ""
})
const error = ref('')

const login = async () => {
  let { email, password } = formData.value
  await user.login(email, password).then(()=>{
    router.push({path: '/'})
  }).catch(({response}) => {
    error.value = response.data.message
  })
}

onBeforeMount(() => {
  if (user.token) {
    router.push('/')
  }
})
</script>

<template>
  <NavBar/>
  <div class="alert alert-danger d-flex w-100 justify-content-between" role="alert" v-if="error">
    <span>
      {{ error }}
    </span>
    <button type="button" class="btn-close" aria-label="Close" @click="error=''"></button>
  </div>
  <main class="container-fluid mt-3">
    <h2>Login</h2>
    <div class="card">
      <div class="card-body">
        <form @submit.prevent="login">
          <label for="email" class="form-label">Email</label>
          <input type="email" v-model="formData.email" class="form-control">
          <label for="password" class="form-label">Password</label>
          <input type="password" v-model="formData.password" class="form-control">
          <span>
            Tidak punya akun? 
            <RouterLink to="/register">Register</RouterLink>
          </span>
          <br>
          <button type="submit" class="btn btn-primary mt-2">Login</button>
        </form>
      </div>
    </div>   
  </main>
</template>

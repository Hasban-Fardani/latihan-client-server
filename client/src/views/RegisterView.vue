<script setup>
import router from '@/router';
import { useUser } from '@/stores/user';
import { ref } from 'vue'
import NavBar from '@/components/NavBar.vue';

const user = useUser();

const formData = ref({
  name: "",
  email: "",
  password: ""
})

const register = async () => {
  let { name, email, password } = formData.value

  await user.register(name, email, password).then(()=>{
    router.push({path: '/'})
  })
}
</script>

<template>
  <NavBar/>
  <main class="container-fluid mt-3">
    <h2>Register</h2>
    <div class="card">
      <div class="card-body">
        <form @submit.prevent="register">
            
          <label for="name" class="form-label">Name</label>
          <input type="text" v-model="formData.name" class="form-control">
          <label for="email" class="form-label">Email</label>
          <input type="email" v-model="formData.email" class="form-control">
          <label for="password" class="form-label">Password</label>
          <input type="password" v-model="formData.password" class="form-control">
          <button type="submit" class="btn btn-primary mt-2">Register</button>
        </form>
      </div>
    </div>   
  </main>
</template>

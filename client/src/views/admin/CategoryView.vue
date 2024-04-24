<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';
import { useUser } from '@/stores/user'
import { ref, onMounted } from 'vue'
import axios from 'axios'


const getCategories = async () => {
  await axios.get('api/v1/category', {
    headers: {
      Authorization: "Bearer " + user.token
    }
  }).then(({ data }) => {
    categories.value = data.categories
  })
}


const user = useUser()
const categories = ref([])
onMounted(async () => {
  await user.verify()
  getCategories()
})

const formData = ref({
  name: "",
  slug: ""
})

const addCategory = async () => {
  axios.post('api/v1/category', formData.value, {
    headers: {
      Authorization: "Bearer " + user.token
    }
  }).then(() => {
    getCategories()
  })
}
</script>
<template>
  <AdminLayout>
    <template v-slot:title>
      <h2>Kategori</h2>
    </template>
    <div class="container-fluid mt-3">
      <div class="row">
        <div class="col-6">
          <div class="card">
            <div class="card-body">
              <h4>Buat kategori baru</h4>
              <form @submit.prevent="addCategory">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" name="name" v-model="formData.name">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control" name="slug" v-model="formData.slug">

                <button type="submit" class="btn mt-2 btn-red">Simpan</button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="card">
            <div class="card-body">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Nama</th>
                    <th scope="col">Slug</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="category in categories" :key="category.id">
                    <td>
                      <p>{{ category.name }}</p>
                    </td>
                    <td>
                      <p>{{ category.slug }}</p>
                    </td>
                    <td>
                      <button class="btn btn-red">
                        <i class="bi bi-trash-fill"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped>
.btn-red {
  background-color: var(--color-primary);
  color: white;
}
</style>
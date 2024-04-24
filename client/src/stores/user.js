import { computed} from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import router from '@/router'

export const useUser = defineStore('user', () => {
  let name = computed(() => localStorage.getItem('name'))
  let token = computed(() => localStorage.getItem('token'))
  let role = computed(() => localStorage.getItem('role'))

  function clear() {
    localStorage.removeItem('name')
    localStorage.removeItem('token')
    localStorage.removeItem('role')
  }

  async function login(email, password) {
    return axios.post('/api/v1/auth/login', {
      email: email,
      password: password
    }).then(({data}) => {
      let data_name = data.user.name
      localStorage.setItem('name', data_name)
      
      let data_token = data.user.accessToken
      localStorage.setItem('token', data_token)

      let data_role = data.user.role
      localStorage.setItem('role', data_role)
      location.reload()
    })
  }

  async function register(name, email, password) {
    return axios.post('/api/v1/auth/register', {
      name: name,
      email: email,
      password: password
    })
  }

  async function logout() {
    return await axios.post('api/v1/auth/logout', null, {
        headers: {
          Authorization: "Bearer " + token.value 
        }
      }).then(() => {
        clear();
        location.reload()
      }) 
  }

  async function verify() {
    if (!name.value || !token.value) {
      return router.push('/login')
    } 

    return await axios.get('api/v1/auth/me', {
      headers: {
        Authorization: "Bearer " + token.value
      }
    }).then(({data}) => {
      let data_name = data.name
      localStorage.setItem('name', data_name)
      
      let data_role = data.role
      localStorage.setItem('role', data_role)
    }).catch(() => {
      clear()
      router.push('/login')
    })
  }

  return { name, token, role, login, logout, register, verify }
})

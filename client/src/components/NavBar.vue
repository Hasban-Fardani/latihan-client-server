<script setup>
import { useUser } from '@/stores/user';

const user = useUser()
</script>
<template>
  <nav class="navbar navbar-expand-lg" style="background-color: var(--color-primary);" data-bs-theme="dark">
    <div class="container-fluid">
      <RouterLink class="navbar-brand fw-bold" style="letter-spacing: -1px;" to="/">
        HFOtoparts
      </RouterLink>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <RouterLink class="nav-link" :class="{ 'active': $route.path === '/' }" aria-current="page" to="/">Home
            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link" :class="{ 'active': $route.path === '/spareparts' }" to="/spareparts">Sparepart
            </RouterLink>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Kategori
            </a>
            <ul class="dropdown-menu">
              <li>
                <RouterLink class="dropdown-item" to="/">Category1</RouterLink>
              </li>
              <li>
                <RouterLink class="dropdown-item" to="/">Category2</RouterLink>
              </li>
            </ul>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0" v-if="user.token">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-fill"></i>
              {{ user.name }}
            </a>
            <ul class="dropdown-menu">
              <li>
                <RouterLink class="dropdown-item" to="/admin/dashboard" v-if="user.role == 'admin'">Dashboard
                </RouterLink>
              </li>
              <li><button class="dropdown-item" @click="user.logout">Logout</button></li>
            </ul>
          </li>

          <li class="nav-item">
            <RouterLink class="nav-link" to="/">
              <i class="bi bi-cart-fill"></i>
              Cart
            </RouterLink>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0" v-else>
          <RouterLink to="/login" class="btn btn-light">
            Login
          </RouterLink>
        </ul>
      </div>
    </div>
  </nav>
</template>
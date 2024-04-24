<template>
  <div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary text-light" data-bs-theme="dark" id="sidebar">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
      <svg class="bi pe-none me-2" width="40" height="32">
        <use xlink:href="#bootstrap"></use>
      </svg>
      <span class="fs-4">HFOtoparts</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <RouterLink to="/" class="nav-link" aria-current="page">
          <svg class="bi pe-none me-2" width="16" height="16">
            <use xlink:href="#home"></use>
          </svg>
          Home
        </RouterLink>
      </li>
      <li>
        <RouterLink to="/admin/dashboard" :class="{ 'active': $route.path === '/admin/dashboard' }"
          class="nav-link link-body-emphasis">
          <svg class="bi pe-none me-2" width="16" height="16">
            <use xlink:href="#speedometer2"></use>
          </svg>
          Dashboard
        </RouterLink>
      </li>
      <li>
        <RouterLink to="/admin/sparepart" :class="{ 'active': $route.path === '/admin/sparepart' }"
          class="nav-link link-body-emphasis">
          <svg class="bi pe-none me-2" width="16" height="16">
            <use xlink:href="#table"></use>
          </svg>
          Sparepart
        </RouterLink>
      </li>
      <li>
        <RouterLink to="/admin/category" :class="{ 'active': $route.path === '/admin/category' }"
          class="nav-link link-body-emphasis">
          <svg class="bi pe-none me-2" width="16" height="16">
            <use xlink:href="#table"></use>
          </svg>
          Kategori
        </RouterLink>
      </li>
      <li>
        <RouterLink to="/admin/transaction" :class="{ 'active': $route.path === '/admin/transaction' }"
          class="nav-link link-body-emphasis">
          <svg class="bi pe-none me-2" width="16" height="16">
            <use xlink:href="#grid"></use>
          </svg>
          Transaksi
        </RouterLink>
      </li>
      <li>
        <RouterLink to="/admin/user" :class="{ 'active': $route.path === '/admin/user' }"
          class="nav-link link-body-emphasis">
          <svg class="bi pe-none me-2" width="16" height="16">
            <use xlink:href="#people-circle"></use>
          </svg>
          User
        </RouterLink>
      </li>
    </ul>
  </div>
</template>
<style scoped>
#sidebar {
  width: 250px;
  background-color: #e52727 !important;
}

.active {
  background-color: #b21e1e !important;
}

.nav-link {
  color: white !important;
}
</style>
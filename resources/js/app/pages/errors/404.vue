<template>
  <div class="text-center">
    <h1 class="mt-5">404</h1>
      <router-link :to="{ name: 'home' }">
       Regresar
      </router-link>
  </div>
</template>

<script>
export default {
  name: 'NotFound'
}
</script>

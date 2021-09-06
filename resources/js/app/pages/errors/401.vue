<template>
  <div class="text-center">
    <h1 class="mt-5">401</h1>
    <p class="mt-5">No estas autorizdo para esta acción</p>
      <router-link :to="{ name: 'home' }">
       Regresar
      </router-link>
  </div>
</template>

<script>
export default {
  name: 'Unauthorized'
}
</script>

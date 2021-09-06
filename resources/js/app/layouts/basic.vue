<template>
    <router-view :key="$route.fullPath" />
</template>

<script>
export default {
  name: "BasicLayout",
  components: {},
  data() {
    return {};
  },
};
</script>

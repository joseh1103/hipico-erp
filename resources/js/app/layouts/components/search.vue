<template>
<div>
 <v-select label="categoria"
  class="style-search"
  placeholder="Buscardor General"
  @input="setProductForm" 
  :options="options" 
  @search="searchGeneral">

 <template v-slot:option="option">
    {{ option.categoria }}
  </template>


    <template slot="no-options">
        No hay resultados encontrados
    </template>
  </v-select>
</div>
</template>

<script>
export default {
    props: {
      selectProduct: Function,
      soloInverted: Boolean
    },
    data () {
      return {
        loading: false,
        options: [],
        product: ''
      }
    },
    watch: {
    },
    methods: {
      setProductForm(item) {
        if (item) this.$router.push({ path: item.key });
      },
      async searchGeneral(input) {
        const client_id = this.client_id ? this.client_id : null;
        if (input.length < 1) { return [] }
        const data = await this.$store.dispatch('searchGeneral', { params: {search: input} } );
        console.log(data);
        this.options = data;
      }
    },
  }
</script>
<style>
.style-search{
width: 350px;
}
  .style-search .vs__search::placeholder,
  .style-search .vs__dropdown-toggle,
  .style-search .vs__dropdown-menu {
    background: #FFFFFF;
    color: #EB7D25;
  }

  .style-search .vs__clear,
  .style-search .vs__open-indicator {
    fill: #EB7D25;
  }
</style>
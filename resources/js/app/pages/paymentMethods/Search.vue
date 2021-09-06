<template>
<div>
 <v-select label="description" v-model="product" 
  class="style-search"
  placeholder="Buscar Producto"
  @input="setProductForm" 
  :options="products" 
  @search="fetchProduct">
    <template slot="no-options">
        No hay producto encontrados
    </template>
  </v-select>
</div>
</template>

<script>
export default {
    props: {
      selectProduct: Function,
      soloInverted: Boolean,
      editedItem: Object,
      client_id: Number,
      validate: Boolean
    },
    data () {
      return {
        loading: false,
        products: [],
        product: ''
      }
    },
    watch: {
      async editedItem (value) {
        if (value.product_id) { 
          await this.fetchProduct(value.product_id)
          const item = this.products.shift()
          this.selectProduct(item)
          this.product = item.description
        } else {
          this.product = ''
        }
      }
    },
    methods: {
      setProductForm(item) {
        this.selectProduct(item)
      },
      async fetchProduct(input) {
        const validate = this.validate ? this.validate : null;
        const client_id = this.client_id ? this.client_id : null;
        if (input.length < 1) { return [] }
        const data = await this.$store.dispatch('product/search', { params: {search: input, client_id: client_id, validate: validate } } );
        this.products = data;
      }
    },
  }
</script>


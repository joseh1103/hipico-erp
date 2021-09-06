<template>
  <div class="pt-2 mb-2">
    <div class="d-flex justify-content-end">
      <div
        class="btn-group border-info bg-white"
        role="group"
        aria-label="Basic example"
      >
        <!-- Button trigger modal -->
        <button
          type="button"
          class="btn btn-primary"
          data-toggle="modal"
          data-target="#productModal"
          @click="newProduct()"
        >
          <i class="white fas fa-plus-square"></i>
             
        </button>

       
      </div>
    </div>

    <Index :changeform="changeform" :fetchData="fetchData" :status="status"></Index>
    <!-- Modal editar o crear producto -->
    <Modal :editedItem="editedItem" :currency="currency" :fetchData="fetchData" :typePayment="typePayment" :typeDocument="typeDocument"></Modal>


    
  </div>
</template>
<script>
import { mapState } from "vuex";
import Index from './Index.vue'
import Modal from './Modal.vue'
export default {
  middleware: 'auth',
  components: {
    Index,
    Modal
  },
  data() {
    return {
      editedItem: {},
      queryParams: {
        global_search: "",
        per_page: 10,
        page: 0,
      },
      typePayment: ['Transferencia', 'Zelle'],
      typeDocument: ['V','E','P','J','G','M','C'],
      status: [
        {
          name: 'Activo',
          id: 1,
        },
        {
          name: 'Inactivo',
          id: 0,
        }
      ]
    };
  },
  computed: {
      ...mapState({
    currency: state => state.currency.currency,
    loading: state => state.currency.loading
  }),
  },
  methods: {
    newProduct() {
      this.editedItem = {}
    },
    changeform(valueNew) {
      this.editedItem = valueNew;
    },
    async fetchData(search,gsearch , limit = 10, offset = 0) {
      await this.$store.dispatch("paymentMethods/fetch", {
        params: {type: search > 0 ? search : 1, search: gsearch ,limit, offset}
      });
    },
    async fetchCurrency(search,gsearch , limit = 10, offset = 0) {
      await this.$store.dispatch("currency/fetch", {
        params: {type: search > 0 ? search : 1, search: gsearch ,limit, offset}
      });
    },
  },
  mounted(){
    this.fetchCurrency();
  },
};
</script>

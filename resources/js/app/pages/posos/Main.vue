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

    <Index :operations="operations" :changeform="changeform" :fetchData="fetchData" :statusPay="statusPay"></Index>
    <!-- Modal editar o crear producto -->
    <Modal :operations="operations" :statusPay="statusPay" :users="users" :editedItem="editedItem" :fetchData="fetchData"></Modal>


    
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
      statusPay: [
        {
          name: 'Pendiente',
          id: 0,
        },
        {
          name: 'Aprobado',
          id: 1,
        }
      ],
      operations: [
        {
          id: 1,
          name: 'Poso',
        },
        {
          id: 2,
          name: 'Retiro',
        },
        {
          id: 3,
          name: 'Transferir Saldo',
        }
      ]
    };
  },
  computed: {
     ...mapState({
    users: state => state.users.users
  }),
  },
  methods: {
    newProduct() {
      this.editedItem = {}
    },
    changeform(valueNew) {
      this.editedItem = valueNew;
    },
    async fetchData(global_search,to ,from, code_bank, payment_type, status_authorization , limit = 10, offset = 0) {
      await this.$store.dispatch("posos/fetch", {
        params: {search: global_search, to: to , from: from ,code_bank: code_bank ,payment_type: payment_type, status_authorization: status_authorization ,limit, offset}
      });
    },
    async fetchUsers() {
      await this.$store.dispatch('users/search', { params: {all: 1} } );
    },
  },
  mounted(){
    this.fetchUsers();
  },
};
</script>

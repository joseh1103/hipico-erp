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
          data-target="#userModal"
          data-backdrop="static" 
          data-keyboard="false"
          @click="newUser()"
        >
           <i class="white fas fa-plus-square"></i>
        </button>
      </div>
    </div>

    <Index :changeform="changeform" :fetchUsers="fetchUsers"></Index>
    <!-- Modal editar o crear producto -->
    <Modal :editedItem="editedItem" :fetchData="fetchUsers"></Modal>

  </div>
</template>
<script>
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
    };
  },
  methods: {
    newUser() {
      this.editedItem = {}
    },
    changeform(valueNew) {
      this.editedItem = valueNew;
    },
    async fetchUsers(status, search, limit = 2, offset = 0) {
      console.log('paso'+ limit);
      await this.$store.dispatch("users/fetch", {
        params: {status: status, search: search, limit, offset}
      });
    },
    async fetchRoles(search, limit = 10, offset = 0) {
      await this.$store.dispatch("role/fetch", {
        params: {search: search, limit, offset}
      });
    }
  },
  mounted(){
    this.fetchRoles();
  },
};
</script>

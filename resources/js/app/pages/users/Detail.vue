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
          @click="newUser()"
        >
           <i class="white fas fa-eye color-icon-d"></i>
        </button>
      </div>
    </div>

    <Index :changeform="changeform" :fetchDetail="fetchDetail"></Index>
    <!-- Modal editar o crear producto -->
    <ModalResumen :balance="balance"></ModalResumen>

  </div>
</template>
<script>
import { mapState } from "vuex";
import Index from './detail/Index.vue'
import ModalResumen from './ModalResumen.vue'
export default {
  middleware: 'auth',
  components: {
    Index,
    ModalResumen
  },
  data() {
    return {
      editedItem: {},
      queryParams: {
        global_search: "",
        per_page: 10,
        page: 0,
      },
    };
  },
  computed: {
     ...mapState({
    balance: state => state.users.balance,
    loading: state => state.users.loading,
  }),
  },
  methods: {
    newUser() {
      this.editedItem = {}
    },
    changeform(valueNew) {
      this.editedItem = valueNew;
    },
    async fetchDetail(jornada_id, limit = 10, offset = 0) {
      await this.$store.dispatch("users/detail", {
       params: {user_id: this.$route.params.id, jornada_id : jornada_id, limit, offset}
      });
    },
    async fetchJornadas(limit = 10, offset = 0) {
      await this.$store.dispatch("jornadas/fetch", {
        params: {filter: true, status: 1, limit, offset}
      });
    },
  },
  mounted(){
    this.fetchJornadas();
  },
};
</script>

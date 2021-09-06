<template>
  <div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="userModal"
      tabindex="-1"
      aria-labelledby="userModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-orange">
              
            <h5 class="modal-title text-light" id="userModalLabel">Resumen de Cuenta
             <span class="ml-5"> Usuario: {{ balance.user ? balance.user.user :'...' }} </span>
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <detailAccount :balance="balance"></detailAccount>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import detailAccount from './DetailAccount.vue'
export default {
  components: {
    detailAccount
  },
  props: {
    balance: Object
  },
  data() {
    return {
    };
  },
  methods: {
  }
};
</script>

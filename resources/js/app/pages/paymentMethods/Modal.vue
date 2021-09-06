<template>
  <div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="productModal"
      tabindex="-1"
      aria-labelledby="productModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-orange">
              
            <h5 class="modal-title text-light" id="productModalLabel">Nuevo Metodo de pago</h5>
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
              <createProducts :currency="currency" :editedItem="editedItem" :fetchData="fetchData" :typeDocument="typeDocument" :typePayment="typePayment"></createProducts>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import createProducts from './Create.vue'
export default {
  components: {
    createProducts
  },
  props: {
    editedItem: Object,
    fetchData: Function,
    typePayment: Array,
    typeDocument: Array,
    currency: Object,
  },
  data() {
    return {
    };
  },
  methods: {
  }
};
</script>

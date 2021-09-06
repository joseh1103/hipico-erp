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
      <div class="modal-dialog" :class="editedItem.product_id > 0 ? 'modal-lg' : ''">
        <div class="modal-content">
          <div class="modal-header bg-orange">
              
            <h5 class="modal-title text-light" id="productModalLabel">Tab Ponle</h5>
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
              <createProducts :editedItem="editedItem" :fetchData="fetchData" :status="status"></createProducts>
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
    status: Array
  },
  data() {
    return {
    };
  },
  methods: {
  }
};
</script>

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
              
            <h5 class="modal-title text-light" id="userModalLabel">Cliente</h5>
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
              <createUsers :editedItem="editedItem" :fetchData="fetchData"></createUsers>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import createUsers from './Create.vue'
export default {
  components: {
    createUsers
  },
  props: {
    editedItem: Object,
    fetchData: Function
  },
  data() {
    return {
    };
  },
  methods: {
  }
};
</script>

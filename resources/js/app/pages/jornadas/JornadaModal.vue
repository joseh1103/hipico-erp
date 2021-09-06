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
              
            <h5 class="modal-title text-light" id="userModalLabel">Jornada</h5>
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
              <CreateJornada :editedItem="editedItem" :fetchJornadas="fetchJornadas" :statusJornada="statusJornada"
              :typeJornada="typeJornada"></CreateJornada>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import CreateJornada from './components/CreateJornada'
export default {
  components: {
    CreateJornada
  },
  props: {
    editedItem: Object,
    fetchJornadas: Function,
    statusJornada: Array,
    typeJornada: Array
  },
  data() {
    return {
    };
  },
  methods: {
  }
};
</script>

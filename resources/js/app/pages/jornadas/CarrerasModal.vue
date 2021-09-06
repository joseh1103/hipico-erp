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
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header bg-orange">
              
            <h5 class="modal-title text-light" id="userModalLabel">
              {{ jornada.name }} - Carreras</h5>
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
              <createCarreras 
              :fetchSubasta="fetchSubasta"
              :jornada="jornada"
              :fetchJornadas="fetchJornadas" :statusJornada="statusJornada"
              ></createCarreras>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import createCarreras from './components/CreateCarreras'
export default {
  components: {
    createCarreras
  },
  props: {
    fetchJornadas: Function,
    fetchSubasta: Function,
    statusJornada: Array,
    jornada: Object,
    carreraActiva: Object
  },
  data() {
    return {
    };
  },
  methods: {
  }
};
</script>

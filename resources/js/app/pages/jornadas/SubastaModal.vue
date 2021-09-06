<template>
  <div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="subastaModal"
      tabindex="-1"
      aria-labelledby="subastaModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header bg-orange">
              
            <h5 class="modal-title text-light" id="subastaModalLabel">
              Carreras #{{ carreraActiva.carrera}}</h5>
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
              <CreateSubasta :usersList="usersList" :tabPonles="tabPonles" :fetchSubasta="fetchSubasta" :subasta="subasta" :carreraActiva="carreraActiva"></CreateSubasta>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import CreateSubasta from './components/CreateSubasta.vue'
export default {
  components: {
    CreateSubasta
  },
  props: {
    subasta: Object,
    carreraActiva: Object,
    fetchSubasta: Function,
    tabPonles: Object,
    usersList: Object
  },
  data() {
    return {
    };
  },
  methods: {
  }
};
</script>

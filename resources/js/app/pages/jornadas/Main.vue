<template>
 <div class="pt-2 mb-2">
    <div class="d-flex justify-content-end">
      <div class="form-group col-md-4">
 
      </div>
      <div class="form-group col-md-1">
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
           <i class="white fas fa-plus-square"></i>
        </button>

        <button
            type="button"
            class="btn btn-danger ml-3"
            data-toggle="modal"
            data-target="#pdfModal"
            @click="getPdf(true)"
          >
            <i class="white far fa-file-pdf"></i>
          </button>
      </div>
      </div>
    </div>
    <Index :changeform="changeform" :fetchJornadas="fetchJornadas" :statusJornada="statusJornada" :typeJornada="typeJornada"></Index>
    <!-- Modal editar o crear producto -->
    <JornadaModal :editedItem="editedItem" :fetchJornadas="fetchJornadas" :statusJornada="statusJornada"
    :typeJornada="typeJornada"></JornadaModal>

    
    <ReportModal
      :jornada_id="jornada_id"
      :report="report"
      :getPdf="getPdf"
    ></ReportModal>
 </div>
</template>
<script>
import Index from './Index.vue'
import JornadaModal from './JornadaModal.vue'
import ReportModal from "./ReportModal";
export default {
  middleware: 'auth',
  components: {
    Index,
    JornadaModal,
    ReportModal
  },
  data() {
    return {
      jornada_id: [],
      report: false,
      editedItem: {},
      statusJornada: [
        {
          id: 1,
          name: 'Activa'
        },
        {
          id: 2,
          name: 'Cerrada'
        }
      ],
      typeJornada: [
        {
          id: 1,
          name: 'Remate o Subasta'
        },
        {
          id: 2,
          name: 'Jugadas Entre Tercio'
        },
        {
          id: 3,
          name: 'Jugadas a Ganador'
        },
        {
          id: 4,
          name: 'Polla'
        }
      ],
      queryParams: {
        global_search: "",
        per_page: 10,
        page: 0,
      },
    };
  },
  methods: {
    getPdf(value) {
      this.report = value;
    },
    newUser() {
      this.editedItem = {}
    },
    changeform(valueNew) {
      this.editedItem = valueNew;
    },
    async fetchJornadas(typeJornada, status, limit = 10, offset = 0) {
      await this.$store.dispatch("jornadas/fetch", {
        params: {typeJornada: typeJornada, status: status, limit, offset}
      });
    },
    async fetchHipodromos(search, limit = 10, offset = 0) {
      await this.$store.dispatch("hipodromos/fetch", {
        params: {search: search, limit, offset}
      });
    },
    async fetchCurrency(search, limit = 10, offset = 0) {
      await this.$store.dispatch("currency/fetch", {
        params: {search: search, limit, offset}
      });
    }
  },
  mounted(){
    this.fetchHipodromos();
    this.fetchCurrency();
  },
};
</script>

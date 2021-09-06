<template>
  <div class="card mt-3">
    <div class="card-header">
      <h3 class="card-title">Apuestas Entre Tercios</h3>
      <div class="card-tools">
        <div class="form-row">
          <div class="form-group col-md-6">
            <select class="form-control" v-model="type_jornada">
              <option value="0">-Tipo Jornada-</option>
              <option
                v-for="type in typeJornada"
                :key="type.id"
                :value="type.id"
              >
                {{ type.name }}
              </option>
            </select>
          </div>

          <div class="form-group col-md-6">
            <select class="form-control" v-model="status">
              <option value="0">-Status-</option>
              <option
                v-for="statusJ in statusJornada"
                :key="statusJ.id"
                :value="statusJ.id"
              >
                {{ statusJ.name }}
              </option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <div class="card-body pt-4">
      <div class="row">
        <div class="col-6">
          <h3> Propuestas</h3>
          <table class="table table-sm">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Juega</th>
                <th>Da</th>
                <th>Jugada</th>
                <th style="width: 40px">Monto</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1.</td>
                <td>1.</td>
                <td>Update software</td>
                <td>
                  <div class="progress progress-xs">
                    <div
                      class="progress-bar progress-bar-danger"
                      style="width: 55%"
                    ></div>
                  </div>
                </td>
                <td><span class="badge bg-danger">55%</span></td>
              </tr>
              
            </tbody>
          </table>
        </div>
        <div class="col-6">
          <h3>Nueva Jugada</h3>

           <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">-$ </span>
            </div>
            <input
              type="text"
              v-model="form.monto"
              placeholder="Monto"
              class="form-control no-border-radius"
            />
            <div class="input-group-append">
              <span class="input-group-text no-border-radius">.00</span>
            </div>
          </div>

      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"
            ><i class="fas fa-sort"></i></span>
        </div>
        <select class="form-control" v-model="form.hipodromo_id" required>
          <option disabled value="">- Selecione Hipodromo -</option>
          <option
            v-for="hipodromo in hipodromos.data"
            :key="hipodromo.id"
            :value="hipodromo.id"
          >
            {{ hipodromo.name }}
          </option>
        </select>
      </div> 

     <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"
            ><i class="fas fa-sort"></i></span>
        </div>
        <select class="form-control" v-model="form.jugadas_id" required>
          <option disabled value="">- Selecione Jugada -</option>
          <option
            v-for="jugada in typeJugadas.data"
            :key="jugada.id"
            :value="jugada.id"
          >
            {{ jugada.name }}
          </option>
        </select>
      </div> 
          
        </div>
      </div>
    </div>

    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</template>

<script>
import { mapState } from "vuex";
import VueBootstrap4Table from "vue-bootstrap4-table";
export default {
  props: {
    changeform: Function,
    typeJornada: Array,
    statusJornada: Array,
    jornada_id: Array,
  },
  components: {
    VueBootstrap4Table,
  },
  data() {
    return {
      form: {
        hipodromo_id: null,
        jugadas_id: null,
        monto: null,
      },
      columns: [
        {
          label: "ID",
          name: "id",
        },
        {
          label: "Nombre",
          name: "name",
        },
        {
          label: "Comisión",
          name: "commission",
        },
        {
          label: "Fecha",
          name: "date",
        },
        {
          label: "Movil",
          name: "movil",
          slot_name: "movil-slot",
        },
        {
          label: "Abiertas / Cerradas",
          name: "status",
          slot_name: "status-carrera-slot",
        },
        {
          label: "Status",
          name: "status",
          slot_name: "status-slot",
        },
        {
          label: "Actions",
          name: "id",
          slot_name: "action-slot",
        },
      ],
      config: {
        card_mode: false,
        global_search: {
          visibility: false,
          case_sensitive: false,
          showClearButton: false,
          searchOnPressEnter: false,
        },
        server_mode: true,
        pagination: true, // default true
        pagination_info: false, // default true
        num_of_visibile_pagination_buttons: 7,
        per_page_options: [5, 10, 20, 30],
        show_refresh_button: false,
        show_reset_button: false,
        preservePageOnDataChange: true,
        loaderText: "Cargando...",
      },
      queryParams: {
        global_search: "",
        per_page: 10,
        page: 1,
      },
      status: 0,
      type_jornada: 0,
    };
  },
  computed: {
    ...mapState({
      jornadas: (state) => state.jornadas.jornadas,
      loading: (state) => state.jornadas.loading,
      hipodromos:  state => state.hipodromos.hipodromos,
      typeJugadas:  state => state.jugadasTercios.typeJugadas,
    }),
  },
  watch: {
  },
  methods: {
    async fetchHipodromos(search, limit = 1, offset = 0) {
      await this.$store.dispatch("hipodromos/fetch", {
        params: {search: search, limit, offset}
      });
    },
    async fetchJugadas(search, limit = 10, offset = 0) {
      await this.$store.dispatch("jugadasTercios/fetch", {
        params: {search: search, limit, offset}
      });
    },
  },
  mounted(){
    this.fetchHipodromos();
    this.fetchJugadas();
  },
};
</script>
<style>
.style-search-jornada .vs__search::placeholder,
.style-search-jornada .vs__dropdown-toggle,
.style-search-jornada .vs__dropdown-menu {
  background: #ffffff;
  color: #eb7d25;
}

.style-search-jornada .vs__clear,
.style-search-jornada .vs__open-indicator {
  fill: #eb7d25;
}
.style-search-jornada {
  width: 100% !important;
  min-width: 150px;
}

.vs__search,
.vs__search:focus {
  line-height: 2 !important;
}
</style>

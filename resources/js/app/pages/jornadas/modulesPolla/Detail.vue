<template>
  <div>
    <div class="card mt-3">
      <div class="card-header">
        <h3 class="card-title">{{ jornada.name }}</h3>
        <div class="card-tools">

          <button
            type="button"
            class="btn btn-success"
            data-toggle="modal"
            data-target="#notificationsModal"
            data-backdrop="static" data-keyboard="false"
            style="margin-right: 3px"
          >
            <i class="white fas fa-bullhorn"></i>
          </button>

          <button
            type="button"
            class="btn btn-warning"
            data-toggle="modal"
            data-target="#userModal"
            data-backdrop="static" data-keyboard="false"
            style="margin-right: 3px"
          >
            <i class="white fas fa-flag-checkered"></i>
          </button>

          <button
            type="button"
            class="btn btn-danger"
            data-toggle="modal"
            data-target="#pdfModal"
            @click="getPdf(true)"
          >
            <i class="white far fa-file-pdf"></i>
          </button>
        </div>
      </div>

      <!-- Tab Carreras-->
      <div class="tab-button-outer">
        <ul id="tab-button">
          <li
            v-for="carrera in jornada.carreras"
            :key="carrera.id"
            :class="carrera.carrera == carreraActiva.carrera ? 'is-active' : ''"
          >
            <a @click="selectCarrera(carrera)" class="tab-carrera">
              {{ `${carrera.carrera}-Carrera` }}</a
            >
          </li>
        </ul>
      </div>

      <div class="row">
        <div class="col-xs-12 col-md-8">
          <div class="row">
            <div class="play-table col-xs-12 col-md-8">
              
              <TablePolla :fetchCarrera="fetchCarrera"> </TablePolla>
            </div>
            <div class="col-xs-12 col-md-4">
              <CardPanelCarrera
                :subasta="polla"
                :jornada="jornada"
              ></CardPanelCarrera>
            </div>
          </div>
        </div>

        <div class="col-xs-12 col-md-4">
          <h3>Orden De llegada</h3>

          <div class="input-group mb-3" 
           v-for="(orden, key) in ordenOficial"
            :key="key">
            <div class="input-group-prepend">
              <span class="input-group-text">-</span>
            </div>
            <input
              type="text"
              v-model="orden.num"
              placeholder="Numero"
              class="form-control no-border-radius"
            />
            <input
              type="text"
              v-model="orden.puntos"
              placeholder="Puntos"
              class="form-control no-border-radius"
            />
            <div class="input-group-append">
               <button
                type="button"
                @click.prevent="additemOrden()"
                class="btn bg-orange text-light btn-save"
                data-dismiss="modal"
                aria-label="Close"
                >
                +
                </button>

            </div>
          </div>


          <div class="d-flex justify-content-end">
                <button
                style="margin:10px !important;"
                type="button"
                @click.prevent="update"
                class="btn bg-orange text-light btn-save"
                data-dismiss="modal"
                aria-label="Close"
                >
                Actualizar
                </button>
            </div>


          <h3>Actualizar Retirados</h3>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">-</span>
            </div>
            <input
              type="text"
              v-model="retirados.viejo"
              placeholder="Numero Retirado"
              class="form-control no-border-radius"
            />
            <input
              type="text"
              v-model="retirados.nuevo"
              placeholder="Numero Nuevo"
              class="form-control no-border-radius"
            />
          </div>


          <div class="d-flex justify-content-end">
              <button
                  style="margin:10px !important;"
                  type="button"
                  @click.prevent="premiarPolla"
                  class="btn bg-danger text-light btn-save"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                Premiar
                </button>

                <button
                style="margin:10px !important;"
                type="button"
                @click.prevent="update"
                class="btn bg-orange text-light btn-save"
                data-dismiss="modal"
                aria-label="Close"
                >
                Actualizar
                </button>
            </div>
          <div class="users-table">
            <TableUser></TableUser>
          </div>
            



<button class="botonF1" data-toggle="modal" data-target="#newPollaModal" data-backdrop="static" data-keyboard="false">
  <span>+</span>
</button>

<CreateNewPolla :jornada="jornada" :fetchCarrera="fetchCarrera"></CreateNewPolla>
          


          <!-- card.// -->
        </div>


        
      </div>
    </div>

        <ReportModal
      :jornada="jornada"
      :report="report"
      :getPdf="getPdf"
    ></ReportModal>

    <CarrerasModal
      :fetchSubasta="fetchCarrera"
      :statusJornada="statusJornada"
      :jornada="jornada"
      :fetchJornadas="fetchJornada"
    ></CarrerasModal>

    <NotificationsModal></NotificationsModal>

    
  </div>
</template>

<script>
import { mapState } from "vuex";
import TablePolla from "./TablePolla.vue";
import CardPanelCarrera from "./CardPanelCarrera.vue";
import CreateNewPolla from "./CreateNewPolla.vue";
import TableUser from "./TableUser.vue";
import ReportModal from "../ReportModalPolla";
import CarrerasModal from "../CarrerasModal.vue";
import NotificationsModal from "../NotificationsModal.vue";

export default {
  middleware: "auth",
  components: {
    TablePolla,
    CardPanelCarrera,
    CreateNewPolla,
    TableUser,
    ReportModal,
    CarrerasModal,
    NotificationsModal,
  },
  data() {
    return {
      form:{
        pizarra: '',
        jornada_id: null,
        caballos: null,
        carrera_id: null,
      },
      ordenOficial: [
        {
          num: null,
          puntos: null
        }
      ],
      retirados: {
        viejo: null,
        nuevo: null
      },
      report: false,
      statusJornada: [
        {
          id: 1,
          name: "Activa",
        },
        {
          id: 2,
          name: "Cerrada",
        },
      ],
      carreraActiva: {
        carrera: 1,
      },
    };
  },
  computed: {
    ...mapState({
      jornada: (state) => state.jornadas.jornada,
      loading: (state) => state.pollas.loading,
      polla: (state) => state.pollas.polla,
      ponles: (state) => state.ponles.ponles,
      usersList: (state) => state.users.users,
    }),
  },
  methods: {
    additemOrden() {
      this.ordenOficial.push({
          num: null,
          puntos: null
        });
    },
    async premiarPolla() {
      let me = this;
      this.form.jornada_id = this.$route.params.id; // jornada_id
      const data = await this.$store.dispatch("pollas/storePremio", this.form);
      if (data) {
        me.$toastr.success("La petición fué hecha correctamente", "Guardado");
        this.fetchCarrera();
      }
    },
    async update() {
      let pizarra = '';
      this.ordenOficial.map((items, index) => {
        pizarra+= this.ordenOficial.length != index+1 ? items.num +'-': '';
      });

      this.polla.carrera.map((carrera, index) => {
      let ejemplar = carrera.ejemplar.toString();
      if (this.retirados.viejo > 0 && ejemplar == this.retirados.viejo){
        carrera.ejemplar = this.retirados.nuevo;
        ejemplar = carrera.ejemplar;
      }
      const value = this.ordenOficial.filter((row) => row.num == ejemplar).shift();
        if (value) {
          carrera.puntos = value.puntos;
        }else {
          carrera.puntos = 0;
        }
      });

      let me = this;
      this.form.jornada_id = this.$route.params.id; // jornada_id
      this.form.caballos = this.polla.carrera;
      this.form.carrera_id = this.carreraActiva.carrera
      this.form.pizarra = pizarra;

      const data = await this.$store.dispatch("pollas/store", this.form);
      if (data) {
        me.$toastr.success("La petición fué hecha correctamente", "Guardado");
        this.fetchCarrera();
      }
    },
    getPdf(value) {
      this.report = value;
    },
    async fetchJornadas(typeJornada, status, limit = 10, offset = 0) {
      await this.$store.dispatch("jornadas/fetch", {
        params: { typeJornada: typeJornada, status: status, limit, offset },
      });
    },
    selectCarrera(value) {
      this.carreraActiva.carrera = value.carrera;
      this.fetchCarrera();
    },
    async fetchJornada() {
      await this.$store.dispatch("jornadas/search", {
        params: { id: this.$route.params.id },
      });
    },
    async fetchCarrera() {
      await this.$store.dispatch("pollas/fetch", {
        params: {
          jornada_id: this.$route.params.id,
          carrera_id: this.carreraActiva.carrera,
        },
      });
      this.fetchUsersPuntos();
    },
    async fetchPonle(limit = 10, offset = 0) {
      await this.$store.dispatch("ponles/fetch", {
        params: { limit, offset },
      });
    },
    async fetchUsers() {
      await this.$store.dispatch("users/search", { params: { all: 1 } });
    },
    async fetchUsersPuntos() {
      await this.$store.dispatch("users/puntosPolla", { params: { jornada_id: this.$route.params.id, } });
    },
  },
  mounted() {
    this.fetchJornada();
    this.fetchCarrera();
    this.fetchPonle();
    this.fetchUsers();
  },
};
</script>

<style scoped>
.play-table {
  height: 600px!important;
  width: 100% !important;
  overflow: auto;
}
.users-table {
  height: 300px!important;
  width: 100% !important;
  overflow: auto;
}
</style>
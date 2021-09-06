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
            <div class="col-xs-12 col-md-8">
              <TableSubasta :fetchSubasta="fetchSubasta"> </TableSubasta>
            </div>
            <div class="col-xs-12 col-md-4">
              <CardPanelCarrera
                :subasta="subasta"
                :jornada="jornada"
              ></CardPanelCarrera>
            </div>
          </div>
        </div>

        <div class="col-xs-12 col-md-4">
          <TableUser :subasta="subasta"></TableUser>
          <!-- card.// -->
        </div>
      </div>
    </div>

    <CarrerasModal
      :fetchSubasta="fetchSubasta"
      :statusJornada="statusJornada"
      :jornada="jornada"
      :fetchJornadas="fetchJornadas"
    ></CarrerasModal>
    <SubastaModal
      :usersList="usersList"
      :tabPonles="ponles"
      :subasta="subasta"
      :carreraActiva="carreraActiva"
      :fetchSubasta="fetchSubasta"
    >
    </SubastaModal>

    <ReportModal
      :jornada="jornada"
      :report="report"
      :getPdf="getPdf"
    ></ReportModal>

    <NotificationsModal>
    </NotificationsModal>

    
  </div>
</template>

<script>
import { mapState } from "vuex";
import CarrerasModal from "./CarrerasModal.vue";
import TableSubasta from "./components/TableSubasta.vue";
import SubastaModal from "./SubastaModal.vue";
import CardPanelCarrera from "./components/CardPanelCarrera.vue";
import TableUser from "./components/TableUser.vue";
import ReportModal from "./ReportModal";
import NotificationsModal from "./NotificationsModal.vue";

export default {
  middleware: "auth",
  components: {
    CarrerasModal,
    TableSubasta,
    SubastaModal,
    CardPanelCarrera,
    TableUser,
    ReportModal,
    NotificationsModal
  },
  data() {
    return {
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
      loading: (state) => state.subastas.loading,
      subasta: (state) => state.subastas.subasta,
      ponles: (state) => state.ponles.ponles,
      usersList: (state) => state.users.users,
    }),
  },
  methods: {
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
      this.fetchSubasta();
    },
    format_date(value) {
      if (value) return moment(String(value)).format("DD-MM-YYYY");
    },
    async fetchJornada() {
      await this.$store.dispatch("jornadas/search", {
        params: { id: this.$route.params.id },
      });
    },
    async fetchSubasta() {
      await this.$store.dispatch("subastas/fetch", {
        params: {
          jornada_id: this.$route.params.id,
          carrera_id: this.carreraActiva.carrera,
        },
      });
    },
    async fetchPonle(limit = 10, offset = 0) {
      await this.$store.dispatch("ponles/fetch", {
        params: { limit, offset },
      });
    },
    async fetchUsers() {
      await this.$store.dispatch("users/search", { params: { all: 1 } });
    },
  },
  mounted() {
    this.fetchJornada();
    this.fetchSubasta();
    this.fetchPonle();
    this.fetchUsers();
  },
};
</script>
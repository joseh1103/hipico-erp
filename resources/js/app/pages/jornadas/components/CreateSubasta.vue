<template>
  <!-- inpud addon -->
  <div class="card card-orange mt-3" v-if="subasta.data">
    <div class="card-body">
      <div class="col-md-11 col-xs-12 mb-2 text-center" v-if="subasta.data">

         <toggle-button v-model="subasta.data.status_cierre" />
         <label for="cerrar_tabla"> Cerrar Subasta</label>
      </div>

      <div
        class="form-row"
        v-for="formsubasta in subasta.carrera"
        :key="formsubasta.id"
      >
        <div class="form-group col-md-1 col-xs-6">
          <label for="Nro" v-if="formsubasta.id <= 1">Nro</label>
          <input
            :disabled="
              !formsubasta.status_retired || !subasta.data.status_cierre
            "
            data-vv-validate-on="blur"
            v-validate="'required'"
            type="text"
            v-model="formsubasta.ejemplar"
            placeholder="Nro"
            class="form-control no-border-radius"
            name="Nro"
          />
        </div>

        <div class="form-group col-md-3 col-xs-6">
          <label for="Nro" v-if="formsubasta.id <= 1">Ejemplar</label>
          <input
            :disabled="
              !formsubasta.status_retired || !subasta.data.status_cierre
            "
            data-vv-validate-on="blur"
            v-validate="'required'"
            type="text"
            v-model="formsubasta.name_ejemplar"
            placeholder="Ejemplar"
            class="form-control no-border-radius"
            name="Ejemplar"
          />
        </div>

        <div class="form-group col-md-3 col-xs-6">
          <label for="Apostador" v-if="formsubasta.id <= 1">Apostador</label>
          <SearchUsers
            :disabledComponen="
              !formsubasta.status_retired || !subasta.data.status_cierre
            "
            :id_update="formsubasta.ejemplar"
            :usersList="usersList"
            :selectedUser="selectedUser"
            :userModel="formsubasta.apostador"
          >
          </SearchUsers>
        </div>

        <div class="form-group col-md-2 col-xs-6">
          <label for="Monto" v-if="formsubasta.id <= 1">Monto</label>
          <v-select
            :disabled="
              !formsubasta.status_retired || !subasta.data.status_cierre
            "
            v-model="formsubasta.monto"
            :options="ponles"
          ></v-select>
        </div>
        <div class="form-group col-auto mt-2">
          <toggle-button
            :disabled="!subasta.data.status_cierre"
            v-model="formsubasta.status_retired"
          />
          <label for="Retirado"> Retirado</label>
        </div>

        <div
          class="form-group col-auto mt-2"
          v-show="!subasta.data.status_cierre"
        >
          <toggle-button v-model="formsubasta.winner" />
          <label for="Ganador"> Ganador</label>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-center">
      <button type="button" class="btn btn-success" @click="addEjemplar()" v-if="subasta.data.status_cierre">
        <i class="white fas fa-plus-square"></i>
      </button>

      <div class="form-group col-md-6 col-xs-6" v-if="!subasta.data.status_cierre">
          <label for="Pizarra">Pizarra</label>
          <input
            data-vv-validate-on="blur"
            v-validate="'required'"
            type="text"
            placeholder="Orden de LLegada"
            class="form-control no-border-radius"
            name="Pizarra"
             v-model="subasta.data.pizarra"
          />
        </div>
      
       <div class="form-group col-md-6 col-xs-6" v-if="!subasta.data.status_cierre">
          <label for="Pizarra">Dividendo</label>
          <input
            data-vv-validate-on="blur"
            v-validate="'required'"
            type="text"
            placeholder="Orden de LLegada"
            class="form-control no-border-radius"
            name="Pizarra"
             v-model="subasta.data.winning"
          />
        </div>


    </div>

    <div class="d-flex justify-content-end">
      <button
        style="margin: 10px !important"
        type="button"
        @click.prevent="saveCarreras"
        class="btn bg-orange text-light btn-save"
        data-dismiss="modal"
        aria-label="Close"
      >
        Guardar y Cerrar
      </button>
    </div>
  </div>
  <!-- /.card-body -->
  <!-- /.card -->
</template>

<style scoped>
.btn-save {
  border-radius: 2px !important;
  font-weight: bold;
}
</style>

<script>
import SearchUsers from "../../users/SearchUsers.vue";
export default {
  components: {
    SearchUsers,
  },
  props: {
    subasta: Object,
    carreraActiva: Object,
    fetchSubasta: Function,
    tabPonles: Object,
    usersList: Object,
  },
  data() {
    return {
      options: {
        format: "YYYY-MM-DD",
        useCurrent: false,
      },
      ponles: [],
    };
  },
  watch: {
    tabPonles: function (val) {
      const ponlesArray = [];
      val.data.map((item, index) => {
        var ini_monto = parseInt(item.ini_monto);
        var end_monto = parseInt(item.end_monto);
        var value = parseInt(item.value);
        var i = ini_monto;
        while (i < end_monto) {
          i = i + value;
          ponlesArray.push(i);
        }
        return ponlesArray; //equivalent to list[index]
      });
      this.ponles = ponlesArray.sort(function (a, b) {
        return a - b;
      });
    },
  },
  methods: {
    selectedUser(item, id_update) {
      const value = this.subasta.carrera
        .filter((row) => row.ejemplar == id_update)
        .shift();
      value.apostador = item;
    },
    addEjemplar() {
      this.subasta.carrera.push({
        ejemplar: this.subasta.carrera.length + 1,
        apostador: {
          id: 1,
          user: "casa",
        },
        status_retired: true, //
        winner: false,
      });
    },
    async saveCarreras() {
      let me = this;
      this.subasta.id = this.$route.params.id; // jornada_id
      this.subasta.n_carrera = this.carreraActiva.carrera;
      const data = await this.$store.dispatch("subastas/store", this.subasta);
      if (data) {
        me.$toastr.success("La petición fué hecha correctamente", "Guardado");
        this.fetchSubasta();
      }
    },
  },
};
</script>
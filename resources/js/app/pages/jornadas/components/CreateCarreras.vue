<template>
  <!-- inpud addon -->
  <div class="card card-orange mt-3">
    <div class="card-body">

      <div class="form-row" v-for="carrera in jornada.carreras" :key="carrera.id">
          <div class="form-group col-md-1 col-xs-6">
            <label for="Nro-Carrera" v-if="carrera.carrera <= 1">Carrera</label>
             <input
                data-vv-validate-on="blur"
                v-validate="'required'"
                type="text"
                v-model="carrera.carrera"
                placeholder="Carrera"
                class="form-control no-border-radius"
                name="Carrera"
              />
          </div>

          <div class="form-group col-md-2 col-xs-6">
            <label for="Nro-Distancia" v-if="carrera.carrera <= 1">Distancia</label>
            <input
              data-vv-validate-on="blur"
              v-validate="'required'"
              type="text"
              v-model="carrera.distance"
              placeholder="Distancia"
              class="form-control no-border-radius"
              name="Distancia"
            />
          </div>

          <div class="form-group col-md-2 col-xs-6">
             <label for="Hora" v-if="carrera.carrera <= 1">Hora</label>
             <date-picker v-model="carrera.hour" 
             :config="options"></date-picker>
          </div>

           <div class="form-group col-md-2 col-xs-6">
             <label for="Incentivo" v-if="carrera.carrera<= 1">Incentivo</label>
            <input
              data-vv-validate-on="blur"
              v-validate="'required'"
              type="text"
              v-model="carrera.incentive"
              placeholder="Incentivo"
              class="form-control no-border-radius"
              name="Incentivo"
            />
          </div>

          <div class="form-group col-md-3 col-xs-6">
            <label for="Detalle" v-if="carrera.carrera <= 1">Detalle</label>
            <input
              data-vv-validate-on="blur"
              v-validate="'required'"
              type="text"
              v-model="carrera.detail"
              placeholder="Detalle"
              class="form-control no-border-radius"
              name="Detalle"
            />
          </div>

          <div class="form-group col-md-1 col-xs-6 mt-4">
            <toggle-button
              v-model="carrera.status_cierre"
            />
            <label for="Status"> Status</label>
          </div>

          <div class="form-group col-md-1 col-xs-6 mt-4">
            <toggle-button
              v-model="carrera.status_movil"
            />
            <label for="Visible"> Visible</label>
          </div>
      </div>

       <div class="d-flex justify-content-center">
        <button
          type="button"
          class="btn btn-success"
          @click="addCarrera()"
        >
           <i class="white fas fa-plus-square"></i>
        </button>

       </div>







      <div class="d-flex justify-content-end">
        <button
        style="margin:10px !important;"
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
  </div>
  <!-- /.card -->
</template>

<style scoped>
.btn-save {
  border-radius: 2px !important;
  font-weight: bold;
}
</style>

<script>
export default {
  props: {
    fetchJornadas: Function,
    fetchSubasta: Function,
    statusJornada: Array,
    jornada: Object
  },
  data() {
    return {
      options: {
        format: 'HH:mm:ss',
        useCurrent: true,
        showClear: true,
        showClose: true
      },
    };
  },
  //jornada.carreras
  watch: {
    jornada() {
      this.jornada.carreras.map((items) => {
        items.status_cierre = items.status_cierre == 1 ? true : false;
        items.status_movil = items.status_movil == 1 ? true : false;
        return items;
      });

    },
  },
  methods: {
    addCarrera () {
      this.jornada.carreras.push({
        carrera: this.jornada.carreras.length +1,
        incentive: 0,
        status_cierre: true,
        status_movil: false,
      });
    },
    async saveCarreras() {
      let me = this;
      const data = await this.$store.dispatch("carreras/store", this.jornada);
      if (data) {
        me.$toastr.success("La petición fué hecha correctamente", "Guardado");
        this.fetchJornadas();
        this.fetchSubasta();
      }
    }   
    
  }
};
</script>
<template>
  <!-- inpud addon -->
  <div class="card card-orange mt-3">
    <div class="card-body">


      <div class="mb-3" v-show="form.id > 0 " >
        <label for="formFile" class="form-label">Retrospecto :</label>
        <input
          data-vv-validate-on="blur"
          v-validate="'required'"
          type="text"
          v-model="form.url_retrospecto"
          placeholder="url-retrospecto"
          class="form-control no-border-radius"
          name="url"
        />
      </div>

      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-user"></i></span>
        </div>
        <input
          data-vv-validate-on="blur"
          v-validate="'required'"
          type="text"
          v-model="form.name"
          placeholder="Nombre"
          class="form-control no-border-radius"
          name="Nombre"
        />
      </div>
      <span class="text-danger text-sm">{{ errors.first('Nombre') }}</span>

    <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">-$ </span>
            </div>
            <input
              type="text"
              v-model="form.commission"
              placeholder="Comisión"
              class="form-control no-border-radius"
            />
            <div class="input-group-append">
              <span class="input-group-text no-border-radius">.00</span>
            </div>
          </div>


       <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
        </div>
         <date-picker v-model="form.date" :config="options"></date-picker>
      </div>

      
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"
            ><i class="fas fa-sort"></i></span>
        </div>
        <select class="form-control" v-model="form.typeJornada" required>
          <option disabled value="">- Tipo de Jornada -</option>
          <option
            v-for="type in typeJornada"
            :key="type.id"
            :value="type.id"
          >
            {{ type.name }}
          </option>
        </select>
      </div> 

          <div class="input-group mb-3" v-if="form.typeJornada == 4">
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
          <span class="input-group-text"><i class="fas fa-youtube"></i>
          </span>
        </div>
        <input
         type="text"
          v-model="form.youtube_id"
          placeholder="Id Youtube"
          class="form-control no-border-radius"
          name="youtube"
        />
      </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"
            ><i class="fas fa-sort"></i></span>
        </div>
        <select class="form-control" v-model="form.currency_id" required>
          <option disabled value="">- Selecione Moneda -</option>
          <option
            v-for="currency in currency.data"
            :key="currency.id"
            :value="currency.id"
          >
            {{ currency.name }}
          </option>
        </select>
      </div>

      

        
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"
            ><i class="fas fa-sort"></i></span>
        </div>
        <select class="form-control" v-model="form.status" required>
          <option value="" selected disabled>- Selecione Status -</option>
          <option
            v-for="status in statusJornada"
            :key="status.id"
            :value="status.id"
          >
            {{ status.name }}
          </option>
        </select>
      </div> 

      <div class="input-group mb-3" v-if="form.clone">
        <div class="input-group-prepend">
          <span class="input-group-text"
            ><i class="fas fa-sort"></i></span>
             <v-select v-model="form.carreras"
             label="carrera" class="style-search-carreras"
             placeholder="Selecione carreras a clonar"
             multiple :options="form.carreras" />
        </div>
         
      </div> 

  
        <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" v-model="form.movil" id="flexSwitchCheckDefault">
              <label>Visible en Movil</label> 
        </div>
      


      <div class="d-flex justify-content-end">
        <button
        style="margin:10px !important;"
          type="button"
          @click.prevent="saveUser" :disabled="!validateForm"
          class="btn bg-orange text-light btn-save"
        >
          Guardar y Nuevo
        </button>
        <button
        style="margin:10px !important;"
          type="button"
          @click.prevent="saveUser" :disabled="!validateForm"
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
import { mapState } from "vuex";
export default {
  props: {
    editedItem: Object,
    fetchJornadas: Function,
    statusJornada: Array,
    typeJornada: Array
  },
  data() {
    return {
      options: {
        format: 'YYYY-MM-DD',
        useCurrent: true,
        showClear: true,
        showClose: true,
      },
      form: {
        id: null,
        date: new Date(),
        name: '',
        hipodromo_id: null,
        commission: 0,
        status: 1,
        typeJornada: 1,
        movil: false,
        clone: 0,
        carreras: [],
        currency_id: 1,
        youtube_id: '',
        url_retrospecto: null,
        monto: 0
      },
      url: null
    };
  },
  computed: {
  ...mapState({
      hipodromos:  state => state.hipodromos.hipodromos,
      currency: state => state.currency.currency
    }),
  validateForm () {
  return !this.errors.any() && this.form.name !== '' && this.form.hipodromo_id !== '' && this.form.commission !== '' 
  &&  this.form.date !== ''
  }
  },
  watch: {
    editedItem (obj) {
      const form = this.form;
      Object.keys(this.form).forEach(function (item) {
          form[item] = obj[item];
      });
    }
  },
  methods: {

    resertFormUsers() {
      this.form = {
        id: null,
        date: new Date(),
        name: '',
        hipodromo_id: null,
        commission: 0,
        status: 1,
        typeJornada: 1,
        movil: false,
        clone: 0,
        id_jornada: null,
        currency_id: 1,
        youtube_id: null,
        image: null
      }
    },
    
    async saveUser() {
      let me = this;
      this.form.id_jornada = this.form.clone == 1 ? this.form.id : null;
      this.form.id = !this.form.clone ? this.form.id : null;
      const data = await this.$store.dispatch("jornadas/store", this.form);
      if (data) {
        this.resertFormUsers();
        me.$toastr.success("La petición fué hecha correctamente", "Guardado");
        this.fetchJornadas();
      }
    }   
    
  }
};
</script>
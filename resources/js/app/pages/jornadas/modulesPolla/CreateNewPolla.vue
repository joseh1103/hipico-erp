<template>
  <div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="newPollaModal"
      tabindex="-1"
      aria-labelledby="userModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-orange">
              
            <h5 class="modal-title text-light" id="userModalLabel">Nueva Combinacion</h5>
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
            
            <div class="form-group col-md-3 col-xs-12">
                <label for="Apostador">Apostador</label>


                 <v-select label="user" 
                    class="style-search"
                    placeholder="Seleccionar Usuario"
                    v-model="form.apostador"
                    :options="usersList.data">
                        <template slot="no-options">
                            Buscar Usuario 
                        </template>
                    </v-select>

            </div>

            <div class="form-row" v-for="carrera in form.caballos" :key="carrera.id">
                <div class="form-group col-md-2 col-xs-2">
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

                <div class="form-group col-md-8 col-xs-6">
                    <label for="Incentivo" v-if="carrera.carrera<= 1">Ejemplar</label>
                    <input
                    data-vv-validate-on="blur"
                    v-validate="'required'"
                    type="text"
                    v-model="carrera.ejemplar"
                    placeholder="Ejemplar"
                    class="form-control no-border-radius"
                    name="Incentivo"
                    />
                </div>
                <div class="form-group col-md-2 col-xs-4">
                    <label for="Nro-Puntos" v-if="carrera.carrera <= 1">Puntos</label>
                    <input
                        data-vv-validate-on="blur"
                        v-validate="'required'"
                        type="text"
                        v-model="carrera.puntos"
                        placeholder="Pts"
                        class="form-control no-border-radius"
                        name="Pts"
                    />
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button
                style="margin:10px !important;"
                type="button"
                @click.prevent="store"
                class="btn bg-orange text-light btn-save"
                >
                Guardar y Nuevo
                </button>
                <button
                style="margin:10px !important;"
                type="button"
                @click.prevent="store"
                class="btn bg-orange text-light btn-save"
                data-dismiss="modal"
                aria-label="Close"
                >
                Guardar y Cerrar
                </button>
            </div>



          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import { mapState } from "vuex";
import SearchUsers from "../../users/SearchUsers.vue";
export default {
  components: {
    SearchUsers
  },
  props: {
    jornada: Object,
    fetchCarrera: Function
  },
  data() {
    return {
        form: {
          jornada_id: null,
          apostador: null,
          caballos: [],
        }
    };
  },
   watch: {
    'jornada': function (val) {
      this.jornada.carreras.map((items, index) => {
        this.form.caballos.push({
          id: null,
          carrera: items.carrera,
          puntos: 0,
          ejemplar: null,
        });
      });

    },
  },
   computed: {
    ...mapState({
      usersList: (state) => state.users.users,
    }),
  },
  methods: {
    async store() {
      let me = this;
      this.form.jornada_id = this.$route.params.id; // jornada_id
      const data = await this.$store.dispatch("pollas/store", this.form);
      if (data) {
        me.$toastr.success("La petición fué hecha correctamente", "Guardado");
        this.fetchCarrera();
      }
    },
    async fetchUsers() {
      await this.$store.dispatch("users/search", { params: { all: 1 } });
    },
  }
};
</script>

<style>
  .style-search .vs__search::placeholder,
  .style-search .vs__dropdown-toggle,
  .style-search .vs__dropdown-menu {
    background: #FFFFFF;
    color: #EB7D25;
  }

  .style-search .vs__clear,
  .style-search .vs__open-indicator {
    fill: #EB7D25;
  }
  .style-search {
    width: 300px !important;
  }

  .vs__search, .vs__search:focus {
    line-height: 2.0 !important;
}
</style>

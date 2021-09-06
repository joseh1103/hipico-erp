<template>
  <div class="card mt-3">

    <div class="card-header">
      <h3 class="card-title">Jornadas</h3>
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


    <div class="table-responsive pt-5">
      <vue-bootstrap4-table
        :rows="jornadas.data ? jornadas.data : []"
        :columns="columns"
        :config="config"
        @on-change-query="onChangeQuery"
        :show-loader="loading"
        :totalRows="jornadas.total">
      <template slot="empty-results">
        No hay usuario registrados
      </template>

       <template slot="name-slot" slot-scope="props">
         <strong> {{ props.row.name }} </strong> | {{ props.row.typeJornada }}
       </template>
      

       <template slot="status-carrera-slot" slot-scope="props">
         <label class="badge p-2 badge-warning"> {{ carrerasOpen(props.row.carreras) }} </label>
       </template>
 

       <template slot="status-slot" slot-scope="props">
         <span class="badge p-2" :class="props.row.status == 1 ? 'badge-success' : 'badge-danger'">{{ props.row.status == 1 ? 'Abierta' : 'Cerrada' }}</span>
       </template>

       <template slot="movil-slot" slot-scope="props">
         <span class="badge p-2" :class="props.row.movil == 1 ? 'badge-success' : 'badge-danger'">{{ props.row.movil == 1 ? 'Si' : 'No' }}</span>
       </template>


      <template slot="action-slot" slot-scope="props">
         <button class="icon-acciones" @click="editItem(props.row, 1)">
                <i 
                  class="fa fa-clone color-icon-p"
                   data-toggle="modal"
                   data-target="#userModal"
                ></i>
        </button>

         <button class="icon-acciones" @click="$router.push(props.row.typeJornada ==1 ? `/jornada-detail/${props.row.id}` : props.row.typeJornada == 4 ? `/polla-detail/${props.row.id}` :`/tercio-detail/${props.row.id}`).catch(() => {})">
                <i 
                  class="fas fa-eye color-icon-d"
                  data-toggle="modal"
                  data-target="#userModalInfo"
                ></i>
        </button>
         <button class="icon-acciones" @click="editItem(props.row, 0)">
                <i
                  class="fas fa-edit color-icon-e"
                  data-toggle="modal"
                  data-target="#userModal"
                ></i>
              </button>
              <button class="icon-acciones" @click="deleteItem(props.row)">
                <i class="fa fa-trash color-icon-t"></i>
              </button>

    </template>
    
      </vue-bootstrap4-table>
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
    fetchJornadas: Function,
    typeJornada: Array,
    statusJornada: Array,
    jornada_id: Array
  },
  components: {
    VueBootstrap4Table,
  },
  data() {
    return {
      columns: [
        {
          label: "ID",
          name: "id",
        },
        {
          label: "Nombre",
          name: "name",
          slot_name: "name-slot"
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
        loaderText: 'Cargando...',
      },
      queryParams: {
        global_search: "",
        per_page: 10,
        page: 1,
      },
      status: 0,
      type_jornada: 0
    };
  },
  computed: {
     ...mapState({
    jornadas: state => state.jornadas.jornadas,
    loading: state => state.jornadas.loading
  }),
  },
  watch: {
    'status': function (val) {
      this.refreshTable();
    },
    'type_jornada': function (val) {
      this.refreshTable();
    },
  },
  methods: {
    carrerasOpen(carreras) {
      let carreras_abiertas = 0;
      var carreras_cerradas = 0;
      carreras.map((items) => {  
        if (items.status_cierre == 1) {
          carreras_abiertas += 1;
        }else {
          carreras_cerradas +=1;
        }
        return items;
      });
      return `${carreras_abiertas} / ${carreras_cerradas}`

    },
    searchJornada(value) {
      return value //this.typeJornada.find(item => item.id === value).name;
    },
    editItem(item, clone) {
      var data = item;
      data.clone = clone;
      this.changeform(data);
    },
    onChangeQuery(queryParams) {
      this.queryParams = queryParams;
      this.refreshTable();
    },
    async refreshTable () {
      await this.fetchJornadas(this.type_jornada,this.status, this.queryParams.per_page, this.queryParams.page === 1 ? 0 : this.queryParams.per_page * (this.queryParams.page - 1))
    },
    
    async deleteItem(item) {
      let me = this;
      const index = this.jornadas.data.indexOf(item);
      if (
        confirm("Esta seguro que desea eliminar?") &&
        this.jornadas.data.splice(index, 1)
      ) {
        const data = await this.$store.dispatch("jornadas/delete", item);
        if (data) {
          me.$toastr.success(
            "La petición fué hecha correctamente",
            "Eliminado"
          );
          this.refreshTable();
        }
      }
    },
  }
};
</script>
<style>
  .style-search-jornada .vs__search::placeholder,
  .style-search-jornada .vs__dropdown-toggle,
  .style-search-jornada .vs__dropdown-menu {
    background: #FFFFFF;
    color: #EB7D25;
  }

  .style-search-jornada .vs__clear,
  .style-search-jornada .vs__open-indicator {
    fill: #EB7D25;
  }
  .style-search-jornada {
    width: 100% !important;
    min-width: 150px;
  }

  .vs__search, .vs__search:focus {
    line-height: 2.0 !important;
}
</style>

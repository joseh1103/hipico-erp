<template>
  <div class="card mt-3">

    <div class="card-header">
       <div>
       <label> Detalle del Usuario: {{ balance.user ? balance.user.user :'...' }}</label>
        <label> Saldo : {{ balance.user ? formatNumber(balance.user.posed_available) :'...' }} </label>
       </div>

      <label class="text-warning"> Saldo Diferido: {{ balance.unloack }}</label>
    

      <div class="card-tools">

        <div class="form-row">
          <div class="form-group col-md-12">
             <v-select class="style-search-jornada"
             label="name"
             placeholder="Selecione Jornada"
             multiple v-model="jornada_id" :options="jornadas.data" />
          </div>
        </div>



      </div>
    </div>

    <div class="table-responsive p-4">
      <vue-bootstrap4-table :classes="classes" 
        :rows="balance.data ? balance.data : []"
        :columns="columns"
        :config="config"
        @on-change-query="onChangeQuery"
        :show-loader="loading"
        :totalRows="balance.total">
      <template slot="empty-results">
        No hay usuario registrados
      </template>

      

      <template slot="available-slot" slot-scope="props">
         {{ formatNumber(props.row.monto) }}
      </template>
      <template slot="format-slot" slot-scope="props">
         {{ format_date(props.row.created_at) }}
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
import { numberFormat } from '../../../plugins/util'
export default {
  props: {
    changeform: Function,
    fetchDetail: Function
  },
  components: {
    VueBootstrap4Table,
  },
  data() {
    return {
      jornada_id: [],
      jornada_id_filter: [],
      columns: [
        {
          label: "ID",
          name: "id",
        },
        {
          label: "Tipo Operacion",
          name: "operations",
        },
        {
          label: "Detalle",
          name: "description",
        },
        {
          label: "Fecha",
          name: "created_at",
          slot_name: "format-slot",
        },
        {
          label: "Monto",
          name: "monto",
          slot_name: "available-slot",
        }
      ],
      classes: {
        tableWrapper: "outer-table-div-class wrapper-class-two",
        table: {
          "table-striped": true,
          "table-bordered": function (rows) {
            return false;
          }
        },
        cell: {
          "my-cell my-cell2": true,
          "text-danger": function (row, column, cellValue) {
            return (row.operations == 'jugada' || row.operations == 'retiro')
          },
          "text-success": function (row, column, cellValue) {
            return (row.operations == 'premio' || row.operations == 'posos')
          },
         "font-weight-bold": function (row, column, cellValue) {
            return row.id > 0
          },
        },
      },
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
      }
    };
  },
  computed: {
     ...mapState({
    balance: state => state.users.balance,
    loading: state => state.users.loading,

    jornadas: state => state.jornadas.jornadas,
    loadingJornadas: state => state.jornadas.loading
  }),
  },
  watch: {
    jornada_id (value) {
      const array_id_jornada = [];
      value.map((items, index) => {
        array_id_jornada.push(items.id);
      });
      this.jornada_id_filter = array_id_jornada;
      this.refreshTable();
    }
  },
  methods: {
    format_date(value) {
      if (value) return moment(String(value)).format("DD-MM-YYYY");
    },
    formatNumber(item) {
      const signo = item && item.charAt(0) == '-' ? '-' : '';
      const value = numberFormat(item);
      return `${signo}${value}`;
    },
    editItem(item) {
      var data = item;
      this.changeform(data);
    },
    onChangeQuery(queryParams) {
      this.queryParams = queryParams;
      this.refreshTable();
    },
    async refreshTable () {
      await this.fetchDetail(this.jornada_id_filter,this.queryParams.per_page, this.queryParams.page === 1 ? 0 : this.queryParams.per_page * (this.queryParams.page - 1))
    }

    // /show
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
    min-width: 450px;
  }

  .vs__search, .vs__search:focus {
    line-height: 2.0 !important;
}
</style>

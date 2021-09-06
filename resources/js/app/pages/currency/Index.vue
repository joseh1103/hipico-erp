<template>
  <div class="card mt-3">
    <div class="card-header">
      <h3 class="card-title">Monedas Disponibles</h3>
    </div>
    <div class="table-responsive pt-4">
      <vue-bootstrap4-table
        :rows="currency.data ? currency.data : []"
        :columns="columns"
        :config="config"
        @on-change-query="onChangeQuery"
        :show-loader="loading"
        :totalRows="currency.total">
      <template slot="empty-results">
        No hay monedas registrados
      </template>

      <template slot="action-slot" slot-scope="props">
         <button class="icon-acciones" @click="editItem(props.row)">
                <i
                  class="fas fa-edit color-icon-e"
                  data-toggle="modal"
                  data-target="#productModal"
                ></i>
              </button>
              <button class="icon-acciones" @click="deleteItem(props.row)">
                <i class="fa fa-trash color-icon-t"></i>
              </button>

    </template>


    <template slot="ini-monto-slot" slot-scope="props">
         {{ formatNumber(props.row.ini_monto) }}
    </template>

    <template slot="end-monto-slot" slot-scope="props">
         {{ formatNumber(props.row.end_monto) }}
    </template>

    <template slot="value-slot" slot-scope="props">
         {{ formatNumber(props.row.value) }}
    </template>
    
    
      </vue-bootstrap4-table>
    </div>
  <!-- .card-body -->
  </div>
  <!-- /.card -->
</template>

<script>
import { numberFormat } from '../../plugins/util'
import { mapState } from "vuex";
import VueBootstrap4Table from "vue-bootstrap4-table";
export default {
  props: {
    changeform: Function,
    fetchData: Function,
    status: Array
  },
  components: {
    VueBootstrap4Table,
  },
  data() {
    return {
      type: 1,
      columns: [
        {
          label: "Nombre",
          name: "name",
        },
        {
          label: "Simbolo",
          name: "symbol",
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
          placeholder: "Buscar Moneda",
          visibility: false,
          case_sensitive: false,
          showClearButton: false,
          searchOnPressEnter: false,
        },
        server_mode: true,
        pagination: true, // default true
        pagination_info: false, // default true
        num_of_visibile_pagination_buttons: 10,
        per_page_options: [5, 10, 20, 30],
        show_refresh_button: false,
        show_reset_button: false,
        preservePageOnDataChange: true,
        loaderText: 'Cargando...',
      },
      queryParams: {
        global_search: "",
        per_page: 10,
        page: 1
      }
    };
  },
  computed: {
      ...mapState({
    currency: state => state.currency.currency,
    loading: state => state.currency.loading
  }),
  },
   watch: {
    'type': function (val) {
      this.refreshTable();
    },
  },
  methods: {
    formatNumber(item) {
      return numberFormat(item);
    },
    filterStatus(item) {
      const value = this.status.filter(student => student.id >= item);
      return value.shift();
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
      await this.fetchData(this.type,this.queryParams.global_search ,this.queryParams.per_page, this.queryParams.page === 1 ? 0 : this.queryParams.per_page * (this.queryParams.page - 1))
    },
    
    async deleteItem(item) {
      let me = this;
      const index = this.currency.data.indexOf(item);
      if (
        confirm("Esta seguro que desea eliminar?") &&
        this.currency.data.splice(index, 1)
      ) {
        const data = await this.$store.dispatch("currency/delete", item);
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
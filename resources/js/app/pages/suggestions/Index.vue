<template>
  <div class="card mt-3">
    <div class="card-header">
      <h3 class="card-title">Monedas Disponibles</h3>
    </div>
    <div class="table-responsive pt-4">
      <vue-bootstrap4-table
        :rows="suggestions.data ? suggestions.data : []"
        :columns="columns"
        :config="config"
        @on-change-query="onChangeQuery"
        :show-loader="loading"
        :totalRows="suggestions.total">
      <template slot="empty-results">
        No hay monedas registrados
      </template>

      <template slot="status-slot" slot-scope="props">
         <span class="badge p-2" :class="props.row.status == 1 ? 'badge-danger' : 'badge-success'">{{ props.row.status == 1 ? 'Abierto' : 'Solucionado' }}</span>
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
          label: "id",
          name: "id",
        },
        {
          label: "Asunto",
          name: "type",
        },
        {
          label: "Mensaje",
          name: "message",
        },
        {
          label: "ID usuario",
          name: "user_id",
        },
        {
          label: "Estatus",
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
          placeholder: "Buscar Sugerencia o Reclamo",
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
    suggestions: state => state.suggestions.suggestions,
    loading: state => state.suggestions.loading
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
      const index = this.suggestions.data.indexOf(item);
      if (
        confirm("Esta seguro que desea eliminar?") &&
        this.suggestions.data.splice(index, 1)
      ) {
        const data = await this.$store.dispatch("suggestions/delete", item);
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
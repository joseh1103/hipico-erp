<template>
 <div class="card mt-2">
  <div class="table-responsive table">
    <vue-bootstrap4-table class="p-2"
      :classes="classes" 
      :rows="polla.carrera ? polla.carrera : []"
      :columns="columns"
      :config="config"
      @on-change-query="onChangeQuery"
      :show-loader="loading"
    >
    

      <template slot="empty-results"> No hay Pollas </template>
    </vue-bootstrap4-table>
  </div>
 </div>
  <!-- /.card-body -->
</template>

<script>
import { mapState } from "vuex";
import VueBootstrap4Table from "vue-bootstrap4-table";
import { numberFormat } from '../../../plugins/util'

export default {
  props: {
    fetchCarrera: Function,
  },
  components: {
    VueBootstrap4Table,
  },
  data() {
    return {
      columns: [
        {
          label: "Apostador",
          name: "apostador.user",
        },
        {
          label: "Nro",
          name: "ejemplar",
        },
        {
          label: "Puntos",
          name: "puntos"
        },
      ],
      classes: {
        tableWrapper: "outer-table-div-class wrapper-class-two",
        table: {
          "table-striped": true,
          "table-bordered": function (rows) {
            return false;
          }
        },
        row: {
          "my-row my-row2": true,
          "bg-danger": function (row) {
           // return row.puntos == 0
          },
          "bg-success": function (row) {
            return row.puntos == 5
          },
        },
        cell: {
          "my-cell my-cell2": true,
          "text-white": function (row, column, cellValue) {
            return row.puntos == 5
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
        server_mode: false,
        pagination: false, // default true
        pagination_info: false, // default true
        num_of_visibile_pagination_buttons: 7,
        per_page_options: [5, 10, 20, 30],
        show_refresh_button: false,
        show_reset_button: false,
        preservePageOnDataChange: true,
        loaderText: "Cargando...",
      },
      queryParams: {
        global_search: "",
        per_page: 10,
        page: 1,
      },
      status: 0,
      type_jornada: 0,
    };
  },
  computed: {
    ...mapState({
      loading: (state) => state.pollas.loading,
      polla: (state) => state.pollas.polla,
    }),
  },
  methods: {
    format(monto) {
      return numberFormat(monto);
    },
    onChangeQuery(queryParams) {
      this.queryParams = queryParams;
      this.refreshTable();
    },
    async refreshTable() {
      await this.fetchCarrera();
    },
  },
};
</script>
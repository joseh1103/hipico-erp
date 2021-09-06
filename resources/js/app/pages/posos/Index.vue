<template>
  <div class="card mt-3">
    <div class="p-2 form-inline">
         <div class="form-group col-3">
           Desde:
            <date-picker :config="options" v-model="from"></date-picker>
         </div>

         <div class="form-group col-3">
           Hasta:
         <date-picker :config="options" v-model="to"></date-picker>
         </div>

        <div class="form-group col-3">
          <select class="form-control" v-model="payment_type">
            <option value="0">-Tipo Operacion-</option>
            <option
              v-for="operation in operations"
              :key="operation.id"
              :value="operation.id"
            >
              {{ operation.name }}
            </option>
          </select>
        </div>
        <div class="form-group col-3">
          <select class="form-control" v-model="status_authorization">
            <option
              v-for="status in statusPay"
              :key="status.id"
              :value="status.id"
            >
              {{ status.name }}
            </option>
          </select>
        </div>

         <div class="form-group m-2 col-3">
          <select class="form-control" v-model="code_bank">
            <option
              v-for="b in banck"
              :key="b.code"
              :value="b.code"
            >
              {{ b.name }}
            </option>
          </select>
        </div>
    </div>


    <div class="card-header">
      <h3 class="card-title mr-3">Solicitudes de Retiro o Poso</h3>

    </div>

    <div class="table-responsive pt-4">
      <vue-bootstrap4-table
        :classes="classes"
        :rows="posos.data ? posos.data : []"
        :columns="columns"
        :config="config"
        @on-change-query="onChangeQuery"
        :show-loader="loading"
        :totalRows="posos.total"
      >
        <template slot="empty-results"> No hay registrados </template>

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

        <template slot="end-monto-slot" slot-scope="props">
          {{ formatNumber(props.row.monto) }}
        </template>
        <template slot="status-slot" slot-scope="props">
          <strong
            class="badge p-2"
            :class="
              props.row.status_authorization == 1
                ? 'badge-success'
                : 'badge-danger'
            "
            >{{
              props.row.status_authorization == 1 ? "Aprobado" : "Pendiente"
            }}</strong
          >
        </template>

        <template slot="operacion-slot" slot-scope="props">
          <strong
            class="badge p-2"
            :class="
              props.row.payment_type == 1 ? 'badge-success' : 'badge-danger'
            "
            >{{
              props.row.payment_type == 1
                ? "Poso"
                : props.row.payment_type == 2
                ? "Retiro"
                : "Transferir Saldo"
            }}</strong
          >
        </template>
      </vue-bootstrap4-table>
    </div>
    <!-- .card-body -->
  </div>
  <!-- /.card -->
</template>

<script>
import { numberFormat } from "../../plugins/util";
import { mapState } from "vuex";
import VueBootstrap4Table from "vue-bootstrap4-table";
import { banck } from '../../plugins/util'
export default {
  props: {
    changeform: Function,
    fetchData: Function,
    statusPay: Array,
    operations: Array,
  },
  components: {
    VueBootstrap4Table,
  },
  data() {
    return {
      banck: banck,
      code_bank: null,
      from: null,
      to: null,
      options: {
        format: 'YYYY-MM-DD',
        useCurrent: true,
        showClear: true,
        showClose: true,
      },
      payment_type: null,
      status_authorization: null,
      columns: [
        {
          label: "Usuario",
          name: "user.user",
        },
        {
          label: "Monto",
          name: "monto",
          slot_name: "end-monto-slot",
        },
        {
          label: "Descripcion",
          name: "description",
        },
        {
          label: "Tipo Operacion",
          name: "payment_type",
          slot_name: "operacion-slot",
        },
        {
          label: "Status",
          name: "status_authorization",
          slot_name: "status-slot",
        },
        {
          label: "Actions",
          name: "id",
          slot_name: "action-slot",
        },
      ],
      classes: {
        tableWrapper: "outer-table-div-class wrapper-class-two",
        table: {
          "table-striped": true,
          "table-bordered": function (rows) {
            return false;
          },
        },
        cell: {
          "my-cell my-cell2": true,
          "text-danger": function (row, column, cellValue) {
            return row.payment_type == 2;
          },
          "text-success": function (row, column, cellValue) {
            return row.payment_type == 1;
          },
          "text-info": function (row, column, cellValue) {
            return row.payment_type == 3;
          },
          "font-weight-bold": function (row, column, cellValue) {
            return row.id > 0;
          },
        },
      },
      config: {
        card_mode: false,
        global_search: {
          placeholder: "Buscar..",
          visibility: true,
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
        loaderText: "Cargando...",
      },
      queryParams: {
        global_search: "",
        per_page: 10,
        page: 1,
      },
    };
  },
  computed: {
    ...mapState({
      posos: (state) => state.posos.posos,
      loading: (state) => state.posos.loading,
    }),
  },
  watch: {
    payment_type: function (val) {
      this.refreshTable();
    },
    status_authorization: function (val) {
      this.refreshTable();
    },
    code_bank: function (val) {
      this.refreshTable();
    },
    from: function (val) {
      this.refreshTable();
    },
    to: function (val) {
      this.refreshTable();
    },
  },
  methods: {
    formatNumber(item) {
      return numberFormat(item);
    },
    filterStatus(item) {
      const value = this.statusPay.filter((student) => student.id >= item);
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
    async refreshTable() {
      await this.fetchData(
        this.queryParams.global_search,
        this.to,
        this.from,
        this.code_bank,
        this.payment_type,
        this.status_authorization,
        this.queryParams.per_page,
        this.queryParams.page === 1
          ? 0
          : this.queryParams.per_page * (this.queryParams.page - 1)
      );
    },

    async deleteItem(item) {
      let me = this;
      const index = this.posos.data.indexOf(item);
      if (
        confirm("Esta seguro que desea eliminar?") &&
        this.posos.data.splice(index, 1)
      ) {
        const data = await this.$store.dispatch("posos/delete", item);
        if (data) {
          me.$toastr.success(
            "La petición fué hecha correctamente",
            "Eliminado"
          );
          this.refreshTable();
        }
      }
    },
  },
};
</script>
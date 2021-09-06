<template>
  <div class="card mt-3">
    <div class="card-header">
      <h3 class="card-title">Lista de Clientes</h3>
      <div class="card-tools">

        <div class="form-row">
          <div class="form-group col-md-12">
            <select class="form-control" v-model="queryParams.status" @change="refreshTable()">
              <option
                v-for="status in listStatus"
                :key="status.id"
                :value="status.id"
              >
                {{ status.name }}
              </option>
            </select>

          </div>
        </div>



      </div>
    </div>


    <div class="table-responsive pt-4">
      <vue-bootstrap4-table :classes="classes" 
        :rows="users.data ? users.data : []"
        :columns="columns"
        :config="config"
        @on-change-query="onChangeQuery"
        :show-loader="loading"
        :totalRows="users.total">
      <template slot="empty-results">
        No hay usuario registrados
      </template>

       <template slot="phone-slot" slot-scope="props">
        {{ props.row.country }}{{ props.row.phone }}
      </template>
    

      

      <template slot="available-slot" slot-scope="props">
         {{ formatNumber(props.row.posed_available) }}
      </template>
    
    <template slot="status-slot" slot-scope="props">
          <strong class="badge p-2" :class="props.row.status == 1 ? 'badge-success' : 'badge-danger'">{{ props.row.status == 1 ? 'Activo' : 'Suspendido' }}</strong>
    </template>

      

      <template slot="action-slot" slot-scope="props">
         <button class="icon-acciones" @click="$router.push(`/user-detail/${props.row.id}`).catch(() => {})">
                <i 
                  class="fas fa-eye color-icon-d"
                  data-toggle="modal"
                  data-target="#userModalInfo"
                ></i>
        </button>
         <button class="icon-acciones" @click="editItem(props.row)">
                <i
                  class="fas fa-edit color-icon-e"
                  data-toggle="modal"
                  data-target="#userModal"
                ></i>
              </button>
              <button class="icon-acciones" @click="deleteItem(props.row)" v-if="props.row.status == 1">
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
import { numberFormat } from '../../plugins/util'
export default {
  props: {
    changeform: Function,
    fetchUsers: Function
  },
  components: {
    VueBootstrap4Table,
  },
  data() {
    return {
      listStatus: [
        {
          id: 1,
          name: "Activos"
        },
        {
          id: 0,
          name: "Suspendido"
        }
      ],
      columns: [
        {
          label: "ID",
          name: "id",
        },
        {
          label: "Nombre",
          name: "name",
        },
        {
          label: "Usuario",
          name: "user",
        },
        {
          label: "Teléfono",
          name: "phone",
          slot_name: "phone-slot"
        },
        {
          label: "Status",
          name: "status",
          slot_name: "status-slot",
        },
        {
          label: "Disponible",
          name: "posed_available",
          slot_name: "available-slot",
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
          }
        },
        cell: {
          "my-cell my-cell2": true,
          "text-danger": function (row, column, cellValue) {
            return row.posed_available < 1
          },
         "font-weight-bold": function (row, column, cellValue) {
            return row.id > 0
          },
        },
      },
      config: {
        card_mode: false,
        global_search: {
          placeholder: "Buscar Cliete",
          visibility: true,
          case_sensitive: false,
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
        status: 1,
        global_search: "",
        per_page: 1,
        page: 1,
      }
    };
  },
  computed: {
     ...mapState({
    users: state => state.users.users,
    loading: state => state.users.loading
  }),
  },
  methods: {
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
      console.log('----->>>>>');
      await this.fetchUsers(this.queryParams.status, this.queryParams.global_search, this.queryParams.per_page, this.queryParams.page === 1 ? 0 : this.queryParams.per_page * (this.queryParams.page - 1))
    },
    
    async deleteItem(item) {
      let me = this;
      const index = this.users.data.indexOf(item);
      if (
        confirm("Esta seguro que desea eliminar?") &&
        this.users.data.splice(index, 1)
      ) {
        const data = await this.$store.dispatch("users/delete", item);
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
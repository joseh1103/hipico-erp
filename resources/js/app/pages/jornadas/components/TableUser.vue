<template>
<div class="mb-4 mt-2 ml-2 mr-2">
<youtube v-if="subasta.data" :video-id="subasta.data.youtube_id" player-width="400" player-height="300" :player-vars="{autoplay: 1}"></youtube>

<select class="form-control" v-model="user_id">
  <option value="0">-Usuarios-</option>
  <option v-for="user in users.data" :key="user.id" :value="user.id">
   {{ user.user }}
 </option>
</select>

<div class="table-responsive mt-2">
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

      <template slot="available-slot" slot-scope="props">
         {{ formatNumber(props.row.posed_available) }}
      </template>
    
      </vue-bootstrap4-table>
</div>
</div>
</template>

<script>
import { mapState } from "vuex";
import VueBootstrap4Table from "vue-bootstrap4-table";
import { numberFormat } from '../../../plugins/util'
export default {
  props: {
    subasta: Object
  },
  components: {
    VueBootstrap4Table,
  },
  data() {
    return {
      user_id: null,
      columns: [
        {
          label: "Usuario",
          name: "user",
        },
        {
          label: "Disponible",
          name: "posed_available",
          slot_name: "available-slot",
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
          placeholder: "Buscar Ponle",
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
        loaderText: 'Cargando...',
      },
      queryParams: {
        global_search: "",
        per_page: 10,
        page: 1,
      },
      user_array: []
    };
  },
  computed: {
     ...mapState({
    users: state => state.users.usersSaldo,
    loading: state => state.users.loading
  }),
  },
  watch: {
    subasta(obj) {
      this.refreshTable();
    },
    user_id(value) {
      if(value > 0) { 
        this.user_array =[];
        this.user_array.push(value);
        this.fetchUsers();
      }else {   
        this.refreshTable();
      }
    }
  },
  methods: {
    formatNumber(item) {
      const signo = item && item.charAt(0) == '-' ? '-' : '';
      const value = numberFormat(item);
      return `${signo}${value}`;
    },
    onChangeQuery(queryParams) {
      this.queryParams = queryParams;
      this.refreshTable();
    },
    async refreshTable () {
      this.subasta.carrera.map((items, index) => {
        items.apostador.id > 0 ? this.user_array.push(items.apostador.id) : null;
      });
      await this.fetchUsers()
    },
    async fetchUsers(limit = 10, offset = 0) {
      await this.$store.dispatch("users/saldos", {
        params: {user_array: this.user_array, limit, offset}
      });
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
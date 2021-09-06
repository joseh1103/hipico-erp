<template>
  <!-- inpud addon -->
  <div class="card card-orange mt-3">
    <div class="card-body">
      <div class="row">
        <div class="col-12">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"
                ><i class="fas fa-truck-moving"></i
              ></span>
            </div>
            <select class="form-control" v-model="formPonles.status">
              <option value="0">Selecciona un Status</option>
              <option
                v-for="item in status"
                :key="item.id"
                :value="item.id"
              >
                {{ item.name }}
              </option>
            </select>
          </div>

        </div>
      </div>

      <div class="d-flex justify-content-end">
        <button
          style="margin: 10px !important"
          type="button"
          @click.prevent="savePonle"
          :disabled="!validateForm"
          class="btn bg-orange text-light btn-save"
        >
          Guardar y Nuevo
        </button>
        <button
          style="margin: 10px !important"
          type="button"
          @click.prevent="savePonle"
          :disabled="!validateForm"
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
export default {
  props: {
    editedItem: Object,
    fetchData: Function
  },
  data() {
    return {
      url: null,
      formPonles: {
        id: null,
        status: null,
        message: null,
        phone: null,
        type: null
      },
      status: [
        {
          name: 'Abierto',
          id: 1,
        },
        {
          name: 'Solucionado',
          id: 0,
        }
      ]
    };
  },
  computed: {
    validateForm() {
      return (
        !this.errors.any()
      );
    },
  },
  watch: {
    editedItem(obj) {
      const formPonles = this.formPonles;
      Object.keys(this.formPonles).forEach(function (item) {
          formPonles[item] = obj[item];
      });
    },
  },
  methods: {
    resertFormProduct() {
      this.formPonles = {
        id: null,
        message: null,
        phone: null,
        type: null
      };
    },
    async savePonle() {
      let me = this;
      const data = await this.$store.dispatch(
        "suggestions/store",
        this.formPonles
      );
      if (data) {
        this.resertFormProduct();
        me.$toastr.success("La petición fué hecha correctamente", "Guardado");
        this.fetchData();
      }
    }
  },
};
</script>
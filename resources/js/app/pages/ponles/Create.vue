<template>
  <!-- inpud addon -->
  <div class="card card-orange mt-3">
    <div class="card-body">
      <div class="row">
        <div class="col-12">
         
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"
                ><i class="fas fa-pencil-alt"></i
              ></span>
            </div>
            <input
              data-vv-validate-on="blur"
              v-validate="'required'"
              type="text"
              v-model="formPonles.ini_monto"
              class="form-control no-border-radius"
              placeholder="Monto Inicial"
              name="monto"
            />
          </div>
          <span class="text-danger text-sm">{{
            errors.first("monto")
          }}</span>



          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"
                ><i class="fas fa-pencil-alt"></i
              ></span>
            </div>
            <input
              data-vv-validate-on="blur"
              v-validate="'required'"
              type="text"
              v-model="formPonles.end_monto"
              class="form-control no-border-radius"
              placeholder="Monto Final"
              name="montofinal"
            />
          </div>
          <span class="text-danger text-sm">{{
            errors.first("montofinal")
          }}</span>



          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"
                ><i class="fas fa-pencil-alt"></i
              ></span>
            </div>
            <input
              data-vv-validate-on="blur"
              v-validate="'required'"
              type="text"
              v-model="formPonles.value"
              class="form-control no-border-radius"
              placeholder="Valor"
              name="value"
            />
          </div>
          <span class="text-danger text-sm">{{
            errors.first("value")
          }}</span>


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
    fetchData: Function,
    status: Array
  },
  data() {
    return {
      url: null,
      formPonles: {
        id: null,
        ini_monto: null,
        end_monto: null,
        value: null
      }
    };
  },
  computed: {
    validateForm() {
      return (
        !this.errors.any() &&
        this.formPonles.ini_monto !== "" &&
        this.formPonles.end_monto !== "" &&
        this.formPonles.value !== ""
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
        ini_monto: null,
        end_monto: null,
        value: null
      };
    },
    async savePonle() {
      let me = this;
      const data = await this.$store.dispatch(
        "ponles/store",
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
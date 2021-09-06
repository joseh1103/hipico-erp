<template>
  <!-- inpud addon -->
  <div class="card card-orange mt-3">
    <div class="card-body">
      <div class="row">
        <div :class="formHipodromos.id > 0 ? 'col-6' : 'col-12' ">
         
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
              v-model="formHipodromos.name"
              class="form-control no-border-radius"
              placeholder="Nombre"
              name="Nombre"
            />
          </div>
          <span class="text-danger text-sm">{{
            errors.first("Nombre")
          }}</span>


          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"
                ><i class="fas fa-truck-moving"></i
              ></span>
            </div>
            <select class="form-control" v-model="formHipodromos.status">
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
        <div v-show="formHipodromos.id > 0 " class="col-6">
          <div class="text-center w-100 h-30 p-3">
            <img
              :src="imgSet()"
              class="img-thumbnail img-rounded"
              alt="producto"
              @click="$refs.file.click()"
            />
            <input
              type="file"
              @change="onFileChange"
              style="display: none"
              ref="file"
            />
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-end">
        <button
          style="margin: 10px !important"
          type="button"
          @click.prevent="saveHipodrmo"
          :disabled="!validateForm"
          class="btn bg-orange text-light btn-save"
        >
          Guardar y Nuevo
        </button>
        <button
          style="margin: 10px !important"
          type="button"
          @click.prevent="saveHipodrmo"
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
import { mapState } from "vuex";
export default {
  props: {
    editedItem: Object,
    fetchData: Function,
    status: Array
  },
  data() {
    return {
      url: null,
      formHipodromos: {
        id: null,
        name: null,
        image: null,
        status: 1,
      }
    };
  },
  computed: {
    validateForm() {
      return (
        !this.errors.any() &&
        this.formHipodromos.name !== "" &&
        this.formHipodromos.status !== ""
      );
    },
  },
  watch: {
    editedItem(obj) {
      this.formHipodromos.image = "";
      const formHipodromos = this.formHipodromos;
      Object.keys(this.formHipodromos).forEach(function (item) {
          formHipodromos[item] = obj[item];
      });
    },
  },
  methods: {
    imgSet() {
      const img =
        this.url != null
          ? this.url
          : !this.formHipodromos.image
          ? "/img/product-default-image.jpg"
          : `../hipodromos/${this.formHipodromos.image}`;
      return img;
    },
    onFileChange(e) {
      const file = e.target.files[0];
      this.formHipodromos.image = e.target.files[0];
      this.url = URL.createObjectURL(file);
      this.uploadImage();
    },
    resertFormProduct() {
      this.formHipodromos = {
        id: null,
        name: null,
        status: 1,
        image: null
      };
    },
    async saveHipodrmo() {
      let me = this;
      const data = await this.$store.dispatch(
        "hipodromos/store",
        this.formHipodromos
      );
      if (data) {
        this.resertFormProduct();
        me.$toastr.success("La petición fué hecha correctamente", "Guardado");
        this.fetchData();
      }
    },
    async uploadImage() {
      let me = this;
      let formData = new FormData();
      formData.append('image', this.formHipodromos.image);
      formData.append('id', this.formHipodromos.id);
      const data = await this.$store.dispatch(
        "hipodromos/upload",
        formData
      );
      if (data) {
        me.$toastr.success("Imagen Subida correctamente", "Guardado");
        this.fetchData();
      }
    },
  },
};
</script>
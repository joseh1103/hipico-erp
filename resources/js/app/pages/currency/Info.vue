<template>
  <!-- inpud addon -->
  <div class="card card-orange mt-3">
    <div class="card-body">
      <div class="row">
        <div class="col-6">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">║█║▌║█║▌│║▌║▌█║</span>
            </div>
            <input
              data-vv-validate-on="blur"
              v-validate="'required'"
              type="text"
              v-model="formProduct.barcode"
              placeholder="Codigo de barras"
              class="form-control no-border-radius"
              name="Codigo"
              disabled
            />
          </div>
          <span class="text-danger text-sm">{{ errors.first("Codigo") }}</span>

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
              v-model="formProduct.description"
              class="form-control no-border-radius"
              placeholder="Descripción"
              name="Descripcion"
              disabled
            />
          </div>
          <span class="text-danger text-sm">{{
            errors.first("Descripcion")
          }}</span>

          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">-$ </span>
            </div>
            <input
              type="text"
              v-model="formProduct.product_cost"
              placeholder="Precio de lista"
              class="form-control no-border-radius"
              disabled
            />
            <div class="input-group-append">
              <span class="input-group-text no-border-radius">.00</span>
            </div>
          </div>

          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"
                ><i class="fas fa-money-check-alt"></i
              ></span>
            </div>
            <input
              type="text"
              v-model="formProduct.value"
              class="form-control no-border-radius"
              placeholder="Precio en tienda virtual  (Si este valor está vacio se pondrá el precio de lista)"
              disabled           
            />
            <div class="input-group-append">
              <span class="input-group-text no-border-radius">.00</span>
            </div>
          </div>

          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"
                ><i class="fas fa-truck-moving"></i
              ></span>
            </div>
            <select class="form-control" v-model="formProduct.provider_id" disabled>
              <option value="0">Selecciona un proveedor</option>
              <option
                v-for="proveedor in providers.data"
                :key="proveedor.id"
                :value="proveedor.id"
              >
                {{ proveedor.name }}
              </option>
            </select>
          </div>

          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"
                ><i class="fas fa-truck-moving"></i
              ></span>
            </div>
            <select class="form-control" v-model="formProduct.line_id" disabled>
              <option value="0">Selecciona una categoria</option>
              <option
                v-for="linea in lines.data"
                :key="linea.id"
                :value="linea.id"
              >
                {{ linea.name }}
              </option>
            </select>
          </div>
        </div>
        <div class="col-6">
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
              disabled
            />
          </div>
        </div>
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
  },
  data() {
    return {
      url: null,
      formProduct: {
        type: 1,
        product_id: null,
        barcode: "",
        description: "",
        line_id: 1,
        provider_id: 1,
        value: 0,
        product_cost: 0,
        image: "",
      },
    };
  },
  computed: {
    ...mapState({
      providers: (state) => state.provider.providers,
      lines: (state) => state.lines.lines,
      loading: (state) => state.product.loading,
    }),
    validateForm() {
      return (
        !this.errors.any() &&
        this.formProduct.description !== "" &&
        this.formProduct.barcode !== "" &&
        this.formProduct.product_cost !== "" &&
        this.formProduct.value !== ""
      );
    },
  },
  watch: {
    editedItem(obj) {
      const formProduct = this.formProduct;
      Object.keys(this.formProduct).forEach(function (item) {
        formProduct[item] = obj[item];
      });
    },
  },
  methods: {
    imgSet() {
      const img =
        this.url != null
          ? this.url
          : !this.formProduct.image
          ? "/img/product-default-image.jpg"
          : `../inventory/${this.formProduct.image}`;
      return img;
    },
    onFileChange(e) {
      const file = e.target.files[0];
      this.formProduct.image = e.target.files[0];
      this.url = URL.createObjectURL(file);
    },
    resertFormProduct() {
      this.formProduct = {
        product_id: null,
        type: 1,
        line_id: 1,
        provider_id: 1,
        barcode: "",
        description: "",
        value: 0,
        purchase_price: [],
        product_cost: 0,
        costo_ultimo: null,
        status: true,
        image: "",
      };
    },
    async saveProduct() {
      let me = this;
      let formData = new FormData();
      const obj = this.formProduct;
      formData.append('file',this.formProduct.image);
      Object.keys(this.formProduct).forEach(function (item) {
        formData.append(item, obj[item]);
      });

      console.log(formData);
      const data = await this.$store.dispatch(
        "product/store",
        formData
      );
      if (data) {
        this.resertFormProduct();
        me.$toastr.success("La petición fué hecha correctamente", "Guardado");
        this.fetchData();
      }
    },
  },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Lato&display=swap");
</style>
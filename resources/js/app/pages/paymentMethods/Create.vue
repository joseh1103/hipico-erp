<template>
  <!-- inpud addon -->
  <div class="card card-orange mt-3">
    <div class="card-body">
      <div class="row">
        <div class="col-12">

        <div v-show="form.id > 0 " class="col-12">
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

        <div class="form-row">
          <div class="form-group col-md-12 col-xs-12">
            
              <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"
                  ><i class="fas fa-money-check-alt"></i
                ></span>
              </div>
              <select class="form-control" v-model="form.typePayment">
                <option value="0">Selecciona Tipo de Pago</option>
                <option v-for="item in typePayment" :key="item" :value="item">
                  {{ item }}
                </option>
              </select>
            </div>
          </div>

         <div class="form-group col-md-12 col-xs-12">
            
              <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"
                  ><i class="fas fa-money-check-alt"></i
                ></span>
              </div>
              <select class="form-control" v-model="form.currency_id">
                <option value="0">Selecciona Moneda</option>
                <option v-for="item in currency.data" :key="item.id" :value="item.id">
                  {{ item.name }} / {{ item.symbol }}
                </option>
              </select>
            </div>
          </div>

          <div class="form-group col-md-12 col-xs-12" v-show="form.typePayment == 'Transferencia'">
              <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"
                  ><i class="fas fa-university"></i></span>
              </div>
             <select class="form-control" v-model="form.code_bank">
                <option value="0">- Selecione Banco-</option>
                <option v-for="item in banck" :key="item.code" :value="item.code">
                  {{ item.name }}
                </option>
              </select>
            </div>
          </div>

        <div class="form-group col-md-12 col-xs-12" v-show="form.typePayment == 'Transferencia'">
              <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"
                  >
                  <i class="fas fa-money-check-alt"></i>
                  </span>
              </div>
              <input
                data-vv-validate-on="blur"
                v-validate="'required'"
                type="text"
                v-model="form.account_number"
                class="form-control no-border-radius"
                placeholder="0105-0012-1121-1211-1212"
                name="cuenta"
              />
            </div>
           </div>



          <div class="form-group col-md-4 col-xs-6" v-show="form.typePayment == 'Transferencia'">
            
              <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"
                  ><i class="fas fa-money-check-alt"></i
                ></span>
              </div>
              <select class="form-control" v-model="form.typeDocument">
                <option value="0">Documento</option>
                <option v-for="item in typeDocument" :key="item" :value="item">
                  {{ item }}
                </option>
              </select>
            </div>
          </div>

           <div class="form-group col-md-8 col-xs-6" v-show="form.typePayment == 'Transferencia'">
              <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"
                  >
                  <i class="far fa-id-card"></i>
                  </span>
              </div>
              <input
                data-vv-validate-on="blur"
                v-validate="'required'"
                type="text"
                v-model="form.document"
                class="form-control no-border-radius"
                placeholder="Documento"
                name="name"
              />
            </div>

           </div>

           <div class="form-group col-md-12 col-xs-12" v-show="form.typePayment == 'Transferencia' || form.typePayment == 'Zelle'">
              <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"
                  >
                  <i class="fas fa-pencil-alt"></i>
                  </span>
              </div>
              <input
                data-vv-validate-on="blur"
                v-validate="'required'"
                type="text"
                v-model="form.name_beneficiary"
                class="form-control no-border-radius"
                placeholder="Jose Hernandez"
                name="name"
              />
            </div>
           </div>


          <div class="form-group col-md-12 col-xs-12" v-show="form.typePayment == 'Transferencia'">
              <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"
                  >
                  <i class="far fa-id-card"></i>
                  </span>
              </div>
              <input
                data-vv-validate-on="blur"
                v-validate="'required'"
                type="text"
                v-model="form.phone"
                class="form-control no-border-radius"
                placeholder="0412-8763843"
                name="name"
              />
            </div>
           </div>

          
          

          <div class="form-group col-md-12 col-xs-12" v-show="form.typePayment == 'Zelle'">
              <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"
                  >
                  <i class="fas fa-envelope-square"></i>
                  </span>
              </div>
              <input
                data-vv-validate-on="blur"
                v-validate="'required'"
                type="text"
                v-model="form.email"
                class="form-control no-border-radius"
                placeholder="josemanuel.h.1103@gmial.com"
                name="cuenta"
              />
            </div>
          </div>
   

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
import { banck } from '../../plugins/util'
export default {
  props: {
    editedItem: Object,
    currency: Object,
    fetchData: Function,
    typePayment: Array,
    typeDocument: Array
  },
  data() {
    return {
      url: null,
      banck: banck,
      form: {
        id: null,
        image: null,
        typePayment: 0,
        typeDocument: 'V',
        document: null,
        phone: null,
        name_beneficiary: null,
        account_number: null,
        code_bank: 0,
        email: null,
        currency_id: 0
      }
    };
  },
  computed: {
    validateForm() {
      return (
        !this.errors.any() &&
        this.form.name !== "" &&
        this.form.symbol !== ""
      );
    },
  },
  watch: {
    editedItem(obj) {
      const form = this.form;
      Object.keys(this.form).forEach(function (item) {
        form[item] = obj[item];
      });
    },
  },
  methods: {
    imgSet() {
      const img =
        this.url != null
          ? this.url
          : !this.form.image
          ? "/img/product-default-image.jpg"
          : `../banck/${this.form.image}`;
      return img;
    },
    onFileChange(e) {
      const file = e.target.files[0];
      this.form.image = e.target.files[0];
      this.url = URL.createObjectURL(file);
      this.uploadImage();
    },
    async uploadImage() {
      let me = this;
      let formData = new FormData();
      formData.append('image', this.form.image);
      formData.append('id', this.form.id);
      const data = await this.$store.dispatch(
        "paymentMethods/upload",
        formData
      );
      if (data) {
        me.$toastr.success("Imagen Subida correctamente", "Guardado");
        this.fetchData();
      }
    },
    resertFormProduct() {
      this.form = {
        id: null,
        typePayment: 'Transferencia',
        typeDocument: 'V',
        document: null,
        phone: null,
        name_beneficiary: null,
        account_number: null,
        code_bank: null,
        email: null,
        currency_id: null
      };
    },
    async savePonle() {
      let me = this;
      const data = await this.$store.dispatch(
        "paymentMethods/store",
        this.form
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
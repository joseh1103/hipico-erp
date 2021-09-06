<template>
  <!-- inpud addon -->
  <div class="card card-orange mt-3">
    <div class="card-body">
      <div class="row">
        <div class="col-12">

      <div class="form-row">
        
        <div class="form-group col-md-6 col-xs-6" v-if="formPoso.id_account_user">
          <label for="Nro">Datos del Retiro</label>
           <div class="card">
            <div class="card-body">
              <h5 class="card-title">{{ bankRetiro.typePayment }}</h5>
              <p class="card-text"> {{ bankRetiro.typeDocument }}: {{ bankRetiro.document }}/{{ bankRetiro.name_beneficiary }}</p>
               <p class="card-text">NC: {{ searchBank(bankRetiro.code_bank) }}
               {{ bankRetiro.account_number }}</p>
              
              <a href="#" class="card-link">Pago Movil: {{ bankRetiro.phone }}</a>
            </div>
          </div>

           

        </div>
        
        <div class="form-group col-md-6 col-xs-6" v-if="formPoso.payment_type == 2 && formPoso.id_account_user">
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


          <div class="form-group col-md-12 col-xs-12">
            <label for="Nro">Usuario</label>
            
          <select class="form-control" v-model="formPoso.user_id" required>
              <option selected>- Selecione Usuario-</option>
              <option
                v-for="user in users.data"
                :key="user.id"
                :value="user.id"
              >
                {{ user.user }}
              </option>
            </select>

          </div>

          
          <div class="form-group col-md-6 col-xs-6">
            <label for="Tipo">Tipo Operacion</label>
            <select class="form-control" v-model="formPoso.payment_type" required>
              <option value="" selected>- Selecione Tipo Operacion -</option>
              <option
                v-for="operations in operations"
                :key="operations.id"
                :value="operations.id"
              >
                {{ operations.name }}
              </option>
            </select>
          </div>
          
          <div class="form-group col-md-6 col-xs-6">
            <label for="Tipo">Status</label>
              <select class="form-control" v-model="formPoso.status_authorization" required>
              <option value="" selected>- Selecione Status -</option>
              <option
                v-for="status in statusPay"
                :key="status.id"
                :value="status.id"
              >
                {{ status.name }}
              </option>
            </select>
          </div>

          <div class="form-group col-md-12 col-xs-12" v-if="formPoso.payment_type ==3">
            <label for="Nro">Usuario que Recibe</label>
            
              <select class="form-control" v-model="formPoso.user_to_id" required>
                <option selected>- Selecione Usuario-</option>
                <option
                  v-for="user in users.data"
                  :key="user.id"
                  :value="user.id"
                >
                  {{ user.user }}
                </option>
              </select>

          </div>


          <div class="form-group col-md-12 col-xs-12" v-if="formPoso.payment_type ==2">
  
            <label for="Origen">Banco Origen</label>
            <select class="form-control" v-model="formPoso.origin_bank" required>
              <option selected>- Selecione Banco-</option>
              <option
                v-for="banckD in banck"
                :key="banckD.code"
                :value="banckD.code"
              >
                {{ banckD.name }}
              </option>
            </select>

          </div>

          <div class="form-group col-md-12 col-xs-12" v-if="formPoso.payment_type ==1">
            <label for="Destino">Banco Destino</label>
        
            <select class="form-control" v-model="formPoso.destination_bank" required>
              <option selected>- Selecione Banco-</option>
              <option
                v-for="banckD in banck"
                :key="banckD.code"
                :value="banckD.code"
              >
                {{ banckD.name }}
              </option>
            </select>

          </div>

         <div class="form-group col-md-12 col-xs-12">
            <label for="Nro">Monto</label>
            <input
              data-vv-validate-on="blur"
              v-validate="'required'"
              type="text"
              v-model="formPoso.monto"
              class="form-control no-border-radius"
              placeholder="Monto"
              name="Monto"
            />
          </div>

          
          
         <div class="form-group col-md-12 col-xs-12">
            <label for="Nro">Descripción</label>
            <input
              data-vv-validate-on="blur"
              v-validate="'required'"
              type="text"
              v-model="formPoso.description"
              class="form-control no-border-radius"
              placeholder="Descripción"
              name="Descripción"
            />
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
    fetchData: Function,
    statusPay: Array,
    users: Object,
    operations: Array
  },
  data() {
    return {
      url: null,
      bankRetiro: {},
      formPoso: {
        id: null,
        user_id: null,
        origin_bank: null,
        destination_bank: null,
        payment_type: 1,
        monto: 0,
        status_authorization: null,
        user_to_id: null,
        description: "",
        id_account_user: null,
        image: null
      },
      banck: banck
    };
  },
  computed: {
    validateForm() {
      return (
        !this.errors.any() &&
        this.formPoso.user_id !== null &&
        this.formPoso.monto !== null &&
        this.formPoso.description !== null
      );
    },
  },
  watch: {
    editedItem(obj) {
      console.log(obj)
      const formPoso = this.formPoso;
      Object.keys(this.formPoso).forEach(function (item) {
          formPoso[item] = obj[item];
      });
      if (formPoso.id_account_user > 0) this.searchDatos(formPoso.id_account_user);
    },
  },
  methods: {
    imgSet() {
      const img =
        this.url != null
          ? this.url
          : !this.formPoso.image
          ? "/img/product-default-image.jpg"
          : `../hipodromos/${this.formPoso.image}`;
      return img;
    },
    onFileChange(e) {
      const file = e.target.files[0];
      this.formPoso.image = e.target.files[0];
      this.url = URL.createObjectURL(file);
      this.uploadImage();
    },
    async uploadImage() {
      let me = this;
      let formData = new FormData();
      formData.append('image', this.formPoso.image);
      formData.append('id', this.formPoso.id);
      const data = await this.$store.dispatch(
        "posos/upload",
        formData
      );
      if (data) {
        me.$toastr.success("Imagen Subida correctamente", "Guardado");
        this.fetchData();
      }
    },
    resertFormProduct() {
      this.formPoso = {
        id: null,
        user_id: null,
        origin_bank: null,
        destination_bank: null,
        payment_type: 1,
        monto: 0,
        status_authorization: null,
        user_to_id: null,
        description: "",
        id_account_user: null
      };
    },
    async searchDatos(id) {
      this.bankRetiro = await this.$store.dispatch(
        "posos/search",
        id
      );
    },
    searchBank(value) {
      if (value) return this.banck.filter(item => item.code == value).shift().name;
    },
    async savePonle() {
      let me = this;      
      const data = await this.$store.dispatch(
        "posos/store",
        this.formPoso
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
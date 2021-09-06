<template>
  <!-- inpud addon -->
  <div class="card card-orange mt-3">
    <div class="card-body">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-user"></i></span>
        </div>
        <input
          data-vv-validate-on="blur"
          v-validate="'required'"
          type="text"
          v-model="formUser.name"
          placeholder="Nombre y Apellido"
          class="form-control no-border-radius"
          name="Nombre"
        />
      </div>


      <span class="text-danger text-sm">{{ errors.first('Nombre') }}</span>

      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-envelope-square"></i></span>
        </div>
        <input
          data-vv-validate-on="blur"
          v-validate="'required'"
          type="text"
          v-model="formUser.user"
          placeholder="User"
          class="form-control no-border-radius"
          name="User"
        />
      </div>

       <span class="text-danger text-sm">{{ errors.first('User') }}</span>


        <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-envelope-square"></i></span>
        </div>
        <input
          data-vv-validate-on="blur"
          v-validate="'required'"
          type="text"
          v-model="formUser.email"
          placeholder="Correo electrónico"
          class="form-control no-border-radius"
          name="Email"
        />
      </div>

       <span class="text-danger text-sm">{{ errors.first('Email') }}</span>

       <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-phone-square-alt"></i></span>
        </div>
        <input
          data-vv-validate-on="blur"
          v-validate="'required'"
          type="text"
          v-model="formUser.phone"
          placeholder="Teléfono"
          class="form-control no-border-radius"
          name="Telefono"
        />
      </div>

       <span class="text-danger text-sm">{{ errors.first('Telefono') }}</span>
      
  
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"
            ><i class="fas fa-user-tag"></i></span>
        </div>
        <select class="form-control" v-model="formUser.role_id" required>
          <option disabled value="">- Roll de Usuario -</option>
          <option
            v-for="role in roles.data"
            :key="role.id"
            :value="role.id"
          >
            {{ role.name }}
          </option>
        </select>
      </div> 

         <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
        </div>
        <input
          data-vv-validate-on="blur"
          v-validate="'required'"
          type="password"
          v-model="formUser.password"
          placeholder="Contraseña"
          class="form-control no-border-radius"
          name="Contraseña"
        />
      </div>

       <span class="text-danger text-sm">{{ errors.first('Contraseña') }}</span>

      <div class="d-flex justify-content-end">
        <button
        style="margin:10px !important;"
          type="button"
          @click.prevent="saveUser" :disabled="!validateForm"
          class="btn bg-orange text-light btn-save"
        >
          Guardar y Nuevo
        </button>
        <button
        style="margin:10px !important;"
          type="button"
          @click.prevent="saveUser" :disabled="!validateForm"
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
  },
  data() {
    return {
      formUser: {
        id: null,
        user: null,
        name: '',
        role_id: null,
        email: '',
        phone: '',
        password: '',
      }
    };
  },
  computed: {
  ...mapState({
      roles:  state => state.role.roles,
      user: state => state.users.user
    }),
  validateForm () {
  return !this.errors.any() && this.formUser.name !== '' && this.formUser.email !== '' && this.formUser.phone !== '' 
  &&  this.formUser.password !== ''
  }
  },
  watch: {
    editedItem (obj) {
      const formUser = this.formUser;
      Object.keys(this.formUser).forEach(function (item) {
          formUser[item] = obj[item];
      });
    }
  },
  methods: {
    resertFormUsers() {
      this.formUser = {
        id: null,
        role_id: null,
        name: '',
        user: '',
        email: '',
        phone: '',
        password: '',
      }
    },
    
    async saveUser() {
      let me = this;
      await this.$store.dispatch("users/store", this.formUser);
      if (this.user.id) {
        this.resertFormUsers();
        me.$toastr.success("La petición fué hecha correctamente", "Guardado");
        this.fetchData();
      }
    }   
    
  }
};
</script>
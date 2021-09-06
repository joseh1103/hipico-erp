<template>
  <div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="notificationsModal"
      tabindex="-1"
      aria-labelledby="notificationsModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-orange">
              
            <h5 class="modal-title text-light" id="notificationsModalLabel">Enviar Comunicado</h5>
            
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form>
              <div class="form-group">
                <label for="formGroupExampleInput">Titulo</label>
                <input type="text" class="form-control" v-model="form.title" placeholder="Titulo el Mensaje">
              </div>
              <div class="form-group">
                <label for="formGroupExampleInput2">Mensaje</label>
                  <textarea class="form-control" v-model="form.message" placeholder="Cuerpo del mensaje" required></textarea>
              </div>
            </form>

            <div class="d-flex justify-content-end">
                <button
                style="margin:10px !important;"
                  type="button"
                  @click.prevent="send"
                  class="btn bg-orange text-light btn-save"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  Enviar Comunicado
                </button>
            </div>
             
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  components: {
  },
  props: {
  },
  data() {
    return {
      form: {
        title: '',
        message: ''
      }
    };
  },
  methods: {
    async send() {
      let me = this;
      const data = await this.$store.dispatch("jornadas/storeNotifications", this.form);
      if (data) {
        me.$toastr.success("La petición fué hecha correctamente", "Guardado");
      }
    }   
  }
};
</script>

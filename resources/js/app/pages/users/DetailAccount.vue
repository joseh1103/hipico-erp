<template>
  <!-- inpud addon -->
  <div class="card mt-3">
  
   
  
      <ul class="list-group">
             
        <li class="list-group-item d-flex justify-content-between align-items-center">
          Saldo Inicial:
          <label :class="balance.initialbalance && balance.initialbalance.monto > 0 ? 'text-success': 'text-danger'">{{ balance.initialbalance ? formatNumber(balance.initialbalance.monto) : formatNumber(0) }}</label>
        </li>

       

        <li class="list-group-item d-flex justify-content-between align-items-center"
        v-for="resumen in balance.resumen" :key="resumen.id">
          <label> {{ resumen.name }} </label>
          <label :class="resumen.monto > 0 ? 'text-success': 'text-danger'">{{ formatNumber(resumen.monto) }}</label>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          Saldo Disponible:
          <label v-if="balance.user" :class="balance.user.posed_available > 0 ? 'text-success': 'text-danger'">{{ balance.user ? formatNumber(balance.user.posed_available) :'...' }} </label>
        </li>
      </ul>

      <div class="d-flex justify-content-end">
        <button
        style="margin:10px !important;"
          type="button"
          class="btn bg-orange text-light btn-save"
          data-dismiss="modal"
          aria-label="Close"
        >
          Descargar Detallado
        </button>
      </div> 

    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</template>

<style scoped>
.btn-save {
  border-radius: 2px !important;
  font-weight: bold;
  color: #EC892B;
}
</style>

<script>
import { numberFormat } from '../../plugins/util';
export default {
  props: {
    balance: Object
  },
  data() {
    return {
    };
  },
  watch: {
    editedItem (obj) {
      console.log(obj);
    }
  },
  methods: {  
    formatNumber(item) {
      const signo = item && item.charAt(0) == '-' ? '-' : '';
      const value = numberFormat(item);
      return `${signo}${value}`;
    }, 
  }
};
</script>
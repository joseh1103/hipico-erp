<template>
  <div class="card mb-4 mt-2">
    <img class="card-img-top" height="180px" src="/img/logo.png" alt="erp" />
    <ul class="list-group list-group-flush">
      <li class="list-group-item">Hipodromo: {{ jornada.hipodromo ? jornada.hipodromo.name : 'No-Definido' }}</li>
      <li class="list-group-item">Fecha: {{ subasta.data ? subasta.data.date : 'No-Definido' }}</li>
      <li class="list-group-item" data-toggle="modal" data-target="#subastaModal" data-backdrop="static" data-keyboard="false">
        Carrera: #{{ subasta.data ? subasta.data.carrera : 'No-Definido' }}
      </li>
      <li class="list-group-item" v-if="subasta.data"><Contador :timeSubasta="subasta"></Contador>
      </li>
      <li class="list-group-item">Distancia: {{ subasta.data ? subasta.data.distance : 'No-Definido' }}</li>
      <li class="list-group-item">Detalle: {{ subasta.data ? subasta.data.detail : 'No-Definido' }}</li>
      <li class="list-group-item">Estado: 
          <span class="badge p-2" :class="subasta.data && subasta.data.status_cierre == true ? 'badge-success' : 'badge-danger'">
              {{ subasta.data && subasta.data.status_cierre == true ? 'RECIBIENDO JUGADAS' : 'CERRADO' }}
          </span>
          
          </li>
      <li class="list-group-item">Incentivo: <span class="text-warning font-weight-bold"> {{ subasta.data ? subasta.data.incentive : 'No-Definido'}}</span> </li>
      <li class="list-group-item">Total a pagar: <span class="text-success font-weight-bold">{{ subasta.data ? subasta.data.total  : 'No-Definido' }} </span></li>
      <li class="list-group-item">Pizarra: <span class="text-success font-weight-bold">{{ subasta.data ? subasta.data.pizarra  : 'No-Definido' }} </span></li>
    </ul>
  </div>
</template>
<script>
import Contador from "./contador.vue";
export default {
  components: {
    Contador
  },
  props: {
    jornada: Object,
    subasta: Object,
  },
  data () {
    return {
    }
  },
};
</script>

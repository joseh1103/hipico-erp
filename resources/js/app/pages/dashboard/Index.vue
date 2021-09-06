<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->

    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h4 class="info-box-text">{{ formatNumber(balance.porPagar) }}</h4>

            <p>Cuentas por Pagar</p>
          </div>
          <div class="icon">
            <i class="fas fa-money-check-alt"></i>
          </div>
          <a href="#" class="small-box-footer"
            >Mas <i class="fas fa-arrow-circle-right"></i
          ></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h4>{{ formatNumber(balance.porCobrar) }}</h4>

            <p>Cuentas por Cobrar</p>
          </div>
          <div class="icon">
            <i class="fas fa-search-dollar"></i>
          </div>
          <a href="#" class="small-box-footer"
            >Mas <i class="fas fa-arrow-circle-right"></i
          ></a>
        </div>
      </div>
      <!-- ./col -->

      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h4>{{ formatNumber(balance.pendienteAprobar.monto) }}</h4>

            <p>Posos por Confirmar: {{ balance.pendienteAprobar.total }}</p>
          </div>
          <div class="icon">
           <i class="fas fa-money-check-alt"></i>
          </div>
          <router-link class="small-box-footer" to="/posos">
          <a href="#"
            >Mas <i class="fas fa-arrow-circle-right"></i
          ></a>
          </router-link>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h4>{{ data.users }}</h4>

            <p>Usuarios Registrados</p>
          </div>
          <div class="icon">
            <i class="fas fa-user-check"></i>
          </div>
          <a href="#" class="small-box-footer"
            >Mas <i class="fas fa-arrow-circle-right"></i
          ></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-6 connectedSortable">
                    <!-- PRODUCT LIST -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Ganancias y Perdidas
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                  <li class="item" v-for="resumen in data.win" :key="resumen.jornada_id">
                    <div class="product-img">
                      <img :src="resumen.image !=null ? `../hipodromos/${resumen.image}` : '/img/product-default-image.jpg'" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title">Nro Jornada {{ resumen.jornada_id }}
                        <h4 class="float-right" :class="resumen.total_ganancia > 0 ? 'text-success': 'text-danger'">
                        {{ formatNumber(resumen.total_ganancia) }}
                          </h4></a>
                      <span class="product-description">
                         <span class="badge p-2 badge-success">{{ resumen.date }}</span>
                      </span>
                    </div>
                  </li>
                  <!-- /.item -->

                </ul>
              </div>
              <!-- /.card-body -->
              <div class="card-footer text-center">
                <router-link class="nav-link" to="/jornadas"> <a href="javascript:void(0)" class="uppercase">Totas Las Jornadas</a></router-link>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->


        <!-- TO DO List -->

        <!-- /.card -->
      </section>
      <!-- /.Left col -->
      <!-- right col (We are only adding the ID to make the widgets sortable)-->
      <section class="col-lg-6 connectedSortable">
        <!-- Map card -->
        <div class="card">
          <div class="card-header border-0">
            <h3 class="card-title">
              <i class="fas fa-university mr-1"></i>
              Relacion Bancaria
            </h3>
            <!-- card tools -->
            <div class="card-tools">
              <button
                type="button"
                class="btn btn-primary btn-sm"
                data-card-widget="collapse"
                title="Collapse"
              >
                <i class="fas fa-minus"></i>
              </button>
            </div>
            <!-- /.card-tools -->
          </div>
          <div class="card-body">
          <table class="table table-striped table-valign-middle">
              <thead>
                <tr>
                  <th>Banco</th>
                  <th>Monto</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in relacionBanck" :key="item.id">
                
                  <td v-if="item.destination_bank !=''">{{ searchBank(item.destination_bank) }}</td>
                  <td>
                    <label class="text-success mr-1">
                       {{ formatNumber(item.posed_available) }}
                    </label>
                   
                  </td>

                </tr>
              </tbody>
            </table>


              




          </div>

        </div>
        <!-- /.card -->

        <!-- /.card -->
      </section>
      <!-- right col -->
    </div>
    <!-- /.row (main row) -->
    <!-- /.content -->
  </div>
</template>
<script>
import { banck, numberFormat } from '../../plugins/util'
import { mapState } from "vuex";
export default {
  middleware: "auth",
  components: {},
  data() {
    return {
      banck: banck,
      balance: {
        porPagar: 0,
        porCobrar: 0,
        pendienteAprobar:{
          monto: 0,
          total: 0
        }
      },
      relacionBanck:{}
    };
  },
  computed: {
    ...mapState({
      data: (state) => state.dashboard.dashboard,
    }),
  },
  methods: {
    searchBank(value) {
      return this.banck.filter(item => item.code == value).shift().name;
    },
    formatNumber(item) {
      //const signo = item && item.charAt(0) == '-' ? '-' : '';
      const value = numberFormat(item);
      return `${value}`;
    },
    async fetchData() {
      await this.$store.dispatch("dashboard/fetch");
      await this.$store.dispatch("dashboard/fetchUsers");
      //calcular por cobrar y por pagar
      this.data.data.map((items) => {
        if (items.posed_available !== null) {
          const monto = parseInt(items.posed_available);
          if (monto > 0) {
            this.balance.porPagar += monto;
          } else {
            this.balance.porCobrar += monto;
          }
        }
        return items;
      });

      //calcular posos pendientes por aprobacion
      this.data.posos.map((items) => {
        if (items.posed_available !== null) {
          const monto = parseInt(items.posed_pending);
          if (monto > 0) {
            this.balance.pendienteAprobar.monto += monto;
            this.balance.pendienteAprobar.total += 1;
          }
        }
        return items;
      });

      await this.homologarBanck();
    },
    async homologarBanck() {
      const banckRelacion = [];
      this.data.bank.map((items) => {
        if (items.payment_type == 1) {
          console.log('paso', items);
          banckRelacion.push(items);
        }
        return items;
      });

      this.data.bank.map( async (items) => {
        if (items.payment_type == 2) {
          let monto = banckRelacion.filter(
          (item) => item.destination_bank == items.origin_bank
          ).shift();
          if (monto != undefined) {
            monto.posed_available -= items ? parseInt(items.posed_available) : 0;
          }
        }
         console.log('restar poso', items);
        return items;
      });
      this.relacionBanck = banckRelacion;
    }
  },
  mounted() {
    this.fetchData();
  },
};
</script>

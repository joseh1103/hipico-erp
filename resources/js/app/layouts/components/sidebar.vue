<template>
  <aside class="main-sidebar sidebarlight-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img
        src="/img/logo.png"
        alt="ERP HIPICO"
        class="brand-image img-circle"
        style="opacity: 0.9"
      />
      <span class="brand-text font-weight-light pr-2 text-orange">
        ERP Hipico 2020</span
      >
    </a>

    <!-- Sidebar
    <div class="sidebar"></div> -->

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul
        class="nav nav-pills nav-sidebar flex-column"
        data-widget="treeview"
        role="menu"
        data-accordion="false"
      >
      <li class="nav-item">
              <router-link class="nav-link" to="/">
                <i class="fas fas-w  fa-cash-register pr-2"></i>
                <p>Dashboard  <span class="right badge badge-danger">+</span></p></router-link
              >
            </li>

        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item menu-is-opening menu-open">
          <a href="#" class="nav-link bg-orange text-light">
            <i class="nav-icon fas fa-money-check-alt icono-tit"></i>
            <p>
              Remate o Subastas
              <i
                class="right fas fas-w fa-angle-left"
                style="color: #ffffff !important"
              ></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="display: block">
            <li class="nav-item">
              <router-link class="nav-link" to="/jornadas">
                <i class="fas fas-w  fa-cash-register pr-2"></i>
                <p>Remate en Vivo</p></router-link
              >
              <!--<a href="#" class="nav-link">
                                       
                                    </a>-->
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/orders-purchase">
                <i class="fas fas-w  fa-file-invoice pr-2"></i>
                <p>Apuestas Entre Tercios</p></router-link

                
              >
            </li>

            <li class="nav-item">
              <router-link class="nav-link" to="/providers">
                <i class="fas fas-w  fa-user-friends pr-2"></i>
                <p>Ganadores </p></router-link
              >
              <!-- <a href=" #" class="nav-link">
                                       
                                    </a>-->
            </li>
          </ul>
        </li>
      </ul>

      <ul
        class="nav nav-pills nav-sidebar flex-column"
        data-widget="treeview"
        role="menu"
        data-accordion="false"
      >

      <ul
        class="nav nav-pills nav-sidebar flex-column"
        data-widget="treeview"
        role="menu"
        data-accordion="false"
      >

      </ul>


      <!-- Inicia el Listado del Menú de Registro -->
      <ul
        class="nav nav-pills nav-sidebar flex-column"
        data-widget="treeview"
        role="menu"
        data-accordion="false"
      >
        <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->

        <li class="nav-item menu-is-opening menu-open">
          <a href="#" class="nav-link bg-orange text-light">
            <i class="fas fas-w  fa-users pr-2 icono-tit"></i>
            <p>
              Altas
              <i class="right fas fas-w  fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="display: block">
           <!-- <li class="nav-item">
              <router-link class="nav-link" to="/listado-usuarios">
                <i class="fas fas-w  fa-user pr-2"></i>
                <p>Empleados</p></router-link
              >
            </li> -->

             <li class="nav-item">
              <router-link class="nav-link" to="/users">
                <i class="fas fas-w fa-users pr-2"></i>
                <p>Clientes</p></router-link
              >
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/user/bank">
                <i class="fas fas-w fa-users pr-2"></i>
                <p>Bancos-Afiliados</p></router-link
              >
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/posos">
                <i class="fas fas-w  fa-file-invoice pr-2"></i>
                <p>Retiros o Posos</p></router-link

                
              >
            </li>

          </ul>
        </li>
      </ul>

      <!-- Termina el Listado del Menú de Registro -->

      

         <ul
          class="nav nav-pills nav-sidebar flex-column"
          data-widget="treeview"
          role="menu"
          data-accordion="false"
        >
          <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
          <li class="nav-item menu-is-opening menu-open">
            <a href="#" class="nav-link bg-orange text-light">
              <i class="fas fas-w  fa-boxes pr-2 icono-tit"></i>
              <p>
                Configuracion
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: block">
              <li class="nav-item">
              <router-link class="nav-link" to="/hipodromos">
                <i class="fas fas-w  fa-user pr-2"></i>
                <p>
                  Hipodromos
                  <span class="right badge badge-danger">+</span>
                </p>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/currency">
                <i class="fas fa-money-bill-wave pr-2"></i>
                <p>
                  Monedas
                  <span class="right badge badge-danger">+</span>
                </p>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/payment-methods">
                <i class="fas fa-money-check-alt pr-2"></i>
                <p>
                  Métodos de pago
                </p>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/ponles">
                <i class="fas fas-w  fa-water pr-2"></i>
                <p>Ponles</p></router-link
              >
              <!--<a href=" #" class="nav-link">
                                        
                                        <p>Condiciones</p>
                                    </a>-->
            </li>
          <li class="nav-item">
              <router-link class="nav-link" to="/suggestions">
                <i class="fas fas-w  fa-water pr-2"></i>
                <p>Sugerencias o Reglamos</p></router-link
              >
              <!--<a href=" #" class="nav-link">
                                        
                                        <p>Condiciones</p>
                                    </a>-->
            </li>
             
            </ul>
          </li>
        </ul>

      </ul>
    </nav>
  </aside>
</template>
<template>
  <div>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"
            ><i class="fas fa-bars"></i
          ></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell mr-3"></i>
            <span class="badge badge-warning navbar-badge">15</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer"
              >See All Notifications</a
            >
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <span>{{ user ? user.name : "Usuario de prueba" }}</span>
            <i class="fa fa-sort-desc"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item" @click.prevent="logout">
              <i class="fa fa-sign-out"></i>
              <span class="float-right text-muted text-sm">
                Cerrar Session</span
              >
            </a>
          </div>
        </li>
      </ul>
    </nav>

    
    <!-- /.navbar -->
    <sidebar></sidebar>

    <!-- Content Wrapper. Contains page content -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <transition mode="out-in">
            <router-view :key="$route.fullPath" />
          </transition>
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>

    <!-- Main Footer -->
    <footer-layout></footer-layout>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
import sidebar from "./components/sidebar";
import search from "./components/search.vue";
import footerLayout from "./components/footer";
export default {
  name: "MainLayout",
  components: {
    sidebar,
    search,
    footerLayout,
  },
  data() {
    return {};
  },
  computed: mapGetters({
    user: "auth/user",
  }),
  methods: {
    async logout() {
      // Log out the user.
      await this.$store.dispatch("auth/logout");
      // Redirect to login.
      this.$router.push({ name: "login" });
    },
  },
};
</script>
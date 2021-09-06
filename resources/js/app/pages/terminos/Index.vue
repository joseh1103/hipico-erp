<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Terminos Condiciones</h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Terminos</li>
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
      <div class="col-lg-12 col-12">
        <tinymce id="d1" v-model="data"></tinymce>
      </div>


      <!-- ./col -->
    </div>
    <!-- /.row (main row) -->
    <!-- /.content -->
  </div>
</template>
<script>
import { mapState } from "vuex";
export default {
  middleware: "auth",
  components: {},
  data() {
    return {
      data : ''
    };
  },
  computed: {
    ...mapState({
    }),
  },
  methods: {
  },
  mounted() {
  },
};
</script>

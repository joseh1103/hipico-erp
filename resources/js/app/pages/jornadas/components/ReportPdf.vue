<template>
  <!-- inpud addon -->
  <div>
    <div class="text-center">
      <div class="spinner-border" v-show="loadingPdf" role="status">
        <span class="sr-only">Loading...</span>
      </div>
   

      <pdf v-show="!loadingPdf"
            v-for="i in numPages"
            :key="i"
            :src="src"
            :page="i"
            ref="myPdfComponent"
          ></pdf>
      </div>
   </div>
  <!-- /.card -->
</template>
<script>
import pdf from "vue-pdf";
export default {
  props: {
    report: Boolean,
    jornada_id: Array
  },
  components: {
    pdf,
  },
  data() {
    return {
      loadingPdf: false,
      src: null,
      numPages: undefined,
    };
  },
  watch: {
    report(obj) {
      if (obj) {
        this.pdf();
      }
    },
  },
  methods: {
    async pdf() {
      this.loadingPdf = true;
      const jornada_id = this.jornada_id ? this.arrayIdJornada() : this.$route.params.id;
      const urlPDF = this.jornada_id ? '/api/reporte-all-jornada-pdf/' : '/api/reporte-pdf/';
      var pdfDocument = pdf.createLoadingTask(
        `${urlPDF}${jornada_id}`
      );
      this.src = pdfDocument;
      this.src.promise.then((pdf) => {
        this.numPages = pdf.numPages;
        this.loadingPdf = false;
      });
    },
    arrayIdJornada() {
      let array_id = '';
      this.jornada_id.map((items) => {
        array_id += items.id+',';
      });
      return array_id;

    }
  },
};
</script>
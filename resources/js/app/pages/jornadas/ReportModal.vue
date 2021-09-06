<template>
  <div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="pdfModal"
      ref="reporte"
      tabindex="-1"
      aria-labelledby="pdfModalLabel"
      aria-hidden="true"
      role="dialog"
    >
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header bg-orange">
              
            <h5 class="modal-title text-light" id="pdfModalLabel">
              Reporte - {{ jornada ? jornada.name : 'Reporte General' }} {{ jornada ? jornada.date : null }}</h5>
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
              <ReportPdf :report="report" :jornada_id="jornada_id"
              ></ReportPdf>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import ReportPdf from './components/ReportPdf'
export default {
  components: {
    ReportPdf
  },
  props: {
    jornada: Object,
    report: Boolean,
    getPdf: Function,
    jornada_id: Array
  },
  data() {
    return {
    };
  },
  methods: {
    closeModal() {
      this.getPdf(false);
    }
  },
  mounted() {
    $(this.$refs.reporte).on("hidden.bs.modal", this.closeModal)
  }
};
</script>

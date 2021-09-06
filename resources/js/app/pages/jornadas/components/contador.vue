<template>
    <div v-if="seconds">Tiempo:{{ countdown }}</div>
</template>

<script>
import * as moment from "moment";
export default {
  name: "CountDown",
  props: {
    timeSubasta: Object,
  },
  data() {
    return {
      countdown: null,
      expires_in: null,
      interval: null,
      seconds: null
    };
  },
  destroyed() {
    clearInterval(this.interval);
  },
  watch: {
    timeSubasta() {
     this.setIni(this.timeSubasta.data.erp_time);
    },
  },
  methods: {
      async setIni(seg) {
        this.seconds = seg;
        this.countdown = moment.utc(this.seconds).format("HH:mm:ss");
        this.expires_in = this.seconds;
        this._setInterval();
      },
    _setInterval () {
      this.interval = setInterval(() => {
        if (this.expires_in === 0) {
          clearInterval(this.interval);
        } else {
          this.expires_in -= 1;
          this.countdown = moment
            .utc(this.expires_in * 1000)
            .subtract(1, "seconds")
            .format("HH:mm:ss");
        }
      }, 1000);
    },
  },
};
</script>
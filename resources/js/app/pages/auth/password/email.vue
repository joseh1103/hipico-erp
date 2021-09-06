<template>
    <div class="h-screen flex w-full bg-img">
        <div class="vx-col w-4/5 sm:w-4/5 md:w-3/5 lg:w-3/4 xl:w-3/5 mx-auto self-center">
         <form class="mt-8" @submit.prevent="send" @keydown="form.onKeydown($event)">
            <vx-card>
                <div slot="no-body" class="full-page-bg-color">
                    <div class="vx-row">
                        <div class="vx-col hidden sm:hidden md:hidden lg:block lg:w-1/2 mx-auto self-center">
                            <img src="images/pages/forgot-password.png" alt="login" class="mx-auto">
                        </div>
                        <div class="vx-col sm:w-full md:w-full lg:w-1/2 mx-auto self-center d-theme-dark-bg">
                            <div class="p-8">
                                <div class="vx-card__title mb-8">
                                    <h4 class="mb-4">Recover your password</h4>
                                    <p>Please enter your email address and we'll send you instructions on how to reset your password.</p>
                                </div>
                                <vs-input type="email" label-placeholder="Email" v-model="form.email" class="w-full mb-8" />
                                <vs-button type="border" :to="{ name: 'login' }" class="px-4 w-full md:w-auto">Back To Login</vs-button>
                                <vs-button @click.prevent="send" class="float-right px-4 w-full md:w-auto mt-3 mb-8 md:mt-0 md:mb-0">Recover Password</vs-button>
                            </div>
                        </div>
                    </div>
                </div>
            </vx-card>
         </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import Form from 'vform'

export default {
  middleware: 'guest',
  layout: 'basic',
  metaInfo () {
    return { title: this.$t('reset_password') }
  },

  data: () => ({
    status: '',
    form: new Form({
      email: ''
    })
  }),

  methods: {
    async send () {
      axios.get('/sanctum/csrf-cookie').then(async response => {
          const { data } = await this.form.post('/password/email').catch((err) => {
            this.$vs.notify({ title: err.response.data.error, text: err.response.data.message,
            color:'warning', iconPack: 'feather', icon:'icon-alert-circle'})
          })
          this.status = data.status
          this.form.reset()
      });
      
    }
  }
}
</script>

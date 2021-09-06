<template>
 <main class="py-4">
	<section class="h-100 my-login-page">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="/img/logo.png" alt="logo">
					</div>


						<div class="card fat card-bg-login">
							<h2 class="card-title center-title">Inicia sesión</h2>
						<div class="card-body card-body-uno">
							<form method="POST" class="my-login-validation" novalidate="">


								  <div class="form-group float-left">
									    <label for="email">Correo</label>
                                    <input id="email" type="email" 
                                    v-model="form.email"
                                    class="form-control" name="email" value="" required autofocus>
                                    <div class="invalid-feedback">
                                        Email is invalid
                                    </div>  

                                   </div>

								    <div class="form-group">
										  <label for="password">Contraseña</label>
                                        
                                      
                                   
                                    <input id="password" type="password" 
                                    v-model="form.password"
                                    class="form-control" name="password" required data-eye>
                                    <div class="invalid-feedback">
                                        Password is required
                                    </div> 


									</div>

									<div class="form-group">
										 <div class="custom-checkbox custom-control">
                                        <input type="checkbox" name="remember" id="remember" class="custom-control-input">
                                        <label for="remember" class="custom-control-label">Recuérdame</label>
                                    </div> 


									  <div class="form-group m-0" style="margin-top:15px !important;">
									<button type="submit" 
									
                                     @click.prevent="login"
									 :disabled="loading"
                                      class="btn btn-primary btn-block">
                                     Iniciar sesión
                                    </button> 

									

									
                                </div>


									</div>



							</form>
						  
						</div>
					</div>



				
					<div class="footer">
						Copyright &copy; 2021 &mdash; Hipico 2020 Todos los derechos reservados. 
					</div>
					
				</div>
			</div>
		</div>
	</section>


 </main>
</template>

<script>
import Form from "vform";
import { mapState } from "vuex";

export default {
  middleware: "guest",
  layout: "basic",
  data: () => ({
    form: new Form({
      email: "",
      password: "",
      checkbox_remember_me: false,
    }),
	loading: false
  }),
  computed: {
	...mapState({
    user: state => state.auth.user
  	}),
    validateForm() {
      return (
        !this.errors.any() &&
        this.form.email !== "" &&
        this.form.password !== ""
      );
    },
  },

  methods: {
	async login () {
	this.loading = true
	let me = this;
      // Submit the form.
      await this.$store.dispatch('auth/login', this.form)
	  await this.$store.dispatch('auth/fetchUser')
      // Fetch the user.
	  if (this.user && this.user.role_id == 1) { 
		  this.$router.push({ name: 'home' })
	  }else {
		me.$toastr.warning("Usuario No autorizado", "Error!");
		await this.$store.dispatch('auth/logout')
	  }
	  this.loading = false;
    }
  },
};
</script>



<style>
    body,
		html {
			margin: 0;
			padding: 0;
			height: 100%;
            background:#F8F8F8 !important;

		}
		.user_card {
			height: auto !important;
			width: auto !important;
			margin-top: auto;
			margin-bottom: auto;
			background: #f39c12;
			position: relative;
			display: flex;
			justify-content: center;
			flex-direction: column;
			padding: 10px;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			-webkit-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			-moz-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			border-radius: 5px;

		}
		.login_container {
			padding: 0 2rem;
		}
		.input_user,
		.input_pass:focus {
			box-shadow: none !important;
			outline: 0px !important;
		}
		.footer {
			color: #EB7D25 !important
		}
</style>
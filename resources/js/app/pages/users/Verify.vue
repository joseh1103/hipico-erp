<template>
    <table style="background-color:#e4e6e8; border-collapse:collapse; border:0px; height:100%; margin:0; padding:0; width:100%">
	<tbody>
		<tr>
			<td style="background-color:#e4e6e8; height:100%; width:auto!important"> </td>
			<td> </td>
			<td style="height:100%; width:600px!important">
			<table  id="t2" style="background-color:#e4e6e8; border-collapse:collapse; border:0px; max-width:600px!important; width:100%">
				<tbody>
					<tr>
						<td>
						<div style="width: 100%; height: 40px; background-color: #e4e6e8;"> </div>
						</td>
					</tr>
					<tr>
						<td>
						<table style="background-color:#e4e6e8; border-collapse:collapse; border:0px">
							<tbody>
								<tr>
									<td>
									<div style="width:20px;"> </div>
									</td>
									<td style="background-color:white;border-radius:20px">
									<table style="border-collapse:collapse; min-width:100%; width:100%">
										<tbody>
											<tr>
												<td>
												<table style="border-collapse:collapse; border:0px; min-width:100%; width:100%">
													<tbody>
														<tr>
															<td style="text-align:center;"><img src="/img/logo.png" width="150px" height="120px" style="-ms-interpolation-mode:bicubic; border:0; display:inline !important; height:auto; max-width:1920px; outline:none; padding-bottom:0; text-align:center; text-decoration:none; vertical-align:bottom;border-radius:20px 20px 0px 0px" /></td>
														</tr>
													</tbody>
												</table>
												</td>
											</tr>
										</tbody>
									</table> 
									
	
									<table style="background-color:#ffffff; border-collapse:collapse; border:0px; width:600px">
										<tbody>
											<tr>
												<td>
												<table style="border-collapse:collapse; width:600px">
													<tbody>
	
													</tbody>
												</table>
												</td>
											</tr>
										</tbody>
									</table>

									<div style="width:500px; margin: 0 auto; padding-bottom:20px; text-align:left; color:#454546; font-family:raleway,roboto,open sans,helvetica,arial,sans-serif; font-size:13px">
									<p> </p>
									<p>Estimado Sr.(a) <strong>{{ this.$route.params.user }}</strong>,<br />
									Lo invitamos a conocer una nueva experiencia en hipico 2020 a través de nuestra nueva e innovadora aplicación móvil.</p>

									<p style="text-align:justify"><strong>Descargala ya!</strong><br />
									Usa los siguientes enlaces:</p>
		
									<p style="text-align:center">
									   <a href="https://play.google.com/store/apps/details?id=com.ovnicom.ovnicom" style="display:inline-block; margin:0px 10px;">
									            <img src="https://gallery.mailchimp.com/e1bc316e3afc1c12836c12f41/images/f46bbae1-909e-4396-aeab-739676ae94bc.jpg" style="border:0; display:block; height:auto; outline:none; text-decoration:none; width:120px" /></a></p>

									<p style="text-align:justify">Los beneficios de contar con la Aplicación Móvil son los siguientes:</p>
									<ul>
                                    	<li style="text-align: left;"><span style="font-size:12px"><em>Chat en vivo con Atención al Cliente a través de <strong>WhatsApp</strong>.</em></span></li>
                                    	<li style="text-align: left;"><span style="font-size:12px"><em>Remate o subasta en Vivo.</em></span></li>
                                    	<li style="text-align: left;"><span style="font-size:12px"><em>Información de Saldos.</em></span></li>
                                    	<li style="text-align: left;"><span style="font-size:12px"><em>Pagos en lineas con Tarjetas de Crédito <strong>Visa</strong>/<strong>MasterCard</strong>.</em></span></li>
                                    	<li style="text-align: left;"><span style="font-size:12px"><em>Acceso directo a nuestro Departamento de Ventas.</em></span></li>
                                    	<li style="text-align: left;"><span style="font-size:12px"><em>Acceso directo a nuestro Departamento de Soporte Técnico.</em></span></li>
                                    </ul>
                                    <p style="text-align:justify">Para comenzar a disfrutar de todos estos beneficios que hemos creado para usted, lo invitamos a activar su cuenta a través del siguiente enlace. <br /> </p>
                                    
                                    
                                    <p style="text-align:center"><a style="background-color:#ff5900; border:ff5900;color:white; display:inline-block;padding:0.4em 2.2em;font-size:16px; text-decoration:none;width:auto;margin-top:12px;border-radius:5px 5px 5px 5px" @click.prevent="verify">Activa tu Cuenta</a></p>
                                    
                                    <p style="text-align:justify">Igualmente te informamos que tu nombre de usuario es <strong>{{ this.$route.params.user }}</strong></p><br />
                                    
                                    <p style="text-align:justify">Para cualquier información adicional, comuníquese con nuestro equipo de Atención al Cliente a través de los siguientes canales.</p>
                                    <p style="text-align:justify"><strong>Correo: </strong>support@hipico2020.com</p>
                                    <p style="text-align:justify"><strong>Teléfonos: </strong>+58 412 8763843 y +58 414-1059565</p><br />
                                    <hr style="background-color: #cccccc">
                                    <p style="text-align:center;font-size:16px"><strong>¡Hipico 2020!</strong></p>
                                    
                    				</div>
								    </td>
									<td>
									<div style="width:20px;"> </div>
									</td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
					<tr>
						<td>
						</td>
					</tr>
					<tr>
						<td>
						<div style="width: 100%; height: 20px; background-color: #e4e6e8;"> </div>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
			<td> </td>
			<td style="height:100%; width:auto!important"> </td>
		</tr>
	</tbody>
</table>
</template>

<script>
export default {
  middleware: 'guest',
  layout: 'basic',
  data: () => ({
  }),
  methods: {
    async verify() {
      let me = this;
      const { data } = await this.$store.dispatch("auth/verify", {
        params: { id: this.$route.params.id},
      });
      if (data.error) {
          me.$toastr.warning(data.error, "Error!");
      } else {
          me.$toastr.success(data.message, "Guardado");
      }
        window.location.href = 'https://www.hipico2020.com';
    },
  }
}
</script>
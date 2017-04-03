<?php get_header(); ?>
<?php

	$participacion_activa = get_field("desactivar_participacion","option");

	if( $participacion_activa==1 ) {
		//echo "Participar en los eventos se encuentra temporalmente desactivado";
		$estado = 2;
	}else{

		$email  = sanitize_text_field(@$_GET["email"]);
		$evento = sanitize_text_field(@$_GET["evento"]);
		$estado = -1;

		if( $email!="" && $evento!="") {
			if( estaInscrito($email,$evento)==0 ) {
				$estado = 0;
			}else{
				//echo "ya esta inscrito en el evento";
				$estado = 1;
			}
	   }else{
		   	//echo "No puedes inscribitre al evento";
		   	$estado = 3;
	   }

	}	

$posts = get_posts(array(
	'name'      => $evento,
	'post_type' => 'eventos'
));

$evento_activo = 1;	
$status = 0;
if($posts) {
	foreach($posts as $post) {
		$nombre_evento = $post->post_title;
		$banner = get_field("imagen");

		$desactivar_evento = get_field('desactivar_evento');
		if( $desactivar_evento==1 ) {
			//echo "true" inactivo;
			$evento_activo = 0;
		}	
	}
	$status = 1;
}

?>
<section>
		<div class="container">
			<div class="col-md-12">
				<?php if($status==1){ ?>
				<div class="row">
					<div class="col-md-12">
						<img src="<?php echo $banner; ?>"/>
					</div>
				</div>
				<?php if( $estado==2 || $evento_activo==0 ){ ?>
				<div class="row">
					<div class="col-md-12">
						<h3 class="titulo"><?php echo strtoupper($nombre_evento); ?></h3>
						<div class="caja-asistir">
							<h4 class="desea-asistir">No disponibles las inscripciones a este evento.</h4>
						</div>
					</div>
				</div>					
				<?php }else{ ?>
				<div class="row">
					<div class="col-md-12">
						<h3 class="titulo"><?php echo strtoupper($nombre_evento); ?></h3>
						<div class="caja-asistir">
							<h4 class="desea-asistir">¿Deseas asistir al Evento?</h4>
							<button class="btn-asistir btn-enviar">Sí, asistiré al evento</button>
						</div>
					</div>
				</div>	
				<?php } ?>
				<?php }else{ ?>
				<div class="row">
					<div class="col-md-12">
						<img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/banner-default.png"/>
					</div>
				</div>				
				<div class="row">
					<div class="col-md-12">
						<div class="caja-asistir">
							<h4 class="desea-asistir">No disponibles las inscripciones a este evento.</h4>
						</div>
					</div>
				</div>					
				<?php }?>
			
				<div class="alert alert-warning alert-dismissible" style="display: none;" id="gracias-inscrito" role="alert">
					<p>Hemos recibido tu solicitud de forma correcta.</p>
				</div>
				<div class="alert alert-warning alert-dismissible" <?php if( $estado==1 ) { echo 'style="display: block;"'; }else{ echo 'style="display: none;"'; } ?> id="gracias-ya-inscrito" role="alert">					
					<p>Ya ha sido enviada tu solicitud al evento.</p>
				</div>		
				<div class="alert alert-danger alert-dismissible" <?php if( $estado==3 ) { echo 'style="display: block;"'; }else{ echo 'style="display: none;"'; } ?> id="gracias-no-mutual" role="alert">
					<p>No puedes solicitar acceso a este evento.</p>
				</div>
			</div>
		</div>

		<form method="post" id="form-eventos" style="display: none;" >
		  <input type="text" name="email" placeholder="Email*" value="<?php echo $email;?>" >
		  <input type="hidden" name="evento" value="<?php echo $evento;?>" >
		  <input type="hidden" name="action" value="guardarInscripcion" >
		  <!--input type="button" class="btn-enviar" name="btn_enviar" value="Quiero ir!" -->
		</form>		

	</section>

<?php

get_footer();


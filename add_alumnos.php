<?php
function add_alumno(){
	require_once (dirname( __FILE__ ) .'/functions.php'       );
	//require_once (dirname( __FILE__ ) .'/../css/extension_styles.php');
	//extension_files();
	global $wpdb;
	$tabla_alumno = $wpdb->prefix . 'alumno';
	ob_start();
	if (!empty($_POST)
		AND $_POST['nombre'] != ''
		AND $_POST['carrera'] != ''
		AND $_POST['grupo'] != ''
	) {
		$nombre =  sanitize_text_field($_POST['nombre']);
		$grupo = (int)getIdGrupo(sanitize_text_field($_POST['grupo']));
		$wpdb ->insert(
					$tabla_alumno, 
					array(
						'nombre' => $nombre,
						'id_grupo' => $grupo,
						'parcial1' => 0,
						'parcial2' => 0,
 						)
					);
		echo "<div id='form-add'>";
		echo "<p class='exito'>Alumno Agregado con éxito</p>";
		unset($_POST);
		echo "<form clas='form-add' action='".get_the_permalink()."' method='post'><input type='submit' value='Agregar otro Alumno'></form>";
		echo "</div>";

	}
	else if (!empty($_POST)
		AND $_POST['nombre'] == ''
		AND $_POST['carrera'] != ''
		AND $_POST['grupo'] == ''
	) {
		$carr=$_POST['carrera'];
		?>
		<div id="div_form">
			<form class="form-add" action="<?php get_the_permalink(); ?>" method="post" >
				<label class="text-small-uppercase" for="Nombre">Nombre: </label><input class="text-body" type="text" name="nombre" required="required" />
				<label class="text-small-uppercase" for="carrera">Grupo: </label><select class="text-body" name="grupo"><?php getGrupo($carr);?></select>
				<input type="hidden" name="carrera" value="<?php echo $_POST['carrera']; ?>">
				<br /><input class="text-body" type="submit" name="submit" value="Agregar alumno">
			</form>
		</div>
		<?php
		
	}else{
		//Formulario para Agregar alumnos
		?>
		<div id="div_form">
			<form class="form-add" action="<?php get_the_permalink(); ?>" method="post" >
				<label class="text-small-uppercase" for="carrera">Elige la Carrera: </label><select class="text-body" name="carrera"><?php getCarrera();?></select>
				<input type="hidden" name="grupo" value="">
				<input type="hidden" name="nombre" value="">
				<br /><input class="text-body" type="submit" name="submit" value="Entrar">
			</form>
		</div>
		<?php
		
	}
	return ob_get_clean();
}

?>
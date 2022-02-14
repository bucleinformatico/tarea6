<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<?php
		require("gestionLibros.php");

		/*Primero con el objeto $gestionLibros llamamos al método conexión para conectarnos a la base de datos. Pasamos como argumento al método(en caso de necesitarlo) el valor introducido por el usuario usando Usamos $_POST[ ]. Una vez devuelto el array para los metodos de consulta o true o false para los métodos de borrado, nos desconectamos de la base de datos con el método desconexion. A los metodos que devuelven un array con la información pedida, se les aplica un for each, para recorerlos y poder imprimir la información en pantalla. */ 

		$eliminaAutor =$_POST["eliminaAutor"];
		$gestionLibros = new gestionLibros (); 
		$gestionLibros->conexion();
		$gestionLibros->borrarAutor($eliminaAutor);
		$gestionLibros->desconexion();
	?>
	<script type="text/javascript">
		//volveremos a la pagina principal
		location.replace("tarea.php");
	</script>

</body>
</html>
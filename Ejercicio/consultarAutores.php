<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<?php 

		/*Primero con el objeto $gestionLibros llamamos al método conexión para conectarnos a la base de datos. Pasamos como argumento al método(en caso de necesitarlo) el valor introducido por el usuario usando Usamos $_POST[ ]. Una vez devuelto el array para los metodos de consulta o true o false para los métodos de borrado, nos desconectamos de la base de datos con el método desconexion. A los metodos que devuelven un array con la información pedida, se les aplica un for each, para recorerlos y poder imprimir la información en pantalla. */ 

		require("gestionLibros.php");

		$buscarAutor =$_POST["buscarAutor"];
		$gestionLibros = new gestionLibros ();
		$gestionLibros->conexion();
		$array_autor=$gestionLibros->consultarAutores($buscarAutor);
		$gestionLibros->desconexion();
		if(!is_null($array_autor)){
			echo "<h2>Tabla Autor</h2>";
			echo "<table>";
				echo "<tr>";
				echo "<th>Id Autor</th>";
				echo "<th>Nombre</th>";
				echo "<th>Apellido</th>";
				echo "<th>Nacionalidad</th>";
			echo "</tr>";
			foreach($array_autor as $fila){
				echo "<tr>";
				echo "<td>" .$fila['AutorID']."</td>";
				echo "<td>" .$fila['nombre']."</td>";
				echo "<td>" .$fila['apellido']."</td>";
				echo "<td>" .$fila['nacionalidad']."</td>";
				echo "</tr>";
			}
		echo "</table>";

		}else{
			echo "Ocurrió un error.";
		}
	?>
	<script type="text/javascript">
		//volveremos a la pagina principal
		function volver(){
			location.replace("tarea.php");
		}
	</script>
	<!--El boton llamará a la función volver-->
	<button onclick="volver()">Volver</button>

</body>
</html>
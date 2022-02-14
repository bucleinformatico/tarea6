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
		$buscarLibro =$_POST["buscarLibro"];
		$gestionLibros = new gestionLibros ();
		$gestionLibros->conexion();
		$array_libros=$gestionLibros->consultarDatosLibro($buscarLibro);
		$gestionLibros->desconexion();
		if(!is_null($array_libros)){
			echo "<h2>Tabla Libros</h2>";
			echo "<table>";
			echo "<tr>";
				echo "<th>Id Libro</th>";
				echo "<th>Título</th>";
				echo "<th>Fecha Publicación</th>";
				echo "<th>Id Autor</th>";
			echo "</tr>";
			foreach($array_libros as $fila){
				echo "<tr>";
				echo "<td>" .$fila['LibroID']."</td>";
				echo "<td>" .$fila['titulo']."</td>";
				echo "<td>" .$fila['f_publicacion']."</td>";
				echo "<td>" .$fila['AutorID']."</td>";
				echo "</tr>";
			}
			echo "</table>";
		}else{
			echo "Ocurrió un error.";
		}
	?>
	<script type="text/javascript">
		function volver(){
			//volveremos a la pagina principal
			location.replace("tarea.php");
		}

	</script>
	<!--El boton llamará a la función volver-->
	<button onclick="volver()">Volver</button>

</body>
</html>

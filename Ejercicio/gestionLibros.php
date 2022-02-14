<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="tarea.css"/>
</head>
<body>
	<?php 
	/**
	*La clase se encarga de gestionar lo métodos para el manejo de la aplicación web.
	*@author Rubén de Diego <rubendediegogomez@gmail.com> 
	*@version 1.0.0
	**/
		class gestionLibros{
	/**
	*Con este método estableceremos la conexión a la base de datos.  
	*@param string $BBDD. Es el nombre de la base de datos
	*@param string $usuario. Guarda el nombre de usuario.
	*@param string $pass. Contraseña del usuario
	*@param string $loc. Localización de la base de datos.
	**/
			public function conexion(){

				//Datos xampp
				$BBDD="Libros";
				$usuario="root";
				$pass="";
				$loc="localhost";

				//Datos host gratuito
				/*$BBDD="id15245253_libros";
				$usuario="id15245253_ruben";
				$pass="123456@bcd€F";
				$loc="localhost";	*/
				$resultado="";		
				@$this->mysqli=new mysqli($loc, $usuario, $pass, $BBDD);
				if ($this->mysqli->connect_errno)
				{	
					echo "Error de conexión con la BBDD: $BBDD. " . $this->mysqli->connect_error;
					die("Pruebe de nuevo más tarde.");
					return $resultado= null;
				}else{
					$resultado="ok";
				}
				return $resultado;
			}
	/**
	*@author Rubén de Diego Gómez
	*Con este método estableceremos la desconexión a la base de datos.  
	**/
			public function desconexion(){
				$this->mysqli->close();
			}
			/**
			*Busca los datos del libro cuyo id se le pasa por el parametro $a. Si está vacio no aplica el filtro para devolver todos los resultados.
			*@param int $a LibroId pasado por el usuario.
			*@return array con los resultados de la consulta, si hay un error devuelve NULL
			**/

			public function consultarDatosLibro($a){
				//Cuando no se pase valor, es decir este vacio, no habrá filtro
				if ($a==""){
					$sql = "SELECT LibroID,titulo,f_publicacion,AutorID FROM Libro";
				}else{
					$sql = "SELECT LibroID,titulo,f_publicacion,AutorID FROM Libro where LibroID like '$a'";
				}
				//Guardamos en $resultado el resultado de la consulta
				$resultado=$this->mysqli->query($sql);
				if(!$this->mysqli->error){
					//le aplicamos al resultado de la ejecución fetch_all para guardar la información devuelta en un array asociativo.
					$libros=$resultado->fetch_all(MYSQLI_ASSOC);
				} else{
					$libros=NULL;
				}
			
				return $libros;

			}
			/**
			*Busca los datos del autor cuyo id se le pasa por el parametro $a. Si está vacio no aplica el filtro para devolver todos los resultados.
			*@param int $a AutorId pasado por el usuario.
			*@return array con los resultados de la consulta, si hay un error devuelve NULL
			**/
			public function consultarAutores($a){
			//Cuando no se pase valor, es decir este vacio, no habrá filtro
				if ($a==""){
					$sql = "SELECT AutorID,nombre,apellido,nacionalidad FROM Autor";
				}else{
					$sql = "SELECT AutorID,nombre,apellido,nacionalidad FROM Autor where AutorID like '$a'";
				}
				//Guardamos en $resultado el resultado de la consulta
				$resultado=$this->mysqli->query($sql);
				if(!$this->mysqli->error){
					//le aplicamos al resultado de la ejecución fetch_all para guardar la información devuelta en un array asociativo.
					$autor=$resultado->fetch_all(MYSQLI_ASSOC);
				} else {
					$autor=NULL;
				}
				return $autor;
			}
			/**
			*Busca los datos del autor y sus libros cuyo id se le pasa por el parametro $a. Si está vacio no aplica el filtro para devolver todos los resultados.
			*@param int $a AutorId pasado por el usuario.
			*@return array con los resultados de la consulta, si hay un error devuelve NULL
			**/
			public function consultarLibros($a){
				//Cuando no se pase valor, es decir este vacio, no habrá filtro
				if ($a==""){
					$sql = "SELECT a.AutorID, a.nombre, a.apellido,l.LibroID, l.titulo FROM Autor a join Libro l on (a.AutorID = l.AutorID)";
				}else{
					$sql = "SELECT a.AutorID, a.nombre, a.apellido,l.LibroID, l.titulo FROM Autor a join Libro l on (a.AutorID = l.AutorID) where a.AutorID like '$a'";
				}
				//Guardamos en $resultado el resultado de la consulta
				$resultado=$this->mysqli->query($sql);
				if(!$this->mysqli->error){
				//le aplicamos al resultado de la ejecución fetch_all para guardar la información devuelta en un array asociativo.
					$autorLibro=$resultado->fetch_all(MYSQLI_ASSOC);
				} else $autorLibro=NULL;

				return $autorLibro;
			}
			/**
			*Busca borra el libro cuyo id se le pasa por el parametro $a. Si está vacio no borrará ninguno.
			*@param int $a LibroId pasado por el usuario.
			*@return boolean true si no ha habido error, false si ha habido error.
			**/
			public function borrarLibro($a){
				$sql = "delete from Libro where LibroID like '$a'";
				$devuelve=TRUE;
				//Guardamos en $resultado el resultado de la consulta al ejecutarla
				$resultado=$this->mysqli->query($sql);
				if(!$this->mysqli->error){
					$devuelve=TRUE;
				}else{
					$devuelve=FALSE;
				}
  				return $devuelve;
			}
			/**
			*Busca y borra el autor junto a sus libros, por AutorID que se le pasa por el parametro. Si está vacio no borrará ninguno.
			*@param int $a LibroId pasado por el usuario.
			*@param int $comprobar contador para chequear que se cumple lo necesario para hacer el commit.
			*@return boolean true si no ha habido error, false si ha habido error.
			**/
			public function borrarAutor($AutorID){
				/* Deshabilitar autocommit */
				$this->mysqli->autocommit(FALSE);
				/*Aquí comienza la transacción*/
				$this->mysqli->begin_transaction();
				$sql1 = "delete from Libro where AutorID like '$AutorID'";
				/*borramos los libros del autor pasado por parametro $AutorId*/
				$this->mysqli->query($sql1);
				$comprobar=0;
				if(!$this->mysqli->error){
					$comprobar++;//si no hay error confirmamos la operación incrementado el valor.
				}
				$sql2 = "delete from Autor where AutorID like '$AutorID'";
				/* borramos el autor parado por parametro $AutorId*/
				$this->mysqli->query($sql2);
				if(!$this->mysqli->error){
					$comprobar++;//si no hay error confirmamos la operación incrementado el valor.
				}//si ninguna de las dos operaciones ha dado error será verdadero y $valdrá 2.
				if($comprobar==2){
					$devuelve=TRUE;
				}else{
					$devuelve=FALSE;
				}
				/* Comprobamos si las operaciones han salido bien o mal para confirmar o revertir la transacción */
				//si es verdadero las dos operacions han salido bien y hacemos un commit
				if ($devuelve){
					$this->mysqli->commit();
				}else{ //si es falso una de las dos operaciones o las dos han dado error, hacemos un rollback.
					$this->mysqli->rollback(); 
				}
				/* Activar nuevamente autocommit */
				$this->mysqli->autocommit(TRUE);
  				return $devuelve;
			}
	}	
?>

</body>
</html>
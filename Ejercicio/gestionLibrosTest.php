

<?php
//gestionLibrosTest.php

require_once( 'gestionLibros.php' );
use PHPUnit\Framework\TestCase;

class gestionLibrosTest extends TestCase
{
public function testConexionOK()
{
$o = new gestionLibros();

$resultado = $o->conexion();

$this->assertNotNull($resultado);
}


public function testConsultarAutores()
{
$esperado = array(["AutorID"=> "1", "nombre"=>"Isaac", "apellido"=>"Asimov", "nacionalidad"=>"Rusia"]);

$o = new gestionLibros();
$mysqli = $o->conexion();
$resultado = $o->consultarAutores("1");
$this->assertEquals($esperado, $resultado);
}

public function testConsultarLibros()
{
$esperado = array(["AutorID"=>"1","nombre"=>"Isaac","apellido"=>"Asimov","LibroID"=>"4", "titulo"=>"Un guijarro en el cielo"],
["AutorID"=>"1","nombre"=>"Isaac","apellido"=>"Asimov","LibroID"=>"5", "titulo"=> "Fundación"],
["AutorID"=>"1","nombre"=>"Isaac","apellido"=>"Asimov","LibroID"=>"6", "titulo"=> "Yo, robot"]);


$o = new gestionLibros();
$mysqli = $o->conexion();
$resultado = $o->consultarLibros("1");
$this->assertEquals($esperado, $resultado);
}

public function testConsultarDatosLibro()
{
$esperado = ["LibroID"=>"1", "titulo"=>"La Comunidad del Anillo", "f_publicacion"=>"29/07/1954", "AutorID"=>"0"];

$o = new gestionLibros();
$mysqli = $o->conexion();
$resultado = $o->consultarDatosLibro("1");
$this->assertEquals($esperado, $resultado);
}

public function testConsultarBorrarLibro()
{
$o = new gestionLibros();
$mysqli = $o->conexion();
//Borrar libro 2
$resultado = $o->borrarLibro(2);
$this->assertEquals(true, $resultado);
//Comprobar que el libro 2 ya no está
$resultado = $o->consultarDatosLibro(2);
$this->assertFalse($resultado);
}

public function testConsultarBorrarAutor()
{
$o = new gestionLibros();
$mysqli = $o->conexion();
//Borrar autor 2
$resultado = $o->borrarAutor(2);
$this->assertEquals(true, $resultado);
//Comprobar que el autor 2 ya no está
$resultado = $o->consultarAutores(2);
$this->assertNull($resultado);
//Comprobar que el autor 2 ya no tiene libros
$resultado = $o->consultarLibros(2);
$this->assertFalse($resultado);
}

}

?>
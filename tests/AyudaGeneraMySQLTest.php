<?php

use Ayuda\Genera; 
use Clase\DatabaseMySQL;
use Clase\GeneraConsultasMySQL;
use PHPUnit\Framework\TestCase;

class AyudaGeneraMySQLTest extends TestCase
{
    public function eliminarDatos($coneccion)
    {
        $coneccion->ejecutaConsultaDelete('DELETE FROM metodo_grupo');
        $coneccion->ejecutaConsultaDelete('DELETE FROM usuarios');
        $coneccion->ejecutaConsultaDelete('DELETE FROM grupos');
        $coneccion->ejecutaConsultaDelete('DELETE FROM metodos');
        $coneccion->ejecutaConsultaDelete('DELETE FROM menus');
    }
    /**
     * @test
     */
    public function menu()
    {
        $coneccion = new DatabaseMySQL();
        $generaConsultas = new GeneraConsultasMySQL($coneccion);
        $grupoId = 1;
        
        $this->eliminarDatos($coneccion);
        
        $insertMenus = "INSERT INTO menus (id,nombre,etiqueta,icono,activo) VALUES";
        $coneccion->ejecutaConsultaInsert("$insertMenus (1,'usuarios','USUARIOS','icono-usuarios',true) ");
        $coneccion->ejecutaConsultaInsert("$insertMenus (2,'metodos','METODOS','icono-metodos',true) ");
        
        $insertMetodos = "INSERT INTO metodos (id,nombre,etiqueta,accion,icono,menu_id,activo_menu,activo_accion,activo) VALUES";
        $coneccion->ejecutaConsultaInsert("$insertMetodos (1,'registrar','registrar','accion','icono',1,true,false,true)");
        $coneccion->ejecutaConsultaInsert("$insertMetodos (2,'lista','lista','accion','icono',1,true,false,true)");
        $coneccion->ejecutaConsultaInsert("$insertMetodos (3,'lista2','lista2','accion','icono',1,false,false,true)");
        $coneccion->ejecutaConsultaInsert("$insertMetodos (4,'lista3','lista3','accion','icono',1,true,false,false)");

        $coneccion->ejecutaConsultaInsert("$insertMetodos (5,'registrar','registrar','accion','icono',2,true,false,true)");
        $coneccion->ejecutaConsultaInsert("$insertMetodos (6,'lista','lista','accion','icono',2,true,false,true)");
        $coneccion->ejecutaConsultaInsert("$insertMetodos (7,'lista2','lista2','accion','icono',2,false,false,true)");
        $coneccion->ejecutaConsultaInsert("$insertMetodos (8,'lista3','lista3','accion','icono',2,true,false,false)");

        $coneccion->ejecutaConsultaInsert("INSERT INTO grupos (id,nombre,activo) VALUES (1,'administrador',true)");

        $insertMetodosGrupos = "INSERT INTO metodo_grupo (id,metodo_id,grupo_id,activo) VALUES";
        $coneccion->ejecutaConsultaInsert("$insertMetodosGrupos (1,1,$grupoId,true)");
        $coneccion->ejecutaConsultaInsert("$insertMetodosGrupos (2,2,$grupoId,true)");
        $coneccion->ejecutaConsultaInsert("$insertMetodosGrupos (3,3,$grupoId,true)");
        $coneccion->ejecutaConsultaInsert("$insertMetodosGrupos (4,4,$grupoId,true)");
        $coneccion->ejecutaConsultaInsert("$insertMetodosGrupos (5,5,$grupoId,true)");
        $coneccion->ejecutaConsultaInsert("$insertMetodosGrupos (6,6,$grupoId,true)");
        $coneccion->ejecutaConsultaInsert("$insertMetodosGrupos (7,7,$grupoId,true)");
        $coneccion->ejecutaConsultaInsert("$insertMetodosGrupos (8,8,$grupoId,true)");

        $menu = Genera::menu($coneccion, $generaConsultas, $grupoId);
        $this->assertIsArray($menu);

        $this->eliminarDatos($coneccion);
    }
}
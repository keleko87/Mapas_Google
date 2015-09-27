<?php

class Database{
	private static $db_server = "localhost";
	private static $db_user = "root";
	private static $db_password = "";
	private static $db_name = "mapas";
	
	private $con;
	private $result;
	private $numFilas;
	
	public function __construct(){
		$this->con = new mysqli(self::$db_server, self::$db_user, self::$db_password, self::$db_name);
	}
	
	public function disconnect(){
		$this->con->close();
	}
	
	public function executer($sql){
		$this->result = $this->con->query($sql);
		$this->numFilas = $this->con->affected_rows;
	}
	
	public function getNumFilas(){
		return $this->numFilas;
	}
	
	public function getResultados(){
		$resultados = array();
		for($i=0;$i<$this->numFilas;$i++){
			$resultados[] = $this->result->fetch_array();
		}
		return $resultados;
	}
        
        public function mostrarTipoLocales() {
                $this->executer("select distinct tipo from locales;");
                $listaTipos= array();
                $listaTipos = $this->getResultados();
                $this->disconnect();
                return $listaTipos;
            
        }
        
        public function mostrarLocales($tipo_local){
            $this->executer("select * from locales where tipo='$tipo_local';");
                $listaLocales = array();
                $listaLocales = $this->getResultados();
                $this->disconnect();
                return $listaLocales;
        }
        
}
?>
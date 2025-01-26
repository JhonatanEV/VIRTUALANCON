<?php 

class query {

	public function GetDdjj($id_cont){
		include 'conexion.php';
		$Query = $cnn->prepare('Select cuponera as ddjj From masiva.IMPRESION_HR2021 where codigo = ?');
		// $Query->setFetchMode(PDO::FETCH_ASSOC);
		$Query->execute([$id_cont]);
		$ddjj = $Query->fetchObject();
		if (!$ddjj) {
	    #No existe
	    echo "¡No existe DDJJ!";
	    exit();
		}
		return $ddjj;
	}

	public function GetHr($ddjj){
		include 'conexion.php';
		$year = date('Y');
		$Query = $cnn->prepare("exec [masiva].[sp_IMPRESION_hr] ?,?");
		$Query->execute([$ddjj,$year]);
		$HR = $Query->fetchAll(PDO::FETCH_OBJ);
		// print_r($HR); die();
		if (!$HR) {
	    #No existe
	    echo "¡No existe HR!";
	    exit();
		}
		return $HR;
	}

	public function GetHla($ddjj,$cocata){
		include 'conexion.php';
		$year = date('Y');
		$Query = $cnn->prepare("Exec [masiva].[sp_IMPRESION_hla] ?,?,?");
		$Query->execute([$ddjj,$cocata,$year]);
		$Hla = $Query->fetchAll(PDO::FETCH_OBJ);
		if (!$Hla) {
	    #No existe
	    echo "¡No existe Hla!";
	    exit();
		}
		return $Hla;
	}

	public function GetPU($ddjj,$cocata){
		include 'conexion.php';
		$year = date('Y');
		$Query = $cnn->prepare("Exec [masiva].[sp_impresion_pu] ?,?,?");
		$Query->execute([$ddjj,$cocata,$year]);
		$PU = $Query->fetchAll(PDO::FETCH_OBJ);
		if (!$PU) {
	    #No existe
	    echo "¡No existe PU!";
	    exit();
		}
		return $PU;
	}

	public function GetDetPU($ddjj,$cocata){
		include 'conexion.php';
		$year = date('Y');
		$Query = $cnn->prepare("Exec [masiva].[sp_IMPRESION_PU_detalle] ?,?,?");
		$Query->execute([$ddjj,$cocata,$year]);
		$PU = $Query->fetchAll(PDO::FETCH_OBJ);
		if (!$PU) {
	    #No existe
	    echo "¡No existe Det PU!";
	    exit();
		}
		return $PU;
	}

	public function GetHlp($ddjj){
		include 'conexion.php';
		$year = date('Y');
		$Query = $cnn->prepare("Exec [masiva].[sp_impresion_hlp] ?,?");
		$Query->execute([$ddjj,$year]);
		$HLP = $Query->fetchAll(PDO::FETCH_OBJ);
		if (!$HLP) {
	    #No existe
	    echo "¡No existe HLP!";
	    exit();
		}
		return $HLP;
	}

}

?>

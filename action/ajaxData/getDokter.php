<?php
require_once "../../lib/koneksi.php";
require_once "../../lib/olah_table.php";

$klinik_id = $_GET['klinik_id'];

try {
	$conn->beginTransaction();

	$queryDokter		= "SELECT * FROM dokter where klinik_id = :klinik_id and deleted_by is null";
	$resDokter			= $conn->prepare($queryDokter);
	$resDokter->bindValue(':klinik_id', $klinik_id);
	$resDokter->execute();
	$resultDokter		= $resDokter->fetchAll();
	
	if($conn->commit()) { 
		
		if(empty($resultDokter)){
			$return['metadata']['code'] 	= '201';
			$return['metadata']['message'] 	= 'Gagal Mendapatkan Data Dokter, Atau Tidak Ada Dokter';
			echo json_encode($return);
		}else{
			$return['metadata']['code'] 	= '200';
			$return['metadata']['message'] 	= 'OK.';

			$return['response'] 	= $resultDokter;
			echo json_encode($return);
		}
	}

}catch (PDOException $e) {
	$return['metadata']['code'] 	= '201';;
	$return['metadata']['message'] 	= $e->getMessage();;
	echo json_encode($return);
}

?>
<?php
require_once "../../lib/koneksi.php";
require_once "../../lib/olah_table.php";


$tglPilih = date('N',strtotime($_GET['tgl']));

try {
	$conn->beginTransaction();

	$queryKlinikJadwal		= "SELECT klinik.id, klinik.nama_klinik FROM jadwal_dokter inner join klinik on jadwal_dokter.klinik_id = klinik.id and klinik.deleted_by is null where hari = :hari and jadwal_dokter.deleted_by is null group by klinik.id, klinik.nama_klinik";
	$resKlinikJadwal			= $conn->prepare($queryKlinikJadwal);
	$resKlinikJadwal->bindValue(':hari', $tglPilih);
	$resKlinikJadwal->execute();
	$resultKlinikJadwal		= $resKlinikJadwal->fetchAll();
	
	if($conn->commit()) { 
		
		if(empty($resultKlinikJadwal)){
			$return['metadata']['code'] 	= '201';
			$return['metadata']['message'] 	= 'Gagal Mendapatkan Data Klinik, Atau Tidak Ada Klinik Buka Pada Tanggal '.date('d-m-Y',strtotime($tglPilih)).'.';
			echo json_encode($return);
		}else{
			$return['metadata']['code'] 	= '200';
			$return['metadata']['message'] 	= 'OK.';

			$return['response'] 	= $resultKlinikJadwal;
			echo json_encode($return);
		}
	}

}catch (PDOException $e) {
	$return['metadata']['code'] 	= '201';;
	$return['metadata']['message'] 	= $e->getMessage();;
	echo json_encode($return);
}

?>
<?php
require_once "../../lib/koneksi.php";
require_once "../../lib/olah_table.php";


$tglPilih   = date('Y-m-d',strtotime($_GET['tgl']));
$hari   	= date('N',strtotime($_GET['tgl']));
$klinik 	= $_GET['klinik'];
$dokter 	= $_GET['dokter_id'];

try {
	$conn->beginTransaction();

	$queryKlinikJadwal		= " SELECT
									jadwal_dokter.id,
									jadwal_dokter.jam_mulai,
									jadwal_dokter.jam_selesai,
									bill_kasir.status_selesai
								FROM 
									jadwal_dokter inner join 
									dokter on jadwal_dokter.dokter_id = dokter.id and dokter.deleted_by is null inner join
									klinik on jadwal_dokter.klinik_id = klinik.id and klinik.deleted_by is null left outer join 
									registrasi on jadwal_dokter.id = registrasi.jadwal_dokter_id and registrasi.tgl_order::date = :tglPilih left outer join
									bill_kasir on registrasi.id = bill_kasir.registrasi_id
								WHERE 
									jadwal_dokter.hari = :hari and 
									jadwal_dokter.klinik_id = :klinik and 
									jadwal_dokter.dokter_id = :dokter and
									jadwal_dokter.deleted_by is null
								";
	$resKlinikJadwal			= $conn->prepare($queryKlinikJadwal);
	$resKlinikJadwal->bindValue(':hari', $hari);
	$resKlinikJadwal->bindValue(':klinik', $klinik);
	$resKlinikJadwal->bindValue(':dokter', $dokter);
	$resKlinikJadwal->bindValue(':tglPilih', $tglPilih );
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
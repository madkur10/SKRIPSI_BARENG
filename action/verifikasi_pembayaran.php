<?php
session_start();

require_once "../lib/koneksi.php";
require_once "../lib/olah_table.php";

$input_time = date('Y-m-d H:i:s');

if(!empty($_SESSION)){

    try {
		$conn->beginTransaction();

		$user_id											= trim($_SESSION["users_id"]);
		$registrasi_id										= trim($_POST["registrasi_id"]);
		$uuid 												= uniqid();


		$isi_table_bill_kasir["status_selesai"] 			= 3;

		update_tabel("bill_kasir", $isi_table_bill_kasir, "WHERE registrasi_id = ?", array($registrasi_id));

		$isi_table_registrasi["no_ruang"] 					= $uuid;
		
		update_tabel("registrasi", $isi_table_registrasi, "WHERE id = ?", array($registrasi_id));
		
		if($conn->commit()) { 
			$return['metadata']['code'] 	= '200';;
			$return['metadata']['message'] 	= 'Konsultasi Berhasil Di Daftarkan.';
			$return['metadata']['redirect'] = 'kasir_konfirmasi_pembayaran.php';
			echo json_encode($return);
		}

	}catch (PDOException $e) {
		$return['metadata']['code'] 	= '201';
		$return['metadata']['message'] 	= $e->getMessage();
		echo json_encode($return);
	}	
}else{
	$return['metadata']['code'] 	= '403';
	$return['metadata']['message'] 	= 'Anda Belum Login.';
	echo json_encode($return);
}

?>
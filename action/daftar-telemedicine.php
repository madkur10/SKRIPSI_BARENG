<?php
session_start();

require_once "../lib/koneksi.php";
require_once "../lib/olah_table.php";

$input_time = date('Y-m-d H:i:s');

if(!empty($_SESSION)){

    try {
		$conn->beginTransaction();

		$user_id											= trim($_SESSION["users_id"]);
		$jadwalDokter										= trim($_POST["jadwalDokter"]);
		$pasien_id											= trim($_SESSION["pasien_id"]);
		$dokter_id											= trim($_POST["dokterTujuan"]);
		$klinik_id											= trim($_POST["klinikTujuan"]);
		$tglOrder											= trim(date('Y-m-d 00:00:00',strtotime($_POST["tglKonsultasi"])));
		

		$isi_table_registrasi["id"] 						= generate_max("registrasi","id");
		$isi_table_registrasi["created_by"] 				= $user_id;
		$isi_table_registrasi["created_at"] 				= $input_time;

		$isi_table_registrasi["pasien_id"] 					= $pasien_id;
		$isi_table_registrasi["dokter_id"] 					= $dokter_id;
		$isi_table_registrasi["klinik_id"] 					= $klinik_id;
		$isi_table_registrasi["tgl_order"] 					= $tglOrder;
		$isi_table_registrasi["jadwal_dokter_id"] 			= $jadwalDokter;
		insert_tabel("registrasi", $isi_table_registrasi);

		$isi_table_bill_kasir["id"] 						= generate_max("bill_kasir","id");
		$isi_table_bill_kasir["created_by"] 				= $user_id;
		$isi_table_bill_kasir["created_at"] 				= $input_time;
		
		$isi_table_bill_kasir["registrasi_id"] 				= $isi_table_registrasi["id"];
		$isi_table_bill_kasir["jasa_rs"] 					= 150000;
		$isi_table_bill_kasir["jasa_dr"] 					= 100000;
		$isi_table_bill_kasir["dokter_id"] 					= $dokter_id;
		$isi_table_bill_kasir["klinik_id"] 					= $klinik_id;
		$isi_table_bill_kasir["status_selesai"] 			= 1;

		insert_tabel("bill_kasir", $isi_table_bill_kasir);
		
		if($conn->commit()) { 
			$return['metadata']['code'] 		= '200';;
			$return['metadata']['message'] 		= 'Berhasil';
			$return['metadata']['keterangan'] 	= 'Konsultasi Berhasil Di Daftarkan.';
			$return['metadata']['redirect'] 	= 'konfirmasi_pembayaran.php?registrasi_id='.$isi_table_registrasi["id"];
			echo json_encode($return);
		}

	}catch (PDOException $e) {
		$return['metadata']['code'] 	= '201';
		$return['metadata']['message'] 	= $e->getMessage();
		echo json_encode($return);
	}	
}else{
	$return['metadata']['code'] 	= '403';;
	$return['metadata']['message'] 	= 'Anda Memiliki Session Yang Berlangsung.';
	echo json_encode($return);
}

?>
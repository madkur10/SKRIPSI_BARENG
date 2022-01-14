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

		$uuid = uniqid();
		$path = $_FILES['bukti']['name'];
		$ext = pathinfo($path, PATHINFO_EXTENSION);

		if(move_uploaded_file($_FILES["bukti"]["tmp_name"], "bukti-pembayaran/".$uuid.".".$ext)){
			$isi_table_bill_kasir["id"] 						= generate_max("bill_kasir","id");
			$isi_table_bill_kasir["tgl_proses_billing"]			= $input_time;
			$isi_table_bill_kasir["nama_file_bukti_tf"] 		= $uuid.".".$ext;
			$isi_table_bill_kasir["status_selesai"] 			= 2;

			update_tabel("bill_kasir", $isi_table_bill_kasir, "WHERE registrasi_id = ?", array($registrasi_id));

		}else{
			$return['metadata']['code'] 	= '201';;
			$return['metadata']['message'] 	= 'Gagal Upload Bukti Transfer.';
			echo json_encode($return);
			exit();
		}
		
		if($conn->commit()) { 
			$return['metadata']['code'] 		= '200';;
			$return['metadata']['message'] 		= 'Berhasil';
			$return['metadata']['keterangan'] 	= 'Upload Bukti Pembayaran Berhasil';
			$return['metadata']['redirect'] 	= 'konfirmasi_pembayaran.php?registrasi_id='.$registrasi_id;
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
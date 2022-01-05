<?php
session_start();

require_once "../lib/koneksi.php";
require_once "../lib/olah_table.php";

$input_time = date('Y-m-d H:i:s');
if(empty($_SESSION)){

    try {
		$conn->beginTransaction();

		$namaLengkap									= trim($_POST["namaLengkap"]);
		$jenisKelamin									= trim($_POST["jenisKelamin"]);
		$tempatLahir									= trim($_POST["tempatLahir"]);
		$tglLahir										= date('Y-m-d H:i:s',strtotime(trim($_POST["tglLahir"])));
		$userEmail										= trim($_POST["userEmail"]);
		$nomorIdentitas									= trim($_POST["nomorIdentitas"]);
		$nomorHandphone									= trim($_POST["nomorHandphone"]);
		$username										= trim($_POST["nomorIdentitas"]);
		$password										= trim($_POST["password"]);
		$alamat											= trim($_POST["alamatPasien"]);

		$isi_table_users["id"] 							= generate_max("users","id");
		$isi_table_users["created_by"] 					= $isi_table_users["id"];
		$isi_table_users["created_at"] 					= $input_time;
		$isi_table_users["fullname"] 					= $namaLengkap;

		$isi_table_users["username"] 					= $nomorIdentitas;
		$isi_table_users["password"] 					= $password;
		$isi_table_users["hak_akses_id"] 				= 2;
		$isi_table_users["last_update_pass"] 			= $input_time;
		insert_tabel("users", $isi_table_users);

		$isi_table_pasien["id"] 						= generate_max("pasien","id");
		$isi_table_pasien["created_by"] 				= $isi_table_users["id"];
		$isi_table_pasien["created_at"] 				= $input_time;
		$isi_table_pasien["nama_pasien"] 				= $namaLengkap;
		$isi_table_pasien["no_mr"] 						= _paddingNol($isi_table_pasien["id"],6);

		$isi_table_pasien["no_identitas"] 				= $nomorIdentitas;
		$isi_table_pasien["alamat"] 					= $alamat;
		$isi_table_pasien["no_hp"] 						= $nomorHandphone;
		$isi_table_pasien["email"] 						= $userEmail;
		$isi_table_pasien["tgl_lahir"] 					= $tglLahir;
		$isi_table_pasien["tempat_lahir"] 				= $tempatLahir;
		$isi_table_pasien["jenis_kelamin"] 				= $jenisKelamin;
		$isi_table_pasien["users_id"]	 				= $isi_table_users["id"];
		insert_tabel("pasien", $isi_table_pasien);
		
		if($conn->commit()) { 
			$return['metadata']['code'] 	= '200';;
			$return['metadata']['message'] 	= 'Pendaftaran Berhasil';
			$return['metadata']['redirect'] = 'login.php';
			echo json_encode($return);
		}

	}catch (PDOException $e) {
		$return['metadata']['code'] 	= '201';;
		$return['metadata']['message'] 	= $e->getMessage();;
		echo json_encode($return);
	}	
}else{
	$return['metadata']['code'] 	= '403';;
	$return['metadata']['message'] 	= 'Anda Memiliki Session Yang Berlangsung.';
	echo json_encode($return);
}

?>
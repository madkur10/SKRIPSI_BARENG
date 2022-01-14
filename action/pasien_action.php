<?php
session_start();

require_once "../lib/koneksi.php";
require_once "../lib/olah_table.php";

$input_time = date('Y-m-d H:i:s');
$user_session   = $_SESSION['users_id'];
	
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
    $alamat											= trim($_POST["alamatPasien"]);
    $pasien_id										= $_POST["pasien_id"];

    $update_table_pasien["id"] 						= generate_max("pasien","id");
    $update_table_pasien["updated_by"] 				= $user_session;
    $update_table_pasien["updated_at"] 				= $input_time;
    $update_table_pasien["nama_pasien"] 			= $namaLengkap;

    $update_table_pasien["no_identitas"] 			= $nomorIdentitas;
    $update_table_pasien["alamat"] 					= $alamat;
    $update_table_pasien["no_hp"] 					= $nomorHandphone;
    $update_table_pasien["email"] 					= $userEmail;
    $update_table_pasien["tgl_lahir"] 				= $tglLahir;
    $update_table_pasien["tempat_lahir"] 			= $tempatLahir;
    $update_table_pasien["jenis_kelamin"] 			= $jenisKelamin;
    update_tabel("pasien", $update_table_pasien, "WHERE id = ?", array($pasien_id));
    
    if($conn->commit()) { 
        $return['metadata']['code'] 		= '200';
        $return['metadata']['message'] 		= 'Berhasil';
        $return['metadata']['keterangan'] 	= 'Update Data Pasien Berhasil';
        $return['metadata']['redirect'] 	= 'pasien.php';
        echo json_encode($return);
    }

}catch (PDOException $e) {
    $return['metadata']['code'] 	= '201';;
    $return['metadata']['message'] 	= $e->getMessage();;
    echo json_encode($return);
}

?>
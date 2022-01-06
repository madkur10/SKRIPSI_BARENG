<?php
session_start();

require_once "../lib/koneksi.php";
require_once "../lib/olah_table.php";


$user_session   = $_SESSION['users_id'];
$input_time     = date('Y-m-d H:i:s');

if ($_GET['aksi'] == 'create') {
    $nama_hak_akses   = $_POST['nama_hak_akses'];

    try {
        $conn->beginTransaction();

        $update_table_hak_akses["created_by"] 					= $user_session;
        $update_table_hak_akses["created_at"] 				    = $input_time;
        $update_table_hak_akses["nama_hak_akses"] 				= strtoupper($nama_hak_akses);
        $update_table_hak_akses["id"] 							= generate_max("hak_akses","id");
        insert_tabel("hak_akses", $update_table_hak_akses);
        
        if($conn->commit()) { 
            $return['metadata']['code'] 	= '200';
            $return['metadata']['message'] 	= 'Data Berhasil Ditambah';
            echo json_encode($return);
        }
    }catch (PDOException $e) {
        $return['metadata']['code'] 	= '201';;
        $return['metadata']['message'] 	= $e->getMessage();;
        echo json_encode($return);
    }
}elseif ($_GET['aksi'] == 'delete') {
    $hak_akses_id        = $_GET['id'];

    try {
        $conn->beginTransaction();

        $delete_table_hak_akses["deleted_by"] 					= $user_session;
        $delete_table_hak_akses["deleted_at"] 				    = $input_time;
        update_tabel("hak_akses", $delete_table_hak_akses, "WHERE id = ?", array($hak_akses_id));
        
        if($conn->commit()) { 
            $return['metadata']['code'] 	= '200';
            $return['metadata']['message'] 	= 'Data Berhasil Terhapus';
            echo json_encode($return);
        }
    }catch (PDOException $e) {
        $return['metadata']['code'] 	= '201';;
        $return['metadata']['message'] 	= $e->getMessage();;
        echo json_encode($return);
    }
}elseif($_GET['aksi'] == 'update') {
    $hak_akses_id      = $_POST['hak_akses_id'];
    $nama_hak_akses = $_POST['nama_hak_akses'];

    try {
        $conn->beginTransaction();

        $update_table_hak_akses["updated_by"] 					= $user_session;
        $update_table_hak_akses["updated_at"] 				    = $input_time;
        $update_table_hak_akses["nama_hak_akses"] 				= strtoupper($nama_hak_akses);
        update_tabel("hak_akses", $update_table_hak_akses, "WHERE id = ?", array($hak_akses_id));
        
        if($conn->commit()) { 
            $return['metadata']['code'] 	= '200';
            $return['metadata']['message'] 	= 'Data Berhasil Terupdate';
            echo json_encode($return);
        }
    }catch (PDOException $e) {
        $return['metadata']['code'] 	= '201';;
        $return['metadata']['message'] 	= $e->getMessage();;
        echo json_encode($return);
    }
}

header('Location: ../hak_akses.php');
?>
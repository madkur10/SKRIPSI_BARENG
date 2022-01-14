<?php
session_start();

require_once "../lib/koneksi.php";
require_once "../lib/olah_table.php";


$user_session   = $_SESSION['users_id'];
$input_time     = date('Y-m-d H:i:s');

if ($_GET['aksi'] == 'create') {
    $user_id       = $_POST['user_id'];
    $nama_dokter    = $_POST['nama_dokter'];
    $klinik_id      = $_POST['klinik_id'];

    try {
        $conn->beginTransaction();

        $update_table_dokter["created_by"] 					= $user_session;
        $update_table_dokter["created_at"] 				    = $input_time;
        $update_table_dokter["nama_dokter"] 				= $nama_dokter;
        $update_table_dokter["user_id"] 				    = $user_id;
        $update_table_dokter["klinik_id"] 				    = $klinik_id;
        $update_table_dokter["id"] 							= generate_max("dokter","id");
        insert_tabel("dokter", $update_table_dokter);
        
        if($conn->commit()) { 
            $return['metadata']['code'] 	    = '200';
            $return['metadata']['message'] 	    = 'Berhasil';
            $return['metadata']['keterangan'] 	= 'Data Berhasil Ditambah';
            $return['metadata']['redirect'] 	= 'dokter.php';
            echo json_encode($return);
        }
    }catch (PDOException $e) {
        $return['metadata']['code'] 	= '201';;
        $return['metadata']['message'] 	= $e->getMessage();;
        echo json_encode($return);
    }
}elseif ($_GET['aksi'] == 'delete') {
    $dokter_id        = $_GET['id'];

    try {
        $conn->beginTransaction();

        $delete_table_dokter["deleted_by"] 					= $user_session;
        $delete_table_dokter["deleted_at"] 				    = $input_time;
        update_tabel("dokter", $delete_table_dokter, "WHERE id = ?", array($dokter_id));
        
        if($conn->commit()) { 
            $return['metadata']['code'] 	    = '200';
            $return['metadata']['message'] 	    = 'Berhasil';
            $return['metadata']['keterangan'] 	= 'Data Berhasil Terhapus';
            $return['metadata']['redirect'] 	= 'dokter.php';
            echo json_encode($return);
        }
    }catch (PDOException $e) {
        $return['metadata']['code'] 	= '201';;
        $return['metadata']['message'] 	= $e->getMessage();;
        echo json_encode($return);
    }
}elseif($_GET['aksi'] == 'update') {
    $dokter_id      = $_POST['dokter_id'];
    $user_id        = $_POST['user_id'];
    $nama_dokter    = $_POST['nama_dokter'];
    $klinik_id      = $_POST['klinik_id'];

    try {
        $conn->beginTransaction();

        $update_table_dokter["updated_by"] 					= $user_session;
        $update_table_dokter["updated_at"] 				    = $input_time;
        $update_table_dokter["nama_dokter"] 				= $nama_dokter;
        $update_table_dokter["user_id"] 				    = $user_id;
        $update_table_dokter["klinik_id"] 				    = $klinik_id;
        update_tabel("dokter", $update_table_dokter, "WHERE id = ?", array($dokter_id));
        
        if($conn->commit()) { 
            $return['metadata']['code'] 	    = '200';
            $return['metadata']['message'] 	    = 'Berhasil';
            $return['metadata']['keterangan'] 	= 'Data Berhasil Terupdate';
            $return['metadata']['redirect'] 	= 'dokter.php';
            echo json_encode($return);
        }
    }catch (PDOException $e) {
        $return['metadata']['code'] 	= '201';;
        $return['metadata']['message'] 	= $e->getMessage();;
        echo json_encode($return);
    }
}

?>
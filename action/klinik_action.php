<?php
session_start();

require_once "../lib/koneksi.php";
require_once "../lib/olah_table.php";


$user_session   = $_SESSION['users_id'];
$input_time     = date('Y-m-d H:i:s');

if ($_GET['aksi'] == 'create') {
    $nama_klinik   = $_POST['nama_klinik'];

    try {
        $conn->beginTransaction();

        $update_table_klinik["created_by"] 					= $user_session;
        $update_table_klinik["created_at"] 				    = $input_time;
        $update_table_klinik["nama_klinik"] 				= $nama_klinik;
        $update_table_klinik["id"] 							= generate_max("klinik","id");
        insert_tabel("klinik", $update_table_klinik);
        
        if($conn->commit()) { 
            $return['metadata']['code'] 	    = '200';
            $return['metadata']['message'] 	    = 'Berhasil';
            $return['metadata']['keterangan'] 	= 'Data Berhasil Ditambah';
            $return['metadata']['redirect']     = 'klinik.php';
            echo json_encode($return);
        }
    }catch (PDOException $e) {
        $return['metadata']['code'] 	= '201';;
        $return['metadata']['message'] 	= $e->getMessage();;
        echo json_encode($return);
    }
}elseif ($_GET['aksi'] == 'delete') {
    $klinik_id        = $_GET['id'];

    try {
        $conn->beginTransaction();

        $delete_table_klinik["deleted_by"] 					= $user_session;
        $delete_table_klinik["deleted_at"] 				    = $input_time;
        update_tabel("klinik", $delete_table_klinik, "WHERE id = ?", array($klinik_id));
        
        if($conn->commit()) { 
            $return['metadata']['code'] 	    = '200';
            $return['metadata']['message'] 	    = 'Berhasil';
            $return['metadata']['keterangan'] 	= 'Data Berhasil Dihapus';
            $return['metadata']['redirect']     = 'klinik.php';
            echo json_encode($return);
        }
    }catch (PDOException $e) {
        $return['metadata']['code'] 	= '201';;
        $return['metadata']['message'] 	= $e->getMessage();;
        echo json_encode($return);
    }
}elseif($_GET['aksi'] == 'update') {
    $klinik_id      = $_POST['klinik_id'];
    $nama_klinik    = $_POST['nama_klinik'];

    try {
        $conn->beginTransaction();

        $update_table_klinik["updated_by"] 					= $user_session;
        $update_table_klinik["updated_at"] 				    = $input_time;
        $update_table_klinik["nama_klinik"] 				= $nama_klinik;
        update_tabel("klinik", $update_table_klinik, "WHERE id = ?", array($klinik_id));
        
        if($conn->commit()) { 
            $return['metadata']['code'] 	    = '200';
            $return['metadata']['message'] 	    = 'Berhasil';
            $return['metadata']['keterangan'] 	= 'Data Berhasil Terupdate';
            $return['metadata']['redirect']     = 'klinik.php';
            echo json_encode($return);
        }
    }catch (PDOException $e) {
        $return['metadata']['code'] 	= '201';;
        $return['metadata']['message'] 	= $e->getMessage();;
        echo json_encode($return);
    }
}

?>
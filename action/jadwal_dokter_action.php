<?php
session_start();

require_once "../lib/koneksi.php";
require_once "../lib/olah_table.php";


$user_session   = $_SESSION['users_id'];
$input_time     = date('Y-m-d H:i:s');

if ($_GET['aksi'] == 'create') {
    $klinik_id      = $_POST['klinik_id'];
    $dokter_id      = $_POST['dokter_id'];
    $hari           = $_POST['hari'];
    $slot_jam       = $_POST['slot_jam'];

    try {
        $conn->beginTransaction();

        foreach ($slot_jam as $key => $value) {

            $valslot = explode("-", $value);

            $create_jadwal_dokter["created_by"] 				= $user_session;
            $create_jadwal_dokter["created_at"] 				= $input_time;
            $create_jadwal_dokter["dokter_id"] 				    = $dokter_id;
            $create_jadwal_dokter["klinik_id"] 				    = $klinik_id;
            $create_jadwal_dokter["hari"] 				        = $hari;
            $create_jadwal_dokter["kuota"] 				        = 1;
            $create_jadwal_dokter["jam_mulai"] 				    = $valslot[0];
            $create_jadwal_dokter["jam_selesai"] 				= $valslot[1];
            $create_jadwal_dokter["id"] 						= generate_max("jadwal_dokter","id");
            insert_tabel("jadwal_dokter", $create_jadwal_dokter);
        }
        
        if($conn->commit()) { 
            $return['metadata']['code'] 	= '200';
            $return['metadata']['message'] 	= 'Data Berhasil Ditambah';
            $return['metadata']['redirect'] = 'jadwal_dokter.php';
            echo json_encode($return);
        }
    }catch (PDOException $e) {
        $return['metadata']['code'] 	= '201';;
        $return['metadata']['message'] 	= $e->getMessage();
        $return['metadata']['redirect'] = 'jadwal_dokter.php';
        echo json_encode($return);
    }
}elseif ($_GET['aksi'] == 'delete') {
    $user_id        = $_GET['id'];

    try {
        $conn->beginTransaction();

        $delete_table_users["deleted_by"] 					= $user_session;
        $delete_table_users["deleted_at"] 				    = $input_time;
        update_tabel("users", $delete_table_users, "WHERE id = ?", array($user_id));
        
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
    $user_id        = $_POST['user_id'];
    $nama_lengkap   = $_POST['nama_lengkap'];
    $username       = $_POST['username'];
    $password       = $_POST['password'];
    $hak_akses_id   = $_POST['hak_akses_id'];

    try {
        $conn->beginTransaction();

        $update_table_users["updated_by"] 					= $user_session;
        $update_table_users["updated_at"] 				    = $input_time;
        $update_table_users["fullname"] 				    = $nama_lengkap;
        $update_table_users["username"] 				    = $username;
        $update_table_users["password"] 				    = $password;
        $update_table_users["hak_akses_id"] 				= $hak_akses_id;
        $update_table_users["last_update_pass"] 			= $input_time;
        update_tabel("users", $update_table_users, "WHERE id = ?", array($user_id));
        
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

// header('Location: ../jadwal_dokter.php');
?>
<?php
session_start();

require_once "../lib/koneksi.php";
require_once "../lib/olah_table.php";


$user_session   = $_SESSION['users_id'];
$input_time     = date('Y-m-d H:i:s');

if ($_GET['aksi'] == 'create') {
    $nama_lengkap   = $_POST['nama_lengkap'];
    $username       = $_POST['username'];
    $password       = $_POST['password'];
    $hak_akses_id   = $_POST['hak_akses_id'];

    try {
        $conn->beginTransaction();

        $update_table_users["created_by"] 					= $user_session;
        $update_table_users["created_at"] 				    = $input_time;
        $update_table_users["fullname"] 				    = $nama_lengkap;
        $update_table_users["username"] 				    = $username;
        $update_table_users["password"] 				    = $password;
        $update_table_users["hak_akses_id"] 				= $hak_akses_id;
        $update_table_users["last_update_pass"] 			= $input_time;
        $update_table_users["id"] 							= generate_max("users","id");
        insert_tabel("users", $update_table_users);
        
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

header('Location: ../users.php');
?>
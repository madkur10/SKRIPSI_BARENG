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
            $return['metadata']['code'] 	    = '200';
            $return['metadata']['message'] 	    = 'Berhasil';
            $return['metadata']['keterangan'] 	= 'Data Berhasil Ditambah';
            $return['metadata']['redirect']     = 'jadwal_dokter.php';
            echo json_encode($return);
        }
    }catch (PDOException $e) {
        $return['metadata']['code'] 	= '201';;
        $return['metadata']['message'] 	= $e->getMessage();
        $return['metadata']['redirect'] = 'jadwal_dokter.php';
        echo json_encode($return);
    }
}elseif ($_GET['aksi'] == 'delete') {
    $jadwal_dokter_id        = $_GET['id'];

    try {
        $conn->beginTransaction();

        $delete_table_jadwal_dokter["deleted_by"] 					= $user_session;
        $delete_table_jadwal_dokter["deleted_at"] 				    = $input_time;
        update_tabel("jadwal_dokter", $delete_table_jadwal_dokter, "WHERE id = ?", array($jadwal_dokter_id));
        
        if($conn->commit()) { 
            $return['metadata']['code'] 	    = '200';
            $return['metadata']['message'] 	    = 'Berhasil';
            $return['metadata']['keterangan'] 	= 'Data Berhasil Dihapus';
            $return['metadata']['redirect']     = 'jadwal_dokter.php';
            echo json_encode($return);
        }
    }catch (PDOException $e) {
        $return['metadata']['code'] 	= '201';;
        $return['metadata']['message'] 	= $e->getMessage();;
        echo json_encode($return);
    }
}

?>
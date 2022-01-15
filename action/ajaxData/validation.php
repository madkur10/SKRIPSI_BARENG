<?php
require_once "../../lib/koneksi.php";
require_once "../../lib/olah_table.php";

if ($_GET['tipe'] == 'checknik') {
    $queryCheckNik		= select_tabel("pasien", "no_identitas", "where no_identitas = ?", array($_POST['nik']));

    if(!empty($queryCheckNik)){
        $return['metadata']['code'] 	= '201';
        $return['metadata']['message'] 	= 'No Identitas Sudah Digunakan Pasien Lain';

        $return['response'] 	= $queryCheckNik;
        echo json_encode($return);
    }else{
        $return['metadata']['code'] 	= '200';
        $return['metadata']['message'] 	= 'OK.';

        $return['response'] 	= $queryCheckNik;
        echo json_encode($return);
    }
}
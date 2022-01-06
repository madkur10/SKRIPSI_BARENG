<?php
require_once "../../lib/koneksi.php";
require_once "../../lib/olah_table.php";

try {
	$conn->beginTransaction();

	$queryUsers		= "SELECT
                            users.fullname,
                            users.username,
                            users.password,
                            hak_akses.nama_hak_akses,
                            users.last_update_pass
                        from
                            users
                        inner join hak_akses on
                            users.hak_akses_id = hak_akses.id
                        where
                            users.deleted_by is null";
	$resUsers			= $conn->prepare($queryUsers);
	$resUsers->execute();
	$resultUsers		= $resUsers->fetchAll();
	
	if($conn->commit()) { 
		
		if(empty($resultUsers)){
			$return['metadata']['code'] 	= '201';
			$return['metadata']['message'] 	= 'Gagal Mendapatkan Data Users, Atau Tidak Ada User';
			echo json_encode($return);
		}else{
			$return['metadata']['code'] 	= '200';
			$return['metadata']['message'] 	= 'OK.';

			$return['response'] 	= $resultUsers;
			echo json_encode($return);
		}
	}

}catch (PDOException $e) {
	$return['metadata']['code'] 	= '201';;
	$return['metadata']['message'] 	= $e->getMessage();;
	echo json_encode($return);
}

?>
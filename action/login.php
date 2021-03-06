<?php
session_start();

require_once "../lib/koneksi.php";
require_once "../lib/olah_table.php";

$input_time = date('Y-m-d H:i:s');
if(empty($_SESSION)){

    try {
    	$username					= trim(strtolower($_POST["username"]));
		$password					= trim($_POST["password"]);

		$conn->beginTransaction();

		$queryUsersPasien		= " SELECT 
										users.id as user_id, 
										users.fullname, 
										users.username, 
										users.password,
										users.hak_akses_id,
										pasien.id as pasien_id,
										pasien.nama_pasien,
										dokter.id as dokter_id 
									FROM 
										users left outer join 
										pasien on users.id = pasien.users_id left outer join
										dokter on users.id = dokter.user_id
									where 
										lower(users.username) = :username and 
										users.password = :password";
		$resUsersPasien			= $conn->prepare($queryUsersPasien);
		$resUsersPasien->bindValue(':username', $username);
		$resUsersPasien->bindValue(':password', $password);
		$resUsersPasien->execute();
		$resultUsersPasien		= $resUsersPasien->fetch();
		
		if($conn->commit()) { 
			if(!empty($resultUsersPasien['user_id'])){
				$_SESSION['users_id'] = $resultUsersPasien['user_id'];
				$_SESSION['user_name'] = $resultUsersPasien['username'];
				$_SESSION['hak_akses'] = $resultUsersPasien['hak_akses_id'];
				$_SESSION['password'] = $resultUsersPasien['password'];

				if ($resultUsersPasien['hak_akses_id'] == 2) {
					$_SESSION['fullname'] = $resultUsersPasien['nama_pasien'];
				}else{
					$_SESSION['fullname'] = $resultUsersPasien['fullname'];
				}

				if($resultUsersPasien['hak_akses_id'] == 2){
					$_SESSION['pasien_id'] = $resultUsersPasien['pasien_id'];	
				}

				if($resultUsersPasien['hak_akses_id'] == 4){
					$_SESSION['dokter_id'] = $resultUsersPasien['dokter_id'];	
				}
			}

			if(empty($_SESSION['users_id'])){
				$return['metadata']['code'] 		= '201';
				$return['metadata']['message'] 		= 'Gagal';
				$return['metadata']['keterangan'] 	= 'Login Gagal, Mohon Periksa Username & Password Anda.';
				echo json_encode($return);
			}else{
				$return['metadata']['code'] 		= '200';
				$return['metadata']['message'] 		= 'Berhasil';
				$return['metadata']['keterangan'] 	= 'Login Berhasil, Lanjutkan Ke Halaman Utama.';
				if ($_SESSION['hak_akses']==2) {
					$return['metadata']['redirect'] 	= 'pasien_daftar_pilih_poli.php';
				}elseif($_SESSION['hak_akses']==4){
					$return['metadata']['redirect'] 	= 'incoming_telekonsultasi.php';
				}else{
					$return['metadata']['redirect'] 	= 'index.php';
				}
				echo json_encode($return);
			}
		}

	}catch (PDOException $e) {
		$return['metadata']['code'] 	= '201';;
		$return['metadata']['message'] 	= $e->getMessage();;
		echo json_encode($return);
	}	
}else{
	$return['metadata']['code'] 		= '403';
	$return['metadata']['message'] 		= 'Error';
	$return['metadata']['keterangan'] 	= 'Anda Memiliki Session Yang Berlangsung.';
	$return['metadata']['redirect'] 	= 'action/logout.php';
	echo json_encode($return);
}

?>
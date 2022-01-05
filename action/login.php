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

		$queryUsersPasien		= "SELECT * FROM users left outer join pasien on users.id = pasien.users_id where lower(users.username) = :username and users.password = :password";
		$resUsersPasien			= $conn->prepare($queryUsersPasien);
		$resUsersPasien->bindValue(':username', $username);
		$resUsersPasien->bindValue(':password', $password);
		$resUsersPasien->execute();
		$resultUsersPasien		= $resUsersPasien->fetch();
		
		if($conn->commit()) { 
			if(!empty($resultUsersPasien['id'])){
				$_SESSION['users_id'] = $resultUsersPasien['id'];
				$_SESSION['fullname'] = $resultUsersPasien['fullname'];
			}

			if(empty($_SESSION['users_id'])){
				$return['metadata']['code'] 	= '201';
				$return['metadata']['message'] 	= 'Login Gagal, Mohon Periksa Username & Password Anda.';
				echo json_encode($return);
			}else{
				$return['metadata']['code'] 	= '200';
				$return['metadata']['message'] 	= 'Login Berhasil, Lanjutkan Ke Halaman Utama.';
				$return['metadata']['redirect'] = 'index.php';
				echo json_encode($return);
			}
		}

	}catch (PDOException $e) {
		$return['metadata']['code'] 	= '201';;
		$return['metadata']['message'] 	= $e->getMessage();;
		echo json_encode($return);
	}	
}else{
	$return['metadata']['code'] 	= '403';;
	$return['metadata']['message'] 	= 'Anda Memiliki Session Yang Berlangsung.';
	echo json_encode($return);
}

?>
<?php
date_default_timezone_set('Asia/Jakarta');

$servername_db 		= "127.0.0.1";
$port_db			    = "5432";
$databasename_db	= "db_telemedicine_new";
$username_db		  = "postgres";
$password_db		  = "123madkur";

try {
  $conn = new PDO("pgsql:host=$servername_db;port=$port_db;dbname=$databasename_db;user=$username_db;password=$password_db");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  error_log($e->getMessage());
  exit('Tidak Dapat Menyambungkan Koneksi Ke Database');
}
?>
<?php
date_default_timezone_set('Asia/Jakarta');

$servername_db 		= "196.169.66.126";
$port_db			    = "80";
$databasename_db	= "db_telemedicine";
$username_db		  = "postgres";
$password_db		  = "R5p3ln1!!";

try {
  $conn = new PDO("pgsql:host=$servername_db;port=$port_db;dbname=$databasename_db;user=$username_db;password=$password_db");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  error_log($e->getMessage());
  exit('Tidak Dapat Menyambungkan Koneksi Ke Database');
}
?>
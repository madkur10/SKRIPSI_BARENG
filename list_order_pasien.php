<?php 
session_start();
if(empty($_SESSION)){
    header('Location: login.php');
}
require_once "template/header.php"; 

 $queryKlinikJadwal      = "
                            SELECT 
                                registrasi.id as registrasi_id,
                                klinik.id as klinik_id, 
                                klinik.nama_klinik,
                                dokter.nama_dokter,
                                jadwal_dokter.jam_mulai,
                                jadwal_dokter.jam_selesai,
                                registrasi.tgl_order,
                                registrasi.created_at,
                                pasien.no_mr, 
                                pasien.nama_pasien,
                                pasien.jenis_kelamin,
                                bill_kasir.status_selesai,
                                bill_kasir.nama_file_bukti_tf,
                                registrasi.no_ruang
                            FROM 
                                registrasi inner join 
                                jadwal_dokter on registrasi.jadwal_dokter_id = jadwal_dokter.id inner join
                                klinik on klinik.id = registrasi.klinik_id inner join
                                dokter on dokter.id = registrasi.dokter_id inner join 
                                pasien on pasien.id = registrasi.pasien_id inner join
                                bill_kasir on bill_kasir.registrasi_id = registrasi.id
                            where 
                                pasien.id = :pasien_id";
$resKlinikJadwal            = $conn->prepare($queryKlinikJadwal);
$resKlinikJadwal->bindValue(':pasien_id', $_SESSION['pasien_id']);
$resKlinikJadwal->execute();
$resultKlinikJadwal     = $resKlinikJadwal->fetchAll();
?>
    <body class="sb-nav-fixed">
        <?php require_once "lib/navtop.php"; ?>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <?php require_once "lib/navside.php"; ?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <div class="card mt-4">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-8 col-sm-8">
                                    <h4>Daftar User</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th><center>No.</center></th>
                                            <th>No Registrasi</th>
                                            <th>Pasien</th>
                                            <th>Tujuan Konsultasi</th>
                                            <th>Status Pesanan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list_user">
                                        <?php 
                                            $no = 0;
                                            foreach ($resultKlinikJadwal as $key => $value) {
                                                $no++;
                                        ?>
                                        <tr>
                                            <td><center><?php echo $no;?></center></td>
                                            <td><?php echo $value['registrasi_id'];?></td>
                                            <td><?php echo $value['no_mr'];?> - <?php echo $value['nama_pasien'];?></td>
                                            <td><?php echo $value['nama_klinik'];?><br><?php echo $value['nama_dokter'];?><br><?php echo $value['jam_mulai'];?></td>
                                            <td>
                                                <center>
                                                    <?php
                                                        if($value['status_selesai'] == 1){
                                                            echo '<span class="badge bg-danger">Menunggu Pembayaran</span>';
                                                        }elseif($value['status_selesai'] == 2){
                                                            echo '<span class="badge bg-warning">Menunggu Konfirmasi Kasir</span>';
                                                        }elseif($value['status_selesai'] == 3){
                                                            echo '<span class="badge bg-success">LUNAS</span>';
                                                        }
                                                    ?>    
                                                </center>
                                            </td>
                                            <td>
                                                <?php
                                                    if($value['status_selesai'] == 3){
                                                        $noooooooooooow     = strtotime(date('Y-m-d H:i:s'));
                                                        $rangeMulaiAwal     = strtotime(date('Y-m-d',strtotime($value['tgl_order'])).' '.$value['jam_mulai']);
                                                        $rangeMulaiAkhir    = strtotime(date('Y-m-d',strtotime($value['tgl_order'])).' '.$value['jam_selesai']);
                                                        
                                                        if( ($noooooooooooow > $rangeMulaiAwal) && ($noooooooooooow < $rangeMulaiAkhir) ){
                                                            echo '<a href="https://meet.jit.si/'.$value['no_ruang'].'" target="_blank"><span class="btn btn-sm btn-primary"><i class="fas fa-video"></i></span></a>';
                                                        }elseif( $noooooooooooow < $rangeMulaiAwal ){
                                                            echo '<span class="btn btn-sm btn-secondary"><i class="fas fa-video"></i></span>';
                                                        }elseif( $noooooooooooow > $rangeMulaiAkhir ){
                                                            echo '<span class="btn btn-sm btn-secondary"><i class="fas fa-video"></i></span>';
                                                        }
                                                    }else{
                                                        echo '-';
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2021</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <div class="modal fade" id="tambahModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <form action="action/users_action.php?aksi=create" method="POST">
                    <div class="modal-header">
                    <h5 class="modal-title">Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="nama_lengkap" class="col-sm-2 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan Nama Lengkap">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="username" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username">
                            </div>
                        </div>  
                        <div class="mb-3 row">
                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="password" name="password" placeholder="Masukkan Password">
                            </div>
                        </div>  
                        <div class="mb-3 row">
                            <label for="menu" class="col-sm-2 col-form-label">Hak Akses</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="hak_akses_id">
                                    <option selected>--- Pilih Hak Akses ---</option>
                                    <?php foreach ($resultHakAkses as $keyhak => $valhak) {?>
                                        <option value="<?=$valhak['id']?>" ><?=$valhak['nama_hak_akses']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>   
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
<?php require_once "template/footer.php"; ?>





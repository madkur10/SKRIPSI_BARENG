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
                                registrasi.tgl_order,
                                registrasi.created_at,
                                pasien.no_mr, 
                                pasien.nama_pasien,
                                bill_kasir.status_selesai,
                                bill_kasir.nama_file_bukti_tf
                            FROM 
                                registrasi inner join 
                                jadwal_dokter on registrasi.jadwal_dokter_id = jadwal_dokter.id inner join
                                klinik on klinik.id = registrasi.klinik_id inner join
                                dokter on dokter.id = registrasi.dokter_id inner join 
                                pasien on pasien.id = registrasi.pasien_id inner join
                                bill_kasir on bill_kasir.registrasi_id = registrasi.id";
$resKlinikJadwal            = $conn->prepare($queryKlinikJadwal);
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
                                    <h4>Daftar Pembayaran Pasien</h4>
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
                                            <th>Aksi</th>
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
                                                    if($value['status_selesai'] == 2){
                                                        ?>
                                                        <button class="badge bg-primary" data-bs-toggle="modal" data-bs-target="#konfirmasiBayar<?=$value['registrasi_id']?>"><i class="fas fa-check"></i></button>
                                                        <div class="modal" id="konfirmasiBayar<?=$value['registrasi_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Anda Yakin Pembayaran Diterima?</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <img src="action/bukti-pembayaran/<?=$value['nama_file_bukti_tf']?>" width="100%"/>
                                                                    <form method="POST" action="action/verifikasi_pembayaran.php">
                                                                        <br>
                                                                        <input name="registrasi_id" type="hidden" value="<?=$value['registrasi_id']?>">
                                                                        <span class="btn btn-primary col-12 submit" onclick="submitWithFunction(this)">KONFIRMASI</span>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
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





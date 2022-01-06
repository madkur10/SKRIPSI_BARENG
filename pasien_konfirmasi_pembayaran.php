<?php
session_start();
if(empty($_SESSION)){
    header('Location: login.php');
}

require_once "lib/koneksi.php";
require_once "lib/olah_table.php";

?>
<!DOCTYPE html>
<html lang="en">
    <?php require_once "template/header.php"; ?>
    <body class="sb-nav-fixed">
        <?php require_once "lib/navtop.php"; ?>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <?php require_once "lib/navside.php"; ?>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Pendaftaran Layanan Telemedicine</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Mohon Pilih Klinik Yang Ingin Anda Tuju.</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        UPLOAD BUKTI PEMBAYARAN
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        $queryKlinikJadwal      = "
                                                                    SELECT 
                                                                        klinik.id, 
                                                                        klinik.nama_klinik,
                                                                        dokter.nama_dokter,
                                                                        jadwal_dokter.jam_mulai,
                                                                        registrasi.tgl_order,
                                                                        registrasi.created_at,
                                                                        pasien.no_mr, 
                                                                        pasien.nama_pasien,
                                                                        pasien.no_identitas,
                                                                        pasien.tgl_lahir,
                                                                        pasien.jenis_kelamin,
                                                                        bill_kasir.status_selesai
                                                                    FROM 
                                                                        registrasi inner join 
                                                                        jadwal_dokter on registrasi.jadwal_dokter_id = jadwal_dokter.id inner join
                                                                        klinik on klinik.id = registrasi.klinik_id inner join
                                                                        dokter on dokter.id = registrasi.dokter_id inner join 
                                                                        pasien on pasien.id = registrasi.pasien_id inner join
                                                                        bill_kasir on bill_kasir.registrasi_id = registrasi.id
                                                                    WHERE 
                                                                        registrasi.id = :registrasi_id";
                                        $resKlinikJadwal            = $conn->prepare($queryKlinikJadwal);
                                        $resKlinikJadwal->bindValue(':registrasi_id', $_GET['registrasi_id']);
                                        $resKlinikJadwal->execute();
                                        $resultKlinikJadwal     = $resKlinikJadwal->fetch();

                                        if(!empty($resultKlinikJadwal)){
                                            ?>
                                            <table>
                                                <tr>
                                                    <td>No MR</td>
                                                    <td>:</td>
                                                    <td><?=$resultKlinikJadwal['no_mr']?></td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Pasien</td>
                                                    <td>:</td>
                                                    <td><?=$resultKlinikJadwal['nama_pasien']?></td>
                                                </tr>
                                                <tr>
                                                    <td>No Identitas</td>
                                                    <td>:</td>
                                                    <td><?=$resultKlinikJadwal['no_identitas']?></td>
                                                </tr>
                                                <tr>
                                                    <td>Tgl Lahir</td>
                                                    <td>:</td>
                                                    <td><?=date('d-m-Y',strtotime($resultKlinikJadwal['tgl_lahir']))?></td>
                                                </tr>
                                                <tr>
                                                    <td>Jenis Kelamin</td>
                                                    <td>:</td>
                                                    <td><?=$resultKlinikJadwal['jenis_kelamin']?></td>
                                                </tr>
                                                <tr>
                                                    <td>Tgl Rencana Konsultasi</td>
                                                    <td>:</td>
                                                    <td><?=date('d-m-Y',strtotime($resultKlinikJadwal['tgl_order']))?></td>
                                                </tr>
                                                <tr>
                                                    <td>Jam Tele Konsultasi</td>
                                                    <td>:</td>
                                                    <td><?=date('H:i',strtotime($resultKlinikJadwal['jam_mulai']))?></td>
                                                </tr>
                                                <tr>
                                                    <td>Klinik Tujuan</td>
                                                    <td>:</td>
                                                    <td><?=$resultKlinikJadwal['nama_klinik']?></td>
                                                </tr>
                                                <tr>
                                                    <td>Dokter Tujuan</td>
                                                    <td>:</td>
                                                    <td><?=$resultKlinikJadwal['nama_dokter']?></td>
                                                </tr>
                                            </table>
                                            <br>
                                            <form method="POST" action="action/upload_bukti_pembayaran.php" id="formUpload" enctype="multipart/form-data">
                                                <div class="mb-3">
                                                  <label for="formFile" class="form-label">Upload Bukti Pembayaran</label>
                                                  <input class="form-control" type="hidden" name="registrasi_id" value="<?=$_GET['registrasi_id']?>">
                                                  <input class="form-control" type="file" id="formFile" name="bukti">
                                                </div>
                                                <span class="btn btn-primary col-12 submitWithFile">UPLOAD BUKTI PEMBAYARAN</span>
                                            </form>
                                            <?php
                                        }else{
                                            ?>
                                            <div class="alert alert-danger" role="alert">
                                              Tidak Ada Pendaftaran Dengan No Bukti <?=$_GET['registrasi_id']?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    
                                    <div class="card-body">
                                        <div class="row px-3 justify-content-center mt-4 mb-5 border-line">
                                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-indicators">
                                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                </div>
                                                <div class="carousel-inner">
                                                    <div class="carousel-item active">
                                                        <img src="assets/img/carousel_1.jpg" class="d-block w-100 carouselsize" alt="...">
                                                    </div>
                                                    <div class="carousel-item">
                                                        <img src="assets/img/carousel_2.jpg" class="d-block w-100 carouselsize" alt="...">
                                                    </div>
                                                    <div class="carousel-item">
                                                        <img src="assets/img/carousel_3.jpg" class="d-block w-100 carouselsize" alt="...">
                                                    </div>
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
<?php require_once "template/footer.php"; ?>

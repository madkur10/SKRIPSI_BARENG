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
                        <h1 class="mt-4">Konfirmasi Pembayaran</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Halaman Konfirmasi Pembayaran.</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card mb-4">
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
                                            <center>
                                                <?php
                                                if($resultKlinikJadwal['status_selesai'] == 1 && strtotime(date('d-m-Y H:i:s',strtotime($resultKlinikJadwal['created_at'] . "+2hours"))) < strtotime(date('Y-m-d H:i:s'))){
                                                    ?>
                                                    <font style="font-size: 22px; font-weight: bold;">Hallo</font><br>
                                                    (<?=$resultKlinikJadwal['no_mr']?>) - <?=$resultKlinikJadwal['nama_pasien']?> <br>
                                                    Pendaftaran Anda Ke <br>
                                                    <?=$resultKlinikJadwal['nama_klinik']?> - <?=$resultKlinikJadwal['nama_dokter']?><br>
                                                    Dengan Rencana Konsultasi Online Pada <br>
                                                    <?=date('d-m-Y',strtotime($resultKlinikJadwal['tgl_order']))?> Pukul : <?=$resultKlinikJadwal['jam_mulai']?><br>
                                                    <?php
                                                    echo '
                                                        <br><br>
                                                        Mohon Selesaikan Pembayaran Anda Sebelum <br>
                                                        <h4>'.date('d-m-Y H:i:s',strtotime($resultKlinikJadwal['created_at'] . "+2hours")).'</h4>
                                                        <br>
                                                        <span class="btn btn-warning col-md-3 col-xs-12 disabled" style="font-weight:bold;">EXPIRED ORDER</span>';
                                                }elseif($resultKlinikJadwal['status_selesai'] == 1 && strtotime(date('d-m-Y H:i:s',strtotime($resultKlinikJadwal['created_at'] . "+2hours"))) > strtotime(date('Y-m-d H:i:s'))){
                                                    ?>
                                                    <font style="font-size: 22px; font-weight: bold;">Hallo</font><br>
                                                    (<?=$resultKlinikJadwal['no_mr']?>) - <?=$resultKlinikJadwal['nama_pasien']?> <br>
                                                    Pendaftaran Anda Ke <br>
                                                    <?=$resultKlinikJadwal['nama_klinik']?> - <?=$resultKlinikJadwal['nama_dokter']?><br>
                                                    Dengan Rencana Konsultasi Online Pada <br>
                                                    <?=date('d-m-Y',strtotime($resultKlinikJadwal['tgl_order']))?> Pukul : <?=$resultKlinikJadwal['jam_mulai']?><br>
                                                    <?php
                                                    echo '
                                                        <br><br>
                                                        Mohon Selesaikan Pembayaran Anda Sebelum <br>
                                                        <h4>'.date('d-m-Y H:i:s',strtotime($resultKlinikJadwal['created_at'] . "+2hours")).'</h4>
                                                        <br>
                                                        <a href="pasien_konfirmasi_pembayaran.php?registrasi_id='.$_GET['registrasi_id'].'">
                                                                <span class="btn btn-primary col-md-3 col-xs-12" style="font-weight:bold;">LAKUKAN PEMBAYARAN</span>
                                                        </a>';
                                                }elseif($resultKlinikJadwal['status_selesai'] == 2){
                                                    ?>
                                                    <font style="font-size: 22px; font-weight: bold;">Terima Kasih Sudah Melakukan Pembayaran.</font><br>
                                                    (<?=$resultKlinikJadwal['no_mr']?>) - <?=$resultKlinikJadwal['nama_pasien']?> <br>
                                                    Pendaftaran Anda Ke <br>
                                                    <?=$resultKlinikJadwal['nama_klinik']?> - <?=$resultKlinikJadwal['nama_dokter']?><br>
                                                    Dengan Rencana Konsultasi Online Pada <br>
                                                    <?=date('d-m-Y',strtotime($resultKlinikJadwal['tgl_order']))?> Pukul : <?=$resultKlinikJadwal['jam_mulai']?><br>
                                                    <?php
                                                    echo '
                                                        <br>
                                                        Status Pembayaran Anda Saat Ini <br>
                                                        <span class="btn btn-primary col-md-3 col-xs-12" style="font-weight:bold;">MENUNGGU KONFIRMASI KASIR</span>';
                                                }elseif($resultKlinikJadwal['status_selesai'] == 3){
                                                    echo '
                                                        <br>
                                                        Status Pembayaran Anda Saat Ini <br>
                                                        <span class="btn btn-success col-md-3 col-xs-12" style="font-weight:bold;">LUNAS</span>';
                                                }
                                                ?>
                                            </center>
                                            <?php
                                        }
                                        ?>
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

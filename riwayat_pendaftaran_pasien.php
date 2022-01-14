<?php 
session_start();
if(empty($_SESSION)){
    header('Location: login.php');
}
require_once "template/header.php"; 

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
                                        <h4>Riwayat Konsultasi</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table" id="datatablesSimple">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th class="text-center">Nama Pasien</th>
                                                    <th class="text-center">Usia</th>
                                                    <th class="text-center">Alamat</th>
                                                    <th class="text-center">No. Rekam Medis</th>
                                                    <th class="text-center">Klinik</th>
                                                    <th class="text-center">Dokter</th>
                                                    <th class="text-center">Tanggal Konsultasi</th>
                                                    <th class="text-center">Slot Jam</th>
                                                    <th class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $queryRegistrasi = "SELECT
                                                                        pasien.nama_pasien,
                                                                        AGE(current_date, pasien.tgl_lahir) as usia,
                                                                        pasien.alamat,
                                                                        pasien.no_mr,
                                                                        klinik.nama_klinik,
                                                                        dokter.nama_dokter,
                                                                        registrasi.tgl_order,
                                                                        jadwal_dokter.jam_mulai,
                                                                        jadwal_dokter.jam_selesai
                                                                    from
                                                                        registrasi
                                                                    inner join pasien on
                                                                        registrasi.pasien_id = pasien.id
                                                                    inner join klinik on
                                                                        registrasi.klinik_id = klinik.id
                                                                    inner join dokter on
                                                                        registrasi.dokter_id = dokter.id
                                                                    inner join jadwal_dokter on
                                                                        registrasi.jadwal_dokter_id = jadwal_dokter.id
                                                                    where
                                                                        registrasi.deleted_by is null";
                                                $resqueryRegistrasi			= $conn->prepare($queryRegistrasi);
                                                $resqueryRegistrasi->execute();
                                                $resultqueryRegistrasi		= $resqueryRegistrasi->fetchAll();
                                            ?>
                                                <tbody class="table-striped">
                                                    <?php
                                                        foreach ($resultqueryRegistrasi as $key => $value) {
                                                
                                                    ?>
                                                    <tr>
                                                        <td><?php echo  $value['nama_pasien'];?></td>
                                                        <td><?php echo  $value['usia'];?></td>
                                                        <td><?php echo  $value['alamat'];?></td>
                                                        <td><?php echo  $value['no_mr'];?></td>
                                                        <td><?php echo  $value['nama_klinik'];?></td>
                                                        <td><?php echo  $value['nama_dokter'];?></td>
                                                        <td><?php echo  date('d-m-Y', strtotime($value['tgl_order']));?></td>
                                                        <td><?php echo  $value['jam_mulai']." - ".$value['jam_selesai'];?></td>
                                                        <td>
                                                            <center>
                                                                <?php
                                                                $noooooooooooow     = strtotime(date('Y-m-d H:i:s'));
                                                                $rangeMulaiAwal     = strtotime(date('Y-m-d',strtotime($value['tgl_order'])).' '.$value['jam_mulai']);
                                                                $rangeMulaiAkhir    = strtotime(date('Y-m-d',strtotime($value['tgl_order'])).' '.$value['jam_selesai']);

                                                                if( ($noooooooooooow > $rangeMulaiAwal) && ($noooooooooooow < $rangeMulaiAkhir) ){
                                                                    echo '<span class="btn btn-sm btn-success col-12"><strong>Sedang Berlangsung</strong></span>';
                                                                }elseif( $noooooooooooow < $rangeMulaiAwal ){
                                                                        echo '<span class="btn btn-sm btn-danger col-12"><strong>Akan Datang</strong></span>';
                                                                }elseif( $noooooooooooow > $rangeMulaiAkhir ){
                                                                    echo '<span class="btn btn-sm btn-success col-12"><strong>Selesai</strong></span>';
                                                                }
                                                                ?>                                                    
                                                            </center>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                        }
                                                    ?>
                                            </tbody>
                                        </table>
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


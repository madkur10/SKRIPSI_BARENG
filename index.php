<?php 
    session_start();
    if(empty($_SESSION)){
        header('Location: login.php');
    }
?>
<?php require_once "template/header.php"; ?>
    <body class="sb-nav-fixed">
        <?php require_once "lib/navtop.php"; ?>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <?php require_once "lib/navside.php"; ?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>

                        <?php
                            if($_SESSION['hak_akses'] == 1){
                                $countuser = "select count(id) as total_user from users where deleted_by is null";
                                $rescountuser			= $conn->prepare($countuser);
                                $rescountuser->execute();
                                $resultcountuser		= $rescountuser->fetch();

                                $countklinik = "select count(id) as total_klinik from klinik where deleted_by is null";
                                $rescountklinik			= $conn->prepare($countklinik);
                                $rescountklinik->execute();
                                $resultcountklinik		= $rescountklinik->fetch();

                                $countpasien = "select count(id) as total_pasien from pasien where deleted_by is null";
                                $rescountpasien			= $conn->prepare($countpasien);
                                $rescountpasien->execute();
                                $resultcountpasien		= $rescountpasien->fetch();

                                $countdokter = "select count(id) as total_dokter from dokter where deleted_by is null";
                                $rescountdokter			= $conn->prepare($countdokter);
                                $rescountdokter->execute();
                                $resultcountdokter		= $rescountdokter->fetch();
                        ?>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white text-center mb-4">
                                    <div class="card bg-primary ">
                                        <strong><i class="fas fa-user"></i> USERS </strong>
                                    </div>
                                    <div class="card-body">
                                        <h2><strong><?php echo $resultcountuser['total_user'];?></strong></h2>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="users.php">Lihat Detail</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4 text-center">
                                    <div class="card bg-warning ">
                                        <strong><i class="fas fa-hospital"></i> KLINIK </strong>
                                    </div>
                                    <div class="card-body">
                                        <h2><strong><?php echo $resultcountklinik['total_klinik'];?></strong></h2>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="klinik.php">Lihat Detail</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4 text-center">
                                    <div class="card bg-success ">
                                        <strong><i class="fas fa-hospital-user"></i> PASIEN </strong>
                                    </div>
                                    <div class="card-body">
                                        <h2><strong><?php echo $resultcountpasien['total_pasien'];?></strong></h2>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="pasien.php">Lihat Detail</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4 text-center">
                                    <div class="card bg-danger ">
                                        <strong><i class="fas fa-stethoscope"></i> DOKTER </strong>
                                    </div>
                                    <div class="card-body">
                                        <h2><strong><?php echo $resultcountdokter['total_dokter'];?></strong></h2>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="dokter.php">Lihat Detail</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            }  
                            
                            
                            if($_SESSION['hak_akses'] == 1 || $_SESSION['hak_akses'] == 3 || $_SESSION['hak_akses'] == 5){
                        ?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Pasien Konsultasi Terbaru
                            </div>
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
                                                                    registrasi.deleted_by is null
                                                                order by registrasi.id desc
                                                                limit 5";
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
                    <?php } ?>
                    
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

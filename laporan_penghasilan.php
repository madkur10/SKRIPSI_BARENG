<?php 
session_start();
if(empty($_SESSION)){
    header('Location: login.php');
}
require_once "template/header.php"; 



$queryKlinik		= "SELECT * from klinik where deleted_by is null";
$resKlinik			= $conn->prepare($queryKlinik);
$resKlinik->execute();
$resultKlinik		= $resKlinik->fetchAll();

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
                                        <h4>Laporan Penghasilan</h4>
                                    </div>
                                </div>
                            </div>
                            <form action="laporan_penghasilan.php?aksi=laporan" method="POST">
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-3">
                                                <label>KLINIK</label>
                                            </div>
                                            <div class="col-1">
                                                <label>:</label>
                                            </div>
                                            <div class="col-8">
                                                <select name="klinik_id" id="klinik" class="form-control" onchange="getDokter(this)">
                                                    <option value="">--- Pilih Klinik ---</option>
                                                    <?php foreach ($resultKlinik as $keyKlinik => $valKlinik) {
                                                        echo "<option value='".$valKlinik['id']."'>".$valKlinik['nama_klinik']."</option>";
                                                    }?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <div class="row">
                                            <div class="col-3">
                                                <label>DOKTER</label>
                                            </div>
                                            <div class="col-1">
                                                <label>:</label>
                                            </div>
                                            <div class="col-8">
                                                <select name="dokter_id" id="dokter" class="form-control">
                                                    <option value="">--- Pilih Dokter ---</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <div class="row">
                                            <div class="col-3">
                                                <label>TANGGAL KONSULTASI</label>
                                            </div>
                                            <div class="col-1">
                                                <label>:</label>
                                            </div>
                                            <div class="col-8 row">
                                                <div class="col-md-5">
                                                    <input type="date" class="form-control" name="tgl_awal" required>
                                                </div>
                                                <div class="col-md-1">
                                                    s/d
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="date" class="form-control" name="tgl_akhir" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3 text-center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                <?php
                    if (!empty($_GET['aksi'])) {
                        if (!empty($_POST['klinik_id'])) {
                            $kondisiKlinik = "AND registrasi.klinik_id =".$_POST['klinik_id'];
                        }else{
                            $kondisiKlinik = "";
                        }

                        if (!empty($_POST['dokter_id'])) {
                            $kondisiDokter = "AND registrasi.dokter_id =".$_POST['dokter_id'];
                        }else{
                            $kondisiDokter = "";
                        }

                        $queryLaporan		= "SELECT 
                                                    registrasi.id as registrasi_id,
                                                    klinik.nama_klinik,
                                                    dokter.nama_dokter,
                                                    jadwal_dokter.jam_mulai,
                                                    jadwal_dokter.jam_selesai,
                                                    registrasi.tgl_order,
                                                    pasien.no_mr, 
                                                    pasien.nama_pasien,
                                                    pasien.jenis_kelamin,
                                                    bill_kasir.status_selesai,
                                                    bill_kasir.jasa_rs,
                                                    bill_kasir.jasa_dr 
                                                FROM 
                                                    registrasi inner join 
                                                    jadwal_dokter on registrasi.jadwal_dokter_id = jadwal_dokter.id inner join
                                                    klinik on klinik.id = registrasi.klinik_id inner join
                                                    dokter on dokter.id = registrasi.dokter_id inner join 
                                                    pasien on pasien.id = registrasi.pasien_id inner join
                                                    bill_kasir on bill_kasir.registrasi_id = registrasi.id
                                                where 
                                                    bill_kasir.status_selesai = 3 
                                                    $kondisiKlinik $kondisiDokter 
                                                    AND CAST(tgl_order as date) between '".$_POST['tgl_awal']."' AND '".$_POST['tgl_akhir']."'
                                                ";
                        $resLaporan			= $conn->prepare($queryLaporan);
                        $resLaporan->execute();
                        $resultLaporan		= $resLaporan->fetchAll();
                ?>
                        <div class="card mt-4">
                            <div class="card-body">
                                <div id="data-print">
                                    <center>
                                        <table width="70%">
                                            <tr> 
                                                <td width="100" align="left"><img src="assets/img/logo_ihc.png" alt="logors" width="150" height="auto"></td>
                                                <td colspan="4"> 
                                                <center>
                                                    <b><font face="Arial, Helvetica, sans-serif" size="5">RS PELNI</font></b><br>
                                                    <font face="Arial, Helvetica, sans-serif" size="2">Jl. Ks. Tubun No. 92-94 RT/RW.013/001 Kel.Slipi Kec.Palmerah<br>Kota Jakarta Barat 11410<br>Telp. (021) 5306901</font> 
                                                </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"><hr></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" align="center"><h2><strong>LAPORAN PENGHASILAN</strong></h2></td>
                                            </tr>
                                            <?php if (!empty($_POST['klinik_id'])) {?>
                                            <tr>
                                                <td colspan="5"><center><?php echo select_tabel("klinik", "nama_klinik", "where id = ?", array($_POST['klinik_id'])); ?></center></td>
                                            </tr>
                                            <?php } ?>
                                            <?php if (!empty($_POST['dokter_id'])) {?>
                                            <tr>
                                                <td colspan="5"><center><?php echo select_tabel('dokter', 'nama_dokter', 'where id = ?', array($_POST['dokter_id'])); ?></center></td>
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="5"><center><?php echo date('d-m-Y',strtotime($_POST['tgl_awal']))?> s/d <?php echo date('d-m-Y',strtotime($_POST['tgl_akhir'])) ?></center></td>
                                            </tr>
                                        </table>
                                    </center>
                                    <div class="table-responsive">
                                        <table border="1" width="100%" cellpadding="4" cellspacing="4">
                                            <thead>
                                                <tr>
                                                    <th class="border"><center>No.</center></th>
                                                    <th class="border">Tgl. Konsultasi</th>
                                                    <th class="border">Jam Konsultasi</th>
                                                    <th class="border">Nama Pasien</th>
                                                    <th class="border">No. Mr</th>
                                                    <th class="border">Klinik</th>
                                                    <th class="border">Dokter</th>
                                                    <th class="border">Jasa Dokter</th>
                                                    <th class="border">Jasa RS</th>
                                                    <th class="border">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    if (!empty($resultLaporan)) {
                                                        $no=0;
                                                        $total_keseluruhan = 0;
                                                        foreach ($resultLaporan as $keyLaporan => $valLaporan) {
                                                            $no++;
                                                ?>
                                                <tr>
                                                    <td class="border"><?php echo $no;?></td>
                                                    <td class="border"><?php echo date('d-m-Y', strtotime($valLaporan['tgl_order']));?></td>
                                                    <td class="border"><?php echo $valLaporan['jam_mulai']." - ".$valLaporan['jam_selesai']?></td>
                                                    <td class="border"><?php echo $valLaporan['nama_pasien']?></td>
                                                    <td class="border"><?php echo $valLaporan['no_mr']?></td>
                                                    <td class="border"><?php echo $valLaporan['nama_klinik']?></td>
                                                    <td class="border"><?php echo $valLaporan['nama_dokter']?></td>
                                                    <td class="border">Rp.<?php echo $valLaporan['jasa_dr']?></td>
                                                    <td class="border">Rp.<?php echo $valLaporan['jasa_rs']?></td>
                                                    <td class="border">Rp.<?php echo $valLaporan['jasa_rs'] + $valLaporan['jasa_dr']?></td>
                                                </tr>
                                                <?php 
                                                    
                                                    $totalbiaya = $valLaporan['jasa_rs'] + $valLaporan['jasa_dr'];
                                                    $total_keseluruhan += $totalbiaya;
                                                    
                                                        }
                                                ?>
                                                <tr style="background-color: #dbd5d5;">
                                                    <td colspan="9" class="border" style="text-align: center;"><strong>Total Keseluruhan</strong></td>
                                                    <td class="border"><strong>Rp.<?php echo $total_keseluruhan;?></strong></td>
                                                </tr>
                                                <?php
                                                    }else{ 
                                                ?>
                                                    <tr>
                                                        <td colspan="10" class="text-center"> Tidak Ada Data</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <center>
                                <div class="mt-3">
                                    <div class="col-4">
                                        <button class="btn btn-sm btn-primary" onclick="printDiv('data-print')"><i class="fas fa-print"></i></button>&nbsp;
                                        <button class="btn btn-sm btn-success" onclick="exporttoexcel('data-print','LAPORAN PENGHASILAN')"><i class="fas fa-file-excel"></i></button>
                                    </div>
                                </div>
                                </center>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
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

<style>
    .border {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }
</style>





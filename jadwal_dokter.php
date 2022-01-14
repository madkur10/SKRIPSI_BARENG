<?php 
session_start();
if(empty($_SESSION)){
    header('Location: login.php');
}
require_once "template/header.php"; 

$queryJadwalDokter		= "SELECT  
                                jadwal_dokter.id as jadwal_dokter_id,
                                jadwal_dokter.hari,
                                jadwal_dokter.jam_mulai,
                                jadwal_dokter.jam_selesai,
                                klinik.nama_klinik,
                                dokter.nama_dokter
                            from 
                                jadwal_dokter 
                                    inner join dokter on
                                jadwal_dokter.dokter_id = dokter.id
                                    inner join klinik on
                                jadwal_dokter.klinik_id = klinik.id
                            where 
                                jadwal_dokter.deleted_by is null order by dokter_id asc
                            ";
$resJadwalDokter		= $conn->prepare($queryJadwalDokter);
$resJadwalDokter->execute();
$resultJadwalDokter		= $resJadwalDokter->fetchAll();

$queryKlinik		= "SELECT * from klinik where deleted_by is null";
$resKlinik			= $conn->prepare($queryKlinik);
$resKlinik->execute();
$resultKlinik		= $resKlinik->fetchAll();

$queryDokter		= "SELECT * from dokter where deleted_by is null";
$resDokter			= $conn->prepare($queryDokter);
$resDokter->execute();
$resultDokter		= $resDokter->fetchAll();
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
                                        <h4>Daftar Jadwal Dokter</h4>
                                    </div>
                                    <div class="col-4 col-sm-4 text-end">
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#tambahJadwal">
                                            + Tambah Jadwal Dokter
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th><center>No.</center></th>
                                            <th>Nama Klinik</th>
                                            <th>Nama Dokter</th>
                                            <th>Hari Praktek</th>
                                            <th>Jam Praktek</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list_user">
                                        <?php 
                                            $no = 0;
                                            foreach ($resultJadwalDokter as $key => $value) {
                                                $no++;
                                        ?>
                                        <tr>
                                            <td><center><?php echo $no;?></center></td>
                                            <td><?php echo $value['nama_klinik'];?></td>
                                            <td><?php echo $value['nama_dokter'];?></td>
                                            <td><?php echo hari($value['hari']);?></td>
                                            <td><?php echo date('H:i', strtotime($value['jam_mulai']));?> - <?php echo date('H:i', strtotime($value['jam_selesai']));?></td>
                                            <td>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapusmodal<?=$value['jadwal_dokter_id']?>"><i class="fas fa-trash"></i></button>
                                                <div class="modal" id="hapusmodal<?=$value['jadwal_dokter_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Anda Yakin?</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <center><h5>Jika anda melanjutkan, maka jadwal dokter akan terhapus.</h5></center>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a onclick="delete_data('action/jadwal_dokter_action.php?aksi=delete&id=<?=$value['jadwal_dokter_id']?>')" type="button" class="btn btn-danger">Hapus</a>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
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

        <div class="modal fade" id="tambahJadwal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <form action="action/jadwal_dokter_action.php?aksi=create" method="POST">
                    <div class="modal-header">
                    <h5 class="modal-title">Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Klinik</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="klinik_id" onchange="getDokter(this)">
                                    <option selected>--- Pilih Klinik ---</option>
                                    <?php foreach ($resultKlinik as $keyklinik => $valklinik) {?>
                                        <option value="<?=$valklinik['id']?>"><?=$valklinik['nama_klinik']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>  
                        <div class="mb-3 row">
                            <label for="menu" class="col-sm-2 col-form-label">Dokter</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="dokter_id">
                                    <option selected>--- Pilih Dokter ---</option>
                                </select>
                            </div>
                        </div> 
                        <div class="mb-3 row">
                            <label for="menu" class="col-sm-2 col-form-label">Hari</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="hari">
                                    <option selected>--- Pilih Hari ---</option> 
                                    <option value="1">Senin</option>
                                    <option value="2">Selasa</option>
                                    <option value="3">Rabu</option>
                                    <option value="4">Kamis</option>
                                    <option value="5">Jumat</option>
                                    <option value="6">Sabtu</option>
                                    <option value="7">Minggu</option>
                                </select>
                            </div>
                        </div> 
                        <div class="mb-3 row">
                            <label for="menu" class="col-sm-2 col-form-label">Slot Jam Pasien</label>
                            <div class="col-sm-10">
                                <div class="card p-3">
                                    <div class="row">
                                        <?php
                                            $jam_slot = jam_slot();

                                            foreach ($jam_slot as $keySlot => $valSlot) {
                                        ?>
                                        <span class="col-md-3 col-xs-12" style="background-color:#9adb5c; border-radius:10px; margin-bottom: 8px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="slot_jam[]" value="<?=$valSlot;?>" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <?=$valSlot;?>
                                                </label>
                                            </div>
                                        </span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <span class="btn btn-primary col-12 submit">Submit</span>
                    </div>
                </form>
                </div>
            </div>
        </div>
<?php require_once "template/footer.php"; ?>


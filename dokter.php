<?php 
session_start();
if(empty($_SESSION)){
    header('Location: login.php');
}

require_once "template/header.php"; 

$queryDokter		= "SELECT
                        dokter.id as dokter_id,
                        dokter.nama_dokter,
                        dokter.user_id,
                        dokter.klinik_id,
                        klinik.nama_klinik,
                        users.fullname
                    from
                        dokter
                    inner join klinik on
                        dokter.klinik_id = klinik.id
                    inner join users on
                        dokter.user_id = users.id
                    where
                        dokter.deleted_by is null";
$resDokter			= $conn->prepare($queryDokter);
$resDokter->execute();
$resultDokter		= $resDokter->fetchAll();

$queryKlinik		= "SELECT * from klinik where deleted_by is null";
$resKlinik			= $conn->prepare($queryKlinik);
$resKlinik->execute();
$resultKlinik		= $resKlinik->fetchAll();

$queryPengguna		= "SELECT * from users where deleted_by is null and hak_akses_id = 4";
$resPengguna			= $conn->prepare($queryPengguna);
$resPengguna->execute();
$resultPengguna		= $resPengguna->fetchAll();
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
                                    <h4>Daftar Dokter</h4>
                                    </div>
                                    <div class="col-4 col-sm-4 text-end">
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                                        + Tambah Dokter
                                    </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th><center>No.</center></th>
                                            <th>Nama Dokter</th>
                                            <th>Nama Pengguna</th>
                                            <th>Klinik</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list_user">
                                        <?php 
                                            $no = 0;
                                            foreach ($resultDokter as $key => $value) {
                                                $no++;
                                        ?>
                                        <tr>
                                            <td><center><?php echo $no;?></center></td>
                                            <td><?php echo $value['nama_dokter'];?></td>
                                            <td><?php echo $value['fullname'];?></td>
                                            <td><?php echo $value['nama_klinik'];?></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#updatemodal<?=$value['user_id']?>"><i class="fas fa-edit"></i></button>
                                                <div class="modal fade" id="updatemodal<?=$value['user_id']?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                        <form id="updateData<?=$value['dokter_id']?>" action="action/dokter_action.php?aksi=update" method="POST">
                                                            <div class="modal-header">
                                                            <h5 class="modal-title">Ubah Dokter</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3 row">
                                                                    <label for="nama_dokter" class="col-sm-2 col-form-label">Nama Dokter</label>
                                                                    <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="nama_dokter" name="nama_dokter" value="<?=$value['nama_dokter']?>" placeholder="Masukkan Nama Lengkap">
                                                                    <input type="hidden" class="form-control" id="dokter_id" name="dokter_id" value="<?=$value['dokter_id']?>">
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 row">
                                                                    <label for="menu" class="col-sm-2 col-form-label">Nama Pengguna</label>
                                                                    <div class="col-sm-10">
                                                                        <select class="form-select" name="user_id">
                                                                            <option selected>--- Pilih Pengguna ---</option>
                                                                            <?php foreach ($resultPengguna as $keypengguna => $valpengguna) {?>
                                                                                <option value="<?=$valpengguna['id']?>" <?php if ($valpengguna['id'] == $value['user_id']) { echo "selected"; }?>><?=$valpengguna['fullname']?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div> 
                                                                <div class="mb-3 row">
                                                                    <label for="menu" class="col-sm-2 col-form-label">Klinik</label>
                                                                    <div class="col-sm-10">
                                                                        <select class="form-select" name="klinik_id">
                                                                            <option selected>--- Pilih Klinik ---</option>
                                                                            <?php foreach ($resultKlinik as $keyklinik => $valklinik) {?>
                                                                                <option value="<?=$valklinik['id']?>" <?php if ($valklinik['id'] == $value['klinik_id']) { echo "selected"; }?>><?=$valklinik['nama_klinik']?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>   
                                                            </div>
                                                            <div class="modal-footer">
                                                                <span class="btn btn-primary col-12" onclick="update_data('<?=$value['dokter_id']?>')">Submit</span>
                                                            </div>
                                                        </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapusmodal<?=$value['dokter_id']?>"><i class="fas fa-trash"></i></button>
                                                <div class="modal" id="hapusmodal<?=$value['dokter_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Anda Yakin?</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <center><h5>Jika anda melanjutkan, maka user akan terhapus.</h5></center>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <a onclick="delete_data('action/dokter_action.php?aksi=delete&id=<?=$value['dokter_id']?>')" type="button" class="btn btn-danger">Hapus</a>
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

        <div class="modal fade" id="tambahModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <form action="action/dokter_action.php?aksi=create" method="POST">
                    <div class="modal-header">
                    <h5 class="modal-title">Tambah Dokter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="nama_dokter" class="col-sm-2 col-form-label">Nama Dokter</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_dokter" name="nama_dokter" placeholder="Masukkan Nama Dokter">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="menu" class="col-sm-2 col-form-label">Nama Pengguna</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="user_id">
                                    <option selected>--- Pilih Pengguna ---</option>
                                    <?php foreach ($resultPengguna as $keypengguna => $valpengguna) {?>
                                        <option value="<?=$valpengguna['id']?>"><?=$valpengguna['fullname']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div> 
                        <div class="mb-3 row">
                            <label for="menu" class="col-sm-2 col-form-label">Klinik</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="klinik_id">
                                    <option selected>--- Pilih Klinik ---</option>
                                    <?php foreach ($resultKlinik as $keyklinik => $valklinik) {?>
                                        <option value="<?=$valklinik['id']?>"><?=$valklinik['nama_klinik']?></option>
                                    <?php } ?>
                                </select>
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





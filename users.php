<?php 
session_start();
if(empty($_SESSION)){
    header('Location: login.php');
}
require_once "template/header.php"; 

$queryUsers		= "SELECT
                        users.id as user_id,
                        users.fullname,
                        users.username,
                        users.password,
                        hak_akses.nama_hak_akses,
                        users.hak_akses_id,
                        users.last_update_pass
                    from
                        users
                    inner join hak_akses on
                        users.hak_akses_id = hak_akses.id
                    where
                        users.deleted_by is null";
$resUsers			= $conn->prepare($queryUsers);
$resUsers->execute();
$resultUsers		= $resUsers->fetchAll();

$queryHakAkses		= "SELECT * from hak_akses where deleted_by is null";
$resHakAkses			= $conn->prepare($queryHakAkses);
$resHakAkses->execute();
$resultHakAkses		= $resHakAkses->fetchAll();
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
                                    <div class="col-4 col-sm-4 text-end">
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                                        + Tambah User
                                    </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th><center>No.</center></th>
                                            <th>Nama Pengguna</th>
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>Hak Akses</th>
                                            <th>Terakhir Password Dirubah</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list_user">
                                        <?php 
                                            $no = 0;
                                            foreach ($resultUsers as $key => $value) {
                                                $no++;
                                        ?>
                                        <tr>
                                            <td><center><?php echo $no;?></center></td>
                                            <td><?php echo $value['fullname'];?></td>
                                            <td><?php echo $value['username'];?></td>
                                            <td><?php echo $value['password'];?></td>
                                            <td><center><span class="badge bg-primary"><?php echo $value['nama_hak_akses'];?></span></center></td>
                                            <td style="width: 20%;"><?php echo $value['last_update_pass'];?></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#updatemodal<?=$value['user_id']?>"><i class="fas fa-edit"></i></button>
                                                <div class="modal fade" id="updatemodal<?=$value['user_id']?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                        <form action="action/users_action.php?aksi=update" method="POST">
                                                            <div class="modal-header">
                                                            <h5 class="modal-title">Ubah Pengguna</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3 row">
                                                                    <label for="nama_lengkap" class="col-sm-2 col-form-label">Nama Lengkap</label>
                                                                    <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?=$value['fullname']?>" placeholder="Masukkan Nama Lengkap">
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 row">
                                                                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                                                                    <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="username" name="username" value="<?=$value['username']?>" placeholder="Masukkan Username">
                                                                    </div>
                                                                </div>  
                                                                <div class="mb-3 row">
                                                                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                                                                    <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="password" name="password" value="<?=$value['password']?>" placeholder="Masukkan Password">
                                                                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?=$value['user_id']?>">
                                                                    </div>
                                                                </div>  
                                                                <div class="mb-3 row">
                                                                    <label for="menu" class="col-sm-2 col-form-label">Hak Akses</label>
                                                                    <div class="col-sm-10">
                                                                        <select class="form-select" name="hak_akses_id">
                                                                            <option selected>--- Pilih Hak Akses ---</option>
                                                                            <?php foreach ($resultHakAkses as $keyhak => $valhak) {?>
                                                                                <option value="<?=$valhak['id']?>" <?php if ($valhak['id'] == $value['hak_akses_id']) { echo "selected"; }?>><?=$valhak['nama_hak_akses']?></option>
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

                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapusmodal<?=$value['user_id']?>"><i class="fas fa-trash"></i></button>
                                                <div class="modal" id="hapusmodal<?=$value['user_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                            <a href="action/users_action.php?aksi=delete&id=<?=$value['user_id']?>" type="button" class="btn btn-danger">Hapus</a>
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





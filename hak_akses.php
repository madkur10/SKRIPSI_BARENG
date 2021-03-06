<?php 
session_start();
if(empty($_SESSION)){
    header('Location: login.php');
}

require_once "template/header.php"; 

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
                                    <h4>Daftar Hak Akses</h4>
                                    </div>
                                    <div class="col-4 col-sm-4 text-end">
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                                        + Tambah Hak Akses
                                    </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th><center>No.</center></th>
                                            <th>Nama Hak Akses</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list_user">
                                        <?php 
                                            $no = 0;
                                            foreach ($resultHakAkses as $key => $value) {
                                                $no++;
                                        ?>
                                        <tr>
                                            <td><center><?php echo $no;?></center></td>
                                            <td><?php echo $value['nama_hak_akses'];?></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#updatemodal<?=$value['id']?>"><i class="fas fa-edit"></i></button>
                                                <div class="modal fade" id="updatemodal<?=$value['id']?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                        <form id="updateData<?=$value['id']?>" action="action/hak_akses_action.php?aksi=update" method="POST">
                                                            <div class="modal-header">
                                                            <h5 class="modal-title">Ubah Hak Akses</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3 row">
                                                                    <label for="nama_hak_akses" class="col-sm-2 col-form-label">Nama Hak Akses</label>
                                                                    <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="nama_hak_akses" name="nama_hak_akses" value="<?=$value['nama_hak_akses']?>" placeholder="Masukkan Nama Hak Akses">
                                                                    <input type="hidden" class="form-control" id="hak_akses_id" name="hak_akses_id" value="<?=$value['id']?>">
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                            <div class="modal-footer">
                                                                <span class="btn btn-primary col-12" onclick="update_data('<?=$value['id']?>')">Submit</span>
                                                            </div>
                                                        </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapusmodal<?=$value['id']?>"><i class="fas fa-trash"></i></button>
                                                <div class="modal" id="hapusmodal<?=$value['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Anda Yakin?</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <center><h5>Jika anda melanjutkan, maka Hak Akses akan terhapus.</h5></center>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <a onclick="delete_data('action/hak_akses_action.php?aksi=delete&id=<?=$value['id']?>')" type="button" class="btn btn-danger">Hapus</a>
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
                <form action="action/hak_akses_action.php?aksi=create" method="POST">
                    <div class="modal-header">
                    <h5 class="modal-title">Tambah Hak Akses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="nama_hak_akses" class="col-sm-2 col-form-label">Nama Hak Akses</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_hak_akses" name="nama_hak_akses" placeholder="Masukkan Nama Hak Akses">
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





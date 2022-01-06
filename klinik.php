<?php 
session_start();
if(empty($_SESSION)){
    header('Location: login.php');
}

require_once "template/header.php"; 

$queryClinic		= "SELECT * from klinik where deleted_by is null";
$resClinic			= $conn->prepare($queryClinic);
$resClinic->execute();
$resultClinic		= $resClinic->fetchAll();
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
                                    <h4>Daftar Klinik</h4>
                                    </div>
                                    <div class="col-4 col-sm-4 text-end">
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                                        + Tambah Klinik
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
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list_user">
                                        <?php 
                                            $no = 0;
                                            foreach ($resultClinic as $key => $value) {
                                                $no++;
                                        ?>
                                        <tr>
                                            <td><center><?php echo $no;?></center></td>
                                            <td><?php echo $value['nama_klinik'];?></td>
                                            <td>
                                                <button class="badge bg-primary" data-bs-toggle="modal" data-bs-target="#updatemodal<?=$value['id']?>"><i class="fas fa-edit"></i></button>
                                                <div class="modal fade" id="updatemodal<?=$value['id']?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                        <form action="action/klinik_action.php?aksi=update" method="POST">
                                                            <div class="modal-header">
                                                            <h5 class="modal-title">Ubah Klinik</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3 row">
                                                                    <label for="nama_klinik" class="col-sm-2 col-form-label">Nama Klinik</label>
                                                                    <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="nama_klinik" name="nama_klinik" value="<?=$value['nama_klinik']?>" placeholder="Masukkan Nama Klinik">
                                                                    <input type="hidden" class="form-control" id="klinik_id" name="klinik_id" value="<?=$value['id']?>">
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

                                                <button class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#hapusmodal<?=$value['id']?>"><i class="fas fa-trash"></i></button>
                                                <div class="modal" id="hapusmodal<?=$value['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Anda Yakin?</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <center><h5>Jika anda melanjutkan, maka klinik akan terhapus.</h5></center>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <a href="action/klinik_action.php?aksi=delete&id=<?=$value['id']?>" type="button" class="btn btn-danger">Hapus</a>
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
                <form action="action/klinik_action.php?aksi=create" method="POST">
                    <div class="modal-header">
                    <h5 class="modal-title">Tambah Klinik</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="nama_klinik" class="col-sm-2 col-form-label">Nama Klinik</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_klinik" name="nama_klinik" placeholder="Masukkan Nama Klinik">
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





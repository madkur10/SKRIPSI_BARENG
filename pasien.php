<?php 
session_start();
if(empty($_SESSION)){
    header('Location: login.php');
}
require_once "template/header.php"; 

$queryPasien		= "SELECT * from pasien where deleted_by is null order by nama_pasien asc";
$resPasien			= $conn->prepare($queryPasien);
$resPasien->execute();
$resultPasien		= $resPasien->fetchAll();

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
                                    <h4>Daftar Pasien</h4>
                                    </div>
                                    <div class="col-4 col-sm-4 text-end">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th><center>No.</center></th>
                                            <th>Nama Pasien</th>
                                            <th>No. Medical Record</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Alamat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list_user">
                                        <?php 
                                            $no = 0;
                                            foreach ($resultPasien as $key => $value) {
                                                $no++;
                                        ?>
                                        <tr>
                                            <td><center><?php echo $no;?></center></td>
                                            <td><?php echo $value['nama_pasien'];?></td>
                                            <td><?php echo $value['no_mr'];?></td>
                                            <td><?php echo date('d-m-Y', strtotime($value['tgl_lahir']));?></td>
                                            <td><?php echo $value['jenis_kelamin'];?></td>
                                            <td><?php echo $value['alamat'];?></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" onclick="showPasien('<?=$value['id']?>')"><i class="fas fa-eye"></i></button>

                                                <button class="btn btn-sm btn-warning" onclick="updatePasien('<?=$value['id']?>')"><i class="fas fa-edit"></i></button>
                                                <div class="modal fade" id="updatemodal<?=$value['id']?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <form id="updateData<?=$value['id']?>" method="POST" action="action/pasien_action.php">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Ubah Pasien</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="card-body">
                                                                            <div class="form-floating mb-3">
                                                                                <input class="form-control" id="namaLengkap" name="namaLengkap" value="<?=$value['nama_pasien']?>" required="true" />
                                                                                <input class="form-control" type="hidden" id="pasien_id" name="pasien_id" value="<?=$value['id']?>" />
                                                                                <label for="namaLengkap">Nama Lengkap <span style="color: red"> *</span></label>
                                                                            </div>
                                                                            <div class="form-floating mb-3">
                                                                                <input class="form-control" id="nomorIdentitas" value="<?=$value['no_identitas']?>" name="nomorIdentitas" />
                                                                                <label for="nomorIdentitas">NIK / KIA <span style="color: red"> *</span></label>
                                                                            </div>
                                                                            <div class="row mb-3">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-floating mb-3">
                                                                                        <input class="form-control" id="namaLengkap" name="no_mr" value="<?=$value['no_mr']?>" disabled required="true" />
                                                                                        <label for="namaLengkap">No. Medical Record <span style="color: red"> *</span></label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-floating mb-3">
                                                                                        <select class="form-select" name="jenisKelamin" id="jenisKelamin" required="true">
                                                                                            <option value="" selected>-- Pilih Jenis Kelamin --</option>
                                                                                            <option <?php if($value['jenis_kelamin'] == 'Laki-laki'){echo "selected";}?> value="Laki-laki">Laki-laki</option>
                                                                                            <option <?php if($value['jenis_kelamin'] == 'Perempuan'){echo "selected";}?> value="Perempuan">Perempuan</option>
                                                                                        </select>
                                                                                        <label for="jenisKelamin">Jenis Kelamin <span style="color: red"> *</span></label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row mb-3">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-floating mb-3 mb-md-0">
                                                                                        <input class="form-control" id="tempatLahir" type="text" name="tempatLahir" value="<?=$value['tempat_lahir']?>" required="true" />
                                                                                        <label for="tempatLahir">Tempat Lahir <span style="color: red"> *</span></label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-floating mb-3 mb-md-0">
                                                                                        <input class="form-control" id="tglLahir" type="date" name="tglLahir" value="<?php echo date('Y-m-d', strtotime($value['tgl_lahir']))?>" required="true" />
                                                                                        <label for="tglLahir">Tanggal Lahir <span style="color: red"> *</span></label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-floating mb-3">
                                                                                <input class="form-control" id="userEmail" type="email" name="userEmail" value="<?=$value['email']?>" required="true" />
                                                                                <label for="userEmail">Email address <span style="color: red"> *</span></label>
                                                                            </div>
                                                                            <div class="form-floating mb-3">
                                                                                <input class="form-control" id="nomorHandphone" type="text" name="nomorHandphone" value="<?=$value['no_hp']?>" required="true" />
                                                                                <label for="nomorHandphone">Nomor Handphone <span style="color: red"> *</span></label>
                                                                            </div>
                                                                            <div class="form-floating mb-3">
                                                                                <textarea class="form-control" required="true" name="alamatPasien"><?=$value['alamat']?></textarea>
                                                                                <label for="alamatPasien">Alamat Sesuai Domisili <span style="color: red"> *</span></label>
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
<?php require_once "template/footer.php"; ?>

<script>
    function showPasien(id) {
        $('#updatemodal'+id).modal('show');
        $('.form-control').prop('readonly', true);
        $('.form-select').prop('disabled', true);
        $('.modal-footer').hide();
    }

    function updatePasien(id) {
        $('#updatemodal'+id).modal('show');
        $('.form-control').prop('readonly', false);
        $('.form-select').prop('disabled', false);
        $('.modal-footer').show();
    }
</script>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Register - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">PENDAFTARAN PASIEN BARU</h3></div>
                                    <div class="card-body">
                                        <form method="POST" action="action/register-new-account.php">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="namaLengkap" name="namaLengkap" required="true" />
                                                <label for="namaLengkap">Nama Lengkap <span style="color: red"> *</span></label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="nomorIdentitas" name="nomorIdentitas" />
                                                <label for="nomorIdentitas">NIK / KIA <span style="color: red"> *</span></label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <select class="form-select" name="jenisKelamin" id="jenisKelamin" required="true">
                                                    <option value="" selected>-- Pilih Jenis Kelamin --</option>
                                                    <option value="Laki-laki">Laki-laki</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                </select>
                                                <label for="jenisKelamin">Jenis Kelamin <span style="color: red"> *</span></label>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="tempatLahir" type="text" name="tempatLahir" required="true" />
                                                        <label for="tempatLahir">Tempat Lahir <span style="color: red"> *</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="tglLahir" type="date" name="tglLahir" required="true" />
                                                        <label for="tglLahir">Tanggal Lahir <span style="color: red"> *</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="userEmail" type="email" name="userEmail" required="true" />
                                                <label for="userEmail">Email address <span style="color: red"> *</span></label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="nomorHandphone" type="text" name="nomorHandphone" required="true" />
                                                <label for="nomorHandphone">Nomor Handphone <span style="color: red"> *</span></label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <textarea class="form-control" required="true" name="alamatPasien"></textarea>
                                                <label for="alamatPasien">Alamat Sesuai Domisili <span style="color: red"> *</span></label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="password" type="text" name="password" required="true" />
                                                <label for="password">password <span style="color: red"> *</span></label>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><span class="btn btn-primary btn-block submit">DAFTAR</button></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="login.php">Sudah Memiliki Akun? Halaman Login</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
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
        <script src="js/all-main.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>

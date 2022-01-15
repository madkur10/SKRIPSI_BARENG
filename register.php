<?php include "template/header.php"; ?>
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
                                        <input class="form-control" id="nomorIdentitas" name="nomorIdentitas" onkeyup="checkNik(this)" />
                                        <label for="nomorIdentitas">NIK / KIA <span style="color: red"> *</span></label>
                                    </div>
                                    <div id="check-nik"></div>
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
                                        <input class="form-control" id="password" type="password" name="password" required="true" onkeyup="checkPassword()"/>
                                        <label for="password">Password <span style="color: red"> *</span></label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="re-password" type="password" name="re_password" required="true" onkeyup="checkPassword()" />
                                        <label for="repassword">Masukkan Ulang Password <span style="color: red"> *</span></label>
                                    </div>
                                    <div id="check-pass"></div>
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
<?php include "template/footer.php"; ?>

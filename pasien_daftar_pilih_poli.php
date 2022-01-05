<?php
session_start();
if(empty($_SESSION)){
    header('Location: login.php');
}

require_once "lib/koneksi.php";
require_once "lib/olah_table.php";

?>
<!DOCTYPE html>
<html lang="en">
    <?php require_once "lib/meta-head.php"; ?>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Start Bootstrap</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="action/logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <?php require_once "lib/nav.php"; ?>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Pendaftaran Layanan Telemedicine</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Mohon Pilih Klinik Yang Ingin Anda Tuju.</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        FORMULIR PENDAFTARAN KONSULTASI ONLINE
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="action/daftar-telemedicine.php">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" id="tglKonsultasi" type="date" name="tglKonsultasi" required="true" />
                                                <label for="tglKonsultasi">Pilih Tanggal Konsultasi</label>
                                            </div>
                                            <br>
                                            <div class="form-floating mb-3">
                                                <select class="form-select" name="klinikTujuan" id="klinikTujuan" required="true">
                                                    <option value="" selected>-- Pilih Klinik Tujuan --</option>
                                                </select>
                                                <label for="klinikTujuan">Pilih Klinik Tujuan</label>
                                            </div>
                                            <br>
                                            <div class="form-floating mb-3">
                                                <select class="form-select" name="dokterTujuan" id="dokterTujuan" required="true">
                                                    <option value="" selected>-- Pilih Dokter Tujuan --</option>
                                                </select>
                                                <label for="dokterTujuan">Pilih Dokter Tujuan</label>
                                            </div>
                                            <div class="mb-3">
                                                <label for="dokterTujuan">Pilih Slot Jam Konsultasi</label>
                                                <div class="row" style="padding-left: 12px;" id="divSlotDokter">
                                                    <div class="alert alert-danger" role="alert">
                                                        Slot Jam Konsultasi Online Akan Muncul Setelah Memilih Tanggal, Klinik Dan Dokter.
                                                    </div>
                                                </div>
                                            </div>

                                            <span class="btn btn-primary col-12 submit">DAFTAR</span>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <script>
                                $(`input[name=tglKonsultasi]`).on('change', function(){
                                    $.ajax({
                                        url: `action/ajaxData/getKlinik.php?tgl=${this.value}`,
                                        type: `GET`,
                                        dataType: 'json',
                                        success: function (result) {
                                            $(`select[name=klinikTujuan]`).html(`<option value="" selected>-- Pilih Klinik Tujuan --</option>`);

                                            if(result.metadata.code == 200){
                                                $.each(result.response, function(i, item) {
                                                    $(`select[name=klinikTujuan]`).append(`<option value='${item.id}'>${item.nama_klinik}</option>`);
                                                });  
                                            }                                    
                                        },
                                        error: function (error, text, code) {
                                            
                                        }
                                    });
                                });

                                $(`select[name=klinikTujuan]`).on('change', function(){
                                    $.ajax({
                                        url: `action/ajaxData/getJadwalDokter.php?tgl=${$(`input[name=tglKonsultasi]`).val()}&klinik=${$(`select[name=klinikTujuan]`).val()}`,
                                        type: `GET`,
                                        dataType: 'json',
                                        success: function (result) {
                                            $(`select[name=dokterTujuan]`).html(`<option value="" selected>-- Pilih Dokter Tujuan --</option>`);

                                            if(result.metadata.code == 200){
                                                $.each(result.response, function(i, item) {
                                                    $(`select[name=dokterTujuan]`).append(`<option value='${item.id}'>${item.nama_dokter}</option>`);
                                                });  
                                            }                     
                                        },
                                        error: function (error, text, code) {
                                            
                                        }
                                    });
                                });

                                $(`select[name=dokterTujuan]`).on('change', function(){
                                    $.ajax({
                                        url: `action/ajaxData/getDataJadwalDokter.php?tgl=${$(`input[name=tglKonsultasi]`).val()}&klinik=${$(`select[name=klinikTujuan]`).val()}&dokter_id=${$(`select[name=dokterTujuan]`).val()}`,
                                        type: `GET`,
                                        dataType: 'json',
                                        success: function (result) {
                                             if(result.metadata.code == 200){
                                                $(`#divSlotDokter`).html(``);
                                                $.each(result.response, function(i, item) {

                                                    if(item.status_selesai == 1){
                                                        $(`#divSlotDokter`).append(`
                                                            <span class="col-md-3 col-xs-12" style="background-color:#ffec45; border-radius:8px; margin-bottom: 5px;">
                                                                <input type="radio" disabled="true"/> ${item.jam_mulai} - ${item.jam_selesai}
                                                            </span> &nbsp;
                                                        `);
                                                    }

                                                    if(item.status_selesai == 2){
                                                        $(`#divSlotDokter`).append(`
                                                            <span class="col-md-3 col-xs-12" style="background-color:#ff1c1c; border-radius:8px; margin-bottom: 5px;">
                                                                <input type="radio" disabled="true"/> ${item.jam_mulai} - ${item.jam_selesai}
                                                            </span> &nbsp;
                                                        `);
                                                    }

                                                    if(item.status_selesai != 1 && item.status_selesai != 2){
                                                        $(`#divSlotDokter`).append(`
                                                            <span class="col-md-3 col-xs-12" style="background-color:#9adb5c; border-radius:8px; margin-bottom: 5px;" onclick="checkThisRadio(this)">
                                                                <input type="radio" name="jadwalDokter" value="${item.id}" /> ${item.jam_mulai} - ${item.jam_selesai}
                                                            </span> &nbsp;
                                                        `);
                                                    }
                                                });     
                                             }
                                        },
                                        error: function (error, text, code) {
                                            
                                        }
                                    });
                                });

                                function checkThisRadio(e){
                                    $(e).find(`input[type=radio]`).prop("checked", true);
                                }
                            </script>

                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    
                                    <div class="card-body">
                                        bisa diisi iklan untuk mempercantik
                                    </div>
                                </div>
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
        <script src="js/all-main.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>

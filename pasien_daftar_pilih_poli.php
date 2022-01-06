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
    <?php require_once "template/header.php"; ?>
    <body class="sb-nav-fixed">
        <?php require_once "lib/navtop.php"; ?>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <?php require_once "lib/navside.php"; ?>
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
                                        <div class="row px-3 justify-content-center mt-4 mb-5 border-line">
                                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-indicators">
                                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                </div>
                                                <div class="carousel-inner">
                                                    <div class="carousel-item active">
                                                        <img src="assets/img/carousel_1.jpg" class="d-block w-100 carouselsize" alt="...">
                                                    </div>
                                                    <div class="carousel-item">
                                                        <img src="assets/img/carousel_2.jpg" class="d-block w-100 carouselsize" alt="...">
                                                    </div>
                                                    <div class="carousel-item">
                                                        <img src="assets/img/carousel_3.jpg" class="d-block w-100 carouselsize" alt="...">
                                                    </div>
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>
                                        </div>
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
<?php require_once "template/footer.php"; ?>

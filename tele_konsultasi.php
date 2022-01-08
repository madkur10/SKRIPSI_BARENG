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
                        <h1 class="mt-4">Telemedicine Dokter</h1>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        LAYANAN KONSULTASI ONLINE
                                    </div>
                                    <div class="card-body">
                                        <iframe id="myIframe" scrolling="no" src="jitsi.php?uuid=<?=$_GET['uuid']?>" width="100%" height="1000px"></iframe>
                                    </div>
                                </div>
                            </div>

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

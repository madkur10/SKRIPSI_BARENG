<?php include "template/header.php"; ?>
    <body>
        <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
            <div class="card card0 border-0">
                <div class="row d-flex">
                    <div class="row col-12"> <img src="assets/img/header.png"> </div>
                    <div class="col-lg-6">
                        <div class="card1 pb-5">
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
                    <div class="col-lg-6">
                        <div class="card2 card border-0 px-4 py-5">
                            <div class="row mb-2 px-3">
                                <h5>Login Telemedicine - Rs Pelni</h5>
                            </div>
                            <div class="row px-3 mb-4">
                                <div class="line"></div>
                                <div class="line"></div>
                            </div>
                            <form method="post" action="action/login.php">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="username" name="username" type="text" placeholder="Username" />
                                    <label for="username">Username</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="password" name="password" type="password" placeholder="Password" />
                                    <label for="password">Password</label>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <span class="btn btn-primary col-12 submit">Login</span>
                                </div>
                            </form>
                            <div class="card-footer text-center py-3">
                                <div class="small"><a href="register.php">Belum Memiliki Akun? Daftar!</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="layoutAuthentication_footer">
                    <footer class="py-1 bg-light mt-auto">
                        <div class="container-fluid">
                            <div class="d-flex align-items-center justify-content-between small">
                                <div class="text-muted">Copyright &copy; Your Website 2021</div>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
<?php include "template/footer.php"; ?>

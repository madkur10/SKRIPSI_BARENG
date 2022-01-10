<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-footer">
        <div class="small">Hai, Selamat Datang!</div>
        <?php echo $_SESSION['fullname']?>
    </div>
    <div class="sb-sidenav-menu">
        <div class="nav">
            <?php
            if($_SESSION['hak_akses'] == 1){
            ?>
            <div class="sb-sidenav-menu-heading">Role Administrator</div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                Administrator
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="users.php">Users</a>
                    <a class="nav-link" href="klinik.php">Klinik</a>
                    <a class="nav-link" href="hak_akses.php">Hak Akses</a>
                    <a class="nav-link" href="dokter.php">Dokter</a>
                </nav>
            </div>
            <?php } ?>

            <?php
            if($_SESSION['hak_akses'] == 3){
            ?>
            <div class="sb-sidenav-menu-heading">Role Registrasi</div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#registrasi" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                Registrasi
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="registrasi" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="pasien.php">Pasien</a>
                    <a class="nav-link" href="jadwal_dokter.php">Jadwal Dokter</a>
                    <a class="nav-link" href="riwayat_pendaftaran_pasien.php">Riwayat Pendaftaran</a>
                </nav>
            </div>
            <?php } ?>

            <?php
            if($_SESSION['hak_akses'] == 2){
            ?>
            <div class="sb-sidenav-menu-heading">Role Pasien</div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pasienregis" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                Layanan
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="pasienregis" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="pasien_daftar_pilih_poli.php">Konsultasi Online</a>
                    <a class="nav-link" href="list_order_pasien.php">Riwayat Konsultasi</a>
                </nav>
            </div>
            <?php } ?>

            <?php
            if($_SESSION['hak_akses'] == 5){
            ?>
            <div class="sb-sidenav-menu-heading">Role Kasir</div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#kasir" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                Pembayaran Pasien
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="kasir" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="kasir_konfirmasi_pembayaran.php">List Pembayaran Pasien</a>
                </nav>
            </div>
            <?php } ?>

            <?php
            if($_SESSION['hak_akses'] == 4){
            ?>
            <div class="sb-sidenav-menu-heading">Role Dokter</div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#dokter" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                Telekonsultasi
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="dokter" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="incoming_telekonsultasi.php">Incoming</a>
                    <a class="nav-link" href="incoming_telekonsultasi.php?histori=true">Riwayat Konsultasi</a>
                </nav>
            </div>
            <?php } ?>
        </div>
    </div>
</nav>
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="logo-utama navbar-brand ps-3" href="index.php"><strong>TELEMEDICINE</strong></a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#!" data-bs-toggle="modal" data-bs-target="#settingProfile<?=$_SESSION['users_id']?>">Settings</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" href="../action/logout.php">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>

<div class="modal fade" id="settingProfile<?php echo $_SESSION['users_id']?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form action="action/users_action.php?aksi=update&tipe=logout" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Setting Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-user fa-10x"></i>
                    </div>
                    <br>
                    <div class="mb-3 row">
                        <label for="nama_lengkap" class="col-sm-2 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" readonly value="<?php echo  $_SESSION['fullname']?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $_SESSION['user_name']?>">
                        </div>
                    </div>  
                    <div class="mb-3 row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="password" name="password" value="<?php echo $_SESSION['password']?>">
                            <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $_SESSION['users_id']?>">
                            <input type="hidden" class="form-control" id="hak_akses_id" name="hak_akses_id" value="<?php echo $_SESSION['hak_akses']?>">
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
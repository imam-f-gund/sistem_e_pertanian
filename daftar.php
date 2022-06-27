<?php
$page = "detail.php";
$title = "Daftar Akun";
?>

<?php include 'layouts/header.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">


    <!-- DataTales Example -->

    <div class="card shadow mt-4">
        <div id="notif"></div>
        <!-- Page Heading -->
        <div class="text-center">
            <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
        </div>
        <form class="mt-5" action="eksekutor.php" method="post">
            <div class="row">
                <div class="col-md-10">
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-4 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-7">
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-4 col-form-label">username</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-4 col-form-label">password</label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                    </div>
                    <div class="col-md-12 justify-content-center d-flex align-items-center">

                        <div class="col-md">
                            <button type="submit" class="btn btn-success btn-lg">Daftar</button>
                        </div>

                        <div class="col-md-0">
                            <a href="" class="btn btn-secondary btn-lg">Hapus</a>
                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>

    <?php include 'layouts/footer.php'; ?>
    <script>
        console.log("Hello World!");


        var notif = localStorage.getItem("notif");
        if (notif == "true") {
            $('#notif').append('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error! </strong>Pendaftaran gagal mohon masukan email dengan benar<button type="button" class="close" id="closed" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
        $(".close").click(function() {
            localStorage.clear();
        });
    </script>z
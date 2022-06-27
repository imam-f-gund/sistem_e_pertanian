<?php
    include 'includes.php';
    
    $page = "informasi-bank.php";
    $title = "Informasi Bank";
    $now = date('Y-m-d');

    if($_POST){
        if($_POST['method'] == 'tambah'){

            $sql = "INSERT INTO informasi (nama, keterangan, id_jenis_informasi , date) VALUES ('".$_POST['nama']."', '".$_POST['keterangan']."', 3, '".tanggal_indo($now)."')";

            $result = $mysqli->query($sql);
            header("location: informasi-bank.php", true, 301);
        }elseif($_POST['method'] == 'hapus'){
            $sql = "DELETE FROM informasi WHERE id=".$_POST['id']."";
            $result = $mysqli->query($sql);
            header("location: informasi-bank.php", true, 301);
        }else{
            $sql = "UPDATE informasi SET nama='".$_POST['nama']."', keterangan='".$_POST['keterangan']."', date='".tanggal_indo($now)."' WHERE id=".$_POST['id']."";
            
            $result = $mysqli->query($sql);
            header("location: informasi-bank.php", true, 301);
        }
    }

    $sql = "SELECT informasi.* FROM informasi WHERE id_jenis_informasi=3 LIMIT 1";

    $result = $mysqli->query($sql);

    $informasi = $result->fetch_assoc();

    $mysqli -> close();
?>

<?php include 'layouts/header.php';?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <!-- DataTales Example -->
    <div class="card shadow mt-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <!-- Button trigger modal -->
                <?php
                    if($informasi['nama']){
                        
                    }else{
                        echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                Tambah (+)
                            </button>';
                    }
                ?>
            </h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Keterangan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($informasi['nama']): ?>
                        <tr>
                            <td><?= $informasi['nama'] ?></td>
                            <td><?= $informasi['keterangan'] ?></td>
                            <td><?= $informasi['date'] ?></td>
                            <td>
                                <button id="edit" type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editmodal" data-val="<?= $informasi['id'] ?>|<?= $informasi['nama'] ?>|<?= $informasi['keterangan']; ?>"><i class="fa fa-edit"></i></button>
                                <form class="d-inline" action="" method="post">
                                    <input type="hidden" name="method" value="hapus">
                                    <input type="hidden" name="id" value="<?= $informasi['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="method" value="tambah">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <textArea type="text" name="keterangan" id="keterangan" class="form-control"></textArea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="method" value="update">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" name="nama" id="edit_nama" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <textArea type="text" name="keterangan" id="edit_keterangan" class="form-control"></textArea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php include 'layouts/footer.php';?>

<script>
    $(document).on('click','#edit',function(){
        val = $(this).data('val').split('|');

        $('#edit_id').val(val[0]);
        $('#edit_nama').val(val[1]);
        $('#edit_keterangan').val(val[2]);
    }); 
</script>
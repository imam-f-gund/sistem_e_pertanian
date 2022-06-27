<?php
    include 'includes.php';

    $page = "kategori.php";
    $title = "Kategori";    
    $now = date('Y-m-d');

    if($_POST){
        if($_POST['method'] == 'tambah'){
            $sql = "INSERT INTO jenis_produk (nama, satuan, date) VALUES ('".$_POST['nama']."', '".$_POST['satuan']."', '".tanggal_indo($now)."')";
            $result = $mysqli->query($sql);
            header("location: kategori.php", true, 301);
        }elseif($_POST['method'] == 'hapus'){
            $sql = "DELETE FROM jenis_produk WHERE id=".$_POST['id']."";
            $result = $mysqli->query($sql);
            header("location: kategori.php", true, 301);
        }else{
            $sql = "UPDATE jenis_produk SET nama='".$_POST['nama']."', satuan='".$_POST['satuan']."' WHERE id=".$_POST['id']."";
            $result = $mysqli->query($sql);
            header("location: kategori.php", true, 301);
        }
    }

    $sql = "SELECT * FROM jenis_produk";
    $result = $mysqli->query($sql);

    $kategoris = [];
    while($row = $result->fetch_assoc()) {
        $kategoris[] = $row;
    }

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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Tambah (+)
                </button>
            </h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Jenis Produk</th>
                        <th>Satuan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($kategoris as $key => $kategori): ?>
                        <tr>
                            <td><?= $key+1; ?></td>
                            <td><?= $kategori['nama']; ?></td>
                            <td><?= $kategori['satuan']; ?></td>
                            <td><?= $kategori['date']; ?></td>
                            <td>
                                <button id="edit" type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editmodal" data-val="<?= $kategori['id'] ?>|<?= $kategori['nama'] ?>|<?= $kategori['satuan'] ?>"><i class="fa fa-edit"></i></button>
                                <form class="d-inline" action="" method="post">
                                    <input type="hidden" name="method" value="hapus">
                                    <input type="hidden" name="id" value="<?= $kategori['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
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
                            <label for="">Jenis Produk</label>
                            <input type="text" name="nama" id="jenis" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Satuan</label>
                            <input type="text" name="satuan" id="satuan" class="form-control">
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
        <div class="modal-dialog">
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
                            <label for="">Jenis Produk</label>
                            <input type="text" name="nama" id="edit_jenis" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Satuan</label>
                            <input type="text" name="satuan" id="edit_satuan" class="form-control">
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
        console.log(val);

        $('#edit_id').val(val[0]);
        $('#edit_jenis').val(val[1]);
        $('#edit_satuan').val(val[2]);
    }); 
</script>
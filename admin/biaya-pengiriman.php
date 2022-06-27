<?php
    include 'includes.php';
    
    $page = "biaya-pengiriman.php";
    $title = "Biaya Pengiriman";
    $now = date('Y-m-d');

    if($_POST){
        if($_POST['method'] == 'tambah'){

            $sql = "INSERT INTO jasa_pengiriman (nama, keterangan, biaya, berat, date) VALUES ('".$_POST['nama']."', '".$_POST['keterangan']."', '".$_POST['biaya']."', '".$_POST['berat']."', '".tanggal_indo($now)."')";

            $result = $mysqli->query($sql);
            header("location: biaya-pengiriman.php", true, 301);
        }elseif($_POST['method'] == 'hapus'){
            $sql = "DELETE FROM jasa_pengiriman WHERE id=".$_POST['id']."";
            $result = $mysqli->query($sql);
            header("location: biaya-pengiriman.php", true, 301);
        }else{
            $sql = "UPDATE jasa_pengiriman SET nama='".$_POST['nama']."', keterangan='".$_POST['keterangan']."', biaya='".$_POST['biaya']."', berat='".$_POST['berat']."', date='".tanggal_indo($now)."' WHERE id=".$_POST['id']."";
            
            $result = $mysqli->query($sql);
            header("location: biaya-pengiriman.php", true, 301);
        }
    }

    $sql = "SELECT * FROM jasa_pengiriman";

    $result = $mysqli->query($sql);

    $pengirimans = [];
    
    while($row = $result->fetch_assoc()) {
        $pengirimans[] = $row;
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
                        <th>Nama</th>
                        <th>Keterangan</th>
                        <th>Biaya</th>
                        <th>Berat</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($pengirimans as $pengiriman): ?>
                        <tr>
                            <td><?= $pengiriman['nama'] ?></td>
                            <td><?= $pengiriman['keterangan'] ?></td>
                            <td><?= rupiah($pengiriman['biaya']) ?></td>
                            <td><?= $pengiriman['berat'] ?></td>
                            <td><?= $pengiriman['date'] ?></td>
                            <td>
                                <button id="edit" type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editmodal" data-val="<?= $pengiriman['id'] ?>|<?= $pengiriman['nama'] ?>|<?= $pengiriman['keterangan']; ?>|<?= $pengiriman['biaya'] ?>|<?= $pengiriman['berat'] ?>"><i class="fa fa-edit"></i></button>
                                <form class="d-inline" action="" method="post">
                                    <input type="hidden" name="method" value="hapus">
                                    <input type="hidden" name="id" value="<?= $pengiriman['id'] ?>">
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
                        <div class="form-group">
                            <label for="">Biaya</label>
                            <input type="text" name="biaya" id="biaya" class="form-control"></input>
                        </div>
                        <div class="form-group">
                            <label for="">Berat</label>
                            <input type="text" name="berat" id="berat" class="form-control"></input>
                            <small>Satuan Kg</small>
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
                        <div class="form-group">
                            <label for="">Biaya</label>
                            <input type="text" name="biaya" id="edit_biaya" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Berat</label>
                            <input type="text" name="berat" id="edit_berat" class="form-control">
                            <small>Satuan Kg</small>
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
        $('#edit_biaya').val(val[3]);
        $('#edit_berat').val(val[4]);
    }); 
</script>
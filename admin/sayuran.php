<?php
    include 'includes.php';

    $page = "sayuran.php";
    $title = "Sayuran";

    $now = date('Y-m-d');

    if($_POST){
        if($_POST['method'] == 'tambah'){

            $output_dir = "../asset/upload/";/* Path for file upload */
            $RandomNum = time();
            $ImageName = str_replace(' ','-',strtolower($_FILES['file']['name'][0]));
            $ImageType = $_FILES['file']['type'][0];
        
            $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
            $ImageExt = str_replace('.','',$ImageExt);
            $ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
            $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;
            $ret[$NewImageName]= $output_dir.$NewImageName;
            
            /* Try to create the directory if it does not exist */
            if (!file_exists($output_dir))
            {
                @mkdir($output_dir, 0777);
            }               
            
            move_uploaded_file($_FILES["file"]["tmp_name"][0],$output_dir."/".$NewImageName );

            $sql = "INSERT INTO produk (nama, keterangan, harga, id_jenis_produk, stok, date, file) VALUES ('".$_POST['nama']."', '".$_POST['keterangan']."', ".$_POST['harga'].", ".$_POST['id_jenis_produk'].", ".$_POST['stok'].", '".tanggal_indo($now)."', '".$NewImageName."')";

            $result = $mysqli->query($sql);
            header("location: sayuran.php", true, 301);
        }elseif($_POST['method'] == 'hapus'){
            $getq = "SELECT * FROM produk WHERE id=".$_POST['id']." LIMIT 1";
            $result = $mysqli->query($getq);
            $get = $result->fetch_assoc();
            unlink("../asset/upload/".$get['file']);
            $sql = "DELETE FROM produk WHERE id=".$_POST['id']."";
            $result = $mysqli->query($sql);
            header("location: sayuran.php", true, 301);
        }else{
            $getq = "SELECT * FROM produk WHERE id=".$_POST['id']." LIMIT 1";
            $result = $mysqli->query($getq);
            $get = $result->fetch_assoc();

            if($_FILES['file']['name'][0] != NULL){
                unlink("../asset/upload/".$get['file']);
                $output_dir = "../asset/upload/";/* Path for file upload */
                $RandomNum = time();
                $ImageName = str_replace(' ','-',strtolower($_FILES['file']['name'][0]));
                $ImageType = $_FILES['file']['type'][0];
            
                $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
                $ImageExt = str_replace('.','',$ImageExt);
                $ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;
                $ret[$NewImageName]= $output_dir.$NewImageName;
                
                /* Try to create the directory if it does not exist */
                if (!file_exists($output_dir))
                {
                    @mkdir($output_dir, 0777);
                }               
                
                move_uploaded_file($_FILES["file"]["tmp_name"][0],$output_dir."/".$NewImageName );
                $sql = "UPDATE produk SET nama='".$_POST['nama']."', keterangan='".$_POST['keterangan']."', harga='".$_POST['harga']."', id_jenis_produk='".$_POST['id_jenis_produk']."', stok='".$_POST['stok']."', date='".tanggal_indo($now)."', file='".$NewImageName."' WHERE id=".$_POST['id']."";
            }else{
                $sql = "UPDATE produk SET nama='".$_POST['nama']."', keterangan='".$_POST['keterangan']."', harga='".$_POST['harga']."', id_jenis_produk='".$_POST['id_jenis_produk']."', stok='".$_POST['stok']."', date='".tanggal_indo($now)."' WHERE id=".$_POST['id']."";
            }
            
            $result = $mysqli->query($sql);
            header("location: sayuran.php", true, 301);
        }
    }

    $sql = "SELECT produk.*, jenis_produk.nama as jenis_produk FROM produk INNER JOIN jenis_produk ON jenis_produk.id=produk.id_jenis_produk";
    $sql_jenis_produk = "SELECT * FROM jenis_produk ORDER BY nama";

    $result = $mysqli->query($sql);
    $result_jenis_produk = $mysqli->query($sql_jenis_produk);

    $produks = [];
    while($row = $result->fetch_assoc()) {
        $produks[] = $row;
    }

    $jenis_produks = [];
    while($row_jenis_produk = $result_jenis_produk->fetch_assoc()) {
        $jenis_produks[] = $row_jenis_produk;
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
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Keterangan</th>
                        <th>Harga</th>
                        <th>Jenis Produk</th>
                        <th>Stok</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($produks as $key => $produk): ?>
                        <tr>
                            <td><?= $key+1; ?></td>
                            <td><img src="../asset/upload/<?= $produk['file']; ?>" alt="" style="max-width:100px;"></td>
                            <td><?= $produk['nama']; ?></td>
                            <td><?= $produk['keterangan']; ?></td>
                            <td><?= rupiah($produk['harga']); ?></td>
                            <td><?= $produk['jenis_produk']; ?></td>
                            <td><?= $produk['stok']; ?></td>
                            <td><?= $produk['date']; ?></td>
                            <td>
                                <button id="edit" type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editmodal" data-val="<?= $produk['id'] ?>|<?= $produk['nama'] ?>|<?= $produk['keterangan']; ?>|<?= $produk['harga']; ?>|<?= $produk['id_jenis_produk']; ?>|<?= $produk['stok']; ?>"><i class="fa fa-edit"></i></button>
                                <form class="d-inline" action="" method="post">
                                    <input type="hidden" name="method" value="hapus">
                                    <input type="hidden" name="id" value="<?= $produk['id'] ?>">
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
                <form action="" method="post" enctype="multipart/form-data">
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
                            <label for="">Harga</label>
                            <input type="text" name="harga" id="harga" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Jenis Produk</label>
                            <select type="text" name="id_jenis_produk" id="id_jenis_produk" class="form-control">
                                <option value="">Silahkan Pilih</option>
                                <?php foreach($jenis_produks as $jenis_produk): ?>
                                    <option value="<?= $jenis_produk['id']?>"><?= $jenis_produk['nama']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Stok</label>
                            <input type="text" name="stok" id="stok" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Gambar</label>
                            <input type="file" name="file[]" id="file" class="form-control">
                            <small>Upload gambar dengan ukuran 1:1 atau persegi</small>
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
                <form action="" method="post" enctype="multipart/form-data">
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
                            <label for="">Harga</label>
                            <input type="text" name="harga" id="edit_harga" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Jenis Produk</label>
                            <select type="text" name="id_jenis_produk" id="edit_id_jenis_produk" class="form-control">
                                <option value="">Silahkan Pilih</option>
                                <?php foreach($jenis_produks as $jenis_produk): ?>
                                    <option value="<?= $jenis_produk['id']?>"><?= $jenis_produk['nama']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Stok</label>
                            <input type="text" name="stok" id="edit_stok" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Gambar</label>
                            <input type="file" name="file[]" id="file" class="form-control">
                            <small>Upload gambar dengan ukuran 1:1 atau persegi</small>
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
        $('#edit_harga').val(val[3]);
        $('#edit_id_jenis_produk').val(val[4]);
        $('#edit_stok').val(val[5]);
    }); 
</script>
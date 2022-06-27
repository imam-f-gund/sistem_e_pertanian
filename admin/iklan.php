<?php
    include 'includes.php';

    $page = "iklan.php";
    $title = "Iklan";

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

            $sql = "INSERT INTO iklan (keterangan, date, file) VALUES ('".$_POST['keterangan']."', '".tanggal_indo($now)."', '".$NewImageName."')";

            $result = $mysqli->query($sql);
            header("location: iklan.php", true, 301);
        }elseif($_POST['method'] == 'hapus'){
            $getq = "SELECT * FROM iklan WHERE id=".$_POST['id']." LIMIT 1";
            $result = $mysqli->query($getq);
            $get = $result->fetch_assoc();
            unlink("../asset/upload/".$get['file']);
            $sql = "DELETE FROM iklan WHERE id=".$_POST['id']."";
            $result = $mysqli->query($sql);
            header("location: iklan.php", true, 301);
        }elseif($_POST['method'] == 'utama'){
            $sqls = "UPDATE iklan SET status='none', date='".tanggal_indo($now)."' WHERE status='utama'";
            $sql = "UPDATE iklan SET status='utama', date='".tanggal_indo($now)."' WHERE id=".$_POST['id']."";
            $result = $mysqli->query($sqls);
            $results = $mysqli->query($sql);
            header("location: iklan.php", true, 301);
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
                $sql = "UPDATE iklan SET keterangan='".$_POST['keterangan']."', date='".tanggal_indo($now)."', file='".$NewImageName."' WHERE id=".$_POST['id']."";
            }else{
                $sql = "UPDATE iklan SET keterangan='".$_POST['keterangan']."', date='".tanggal_indo($now)."' WHERE id=".$_POST['id']."";
            }
            
            $result = $mysqli->query($sql);
            header("location: iklan.php", true, 301);
        }
    }

    $sql = "SELECT iklan.* FROM iklan";

    $result = $mysqli->query($sql);

    $iklans = [];
    while($row = $result->fetch_assoc()) {
        $iklans[] = $row;
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
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($iklans as $key => $iklan): ?>
                        <tr>
                            <td><?= $key+1; ?></td>
                            <td><img src="../asset/upload/<?= $iklan['file']; ?>" alt="" style="max-width:100px;"></td>
                            <td><?= $iklan['keterangan']; ?></td>
                            <td>
                                <?php 
                                    if($iklan['status'] == 'utama') {
                                        echo $iklan['status'];
                                    }else{
                                        echo '<form class="d-inline" action="" method="post">
                                        <input type="hidden" name="method" value="utama">
                                        <input type="hidden" name="id" value="'.$iklan['id'].'">
                                        <button type="submit" class="btn btn-primary btn-sm">Jadikan Utama</button>
                                    </form>';
                                    }
                                ?>
                            </td>
                            <td><?= $iklan['date']; ?></td>
                            <td>
                                <button id="edit" type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editmodal" data-val="<?= $iklan['id'] ?>|<?= $iklan['keterangan']; ?>"><i class="fa fa-edit"></i></button>
                                <form class="d-inline" action="" method="post">
                                    <input type="hidden" name="method" value="hapus">
                                    <input type="hidden" name="id" value="<?= $iklan['id'] ?>">
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
                            <label for="">Gambar</label>
                            <input type="file" name="file[]" id="file" class="form-control">
                            <small>Ukuran : 1208px X 350px </small>
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
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="method" value="update">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="form-group">
                            <label for="">Gambar</label>
                            <input type="file" name="file[]" id="edit_file" class="form-control">
                            <small>Ukuran : 1208px X 350px </small>
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
        $('#edit_keterangan').val(val[1]);
    }); 
</script>
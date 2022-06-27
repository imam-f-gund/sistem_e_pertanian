<?php
session_start();
if(!isset($_SESSION['id'])){
    header("location:login.php");
}
//  var_dump(!isset($_SESSION['id']));
include 'db/database.php';



    $ids = $_SESSION['id'];
    $sql_det = "select detail.alamat_lengkap, detail.kode_pos, detail.no_telpon, detail.id, user.nama_lengkap from detail INNER JOIN user on detail.id_user = user.id where detail.id_user='$ids'";
    $result_detail = $mysqli->query($sql_det);
    $row_user = $result_detail->fetch_assoc();

    $id_detail = $row_user['id'];
    
?>
<?php
    $page = "pesanan.php";
    $title = "Pesanan";
?>

<?php include 'layouts/header.php';?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <!-- DataTales Example -->
    <div class="card shadow mt-4">

    <div id="notif"></div>
    
    <section id="content" class="mt-5">
        <div class="container ">
            <div class="row">
                <div class="card-body">
                  <label for="" ><strong>keranjang</strong></label>
                  <div class="card-body">
            <table class="table table-bordered" >
                <thead>
                    <tr>
                        <th>Tanggal Pesanan</th>
                        <th>Status</th>
                        <th>Ongkir</th>
                        <th>Total Bayar</th>
                        <th>Jasa</th>
                        <th>Produk</th>
                        <th>Detail Pesanan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $data = "select produk.nama as produk, transaksi.id, transaksi.ongkir, transaksi.date, transaksi.status, transaksi.jml_order, transaksi.jml_bayar, transaksi.total_bayar, informasi.nama, transaksi.id_kota,transaksi.id_produk, detail.alamat_lengkap, detail.kode_pos,detail.no_telpon, jasa_pengiriman.nama as jasa from ((((transaksi INNER JOIN detail on transaksi.id_detail = detail.id) INNER JOIN produk ON transaksi.id_produk = produk.id) INNER JOIN informasi ON transaksi.id_informasi = informasi.id)LEFT JOIN jasa_pengiriman ON transaksi.id_jasa_pengiriman = jasa_pengiriman.id) where transaksi.id_detail = $id_detail ";
                    
                    $row = $mysqli->query($data);
                    $no = 1;
                           
                    if ($row->num_rows > 0) {

                        // output data of each row
                        while($rows = $row->fetch_assoc()) { 
                            $id_det = $rows['id'];
                            $status = "select * from pembayaran where id_transaksi = '$id_det'";
                            $result_status = $mysqli->query($status);
                            $row_status =  $result_status->fetch_assoc();
                    
                        ?>
                        <tr>
                            <td><?= $rows['date'] ?></td>
                            <td><?= $rows['status'] ?></td>
                            <td>Rp.<?= $rows['ongkir'] ?></td>
                            <td>Rp.<?= $rows['ongkir']+$rows['jml_bayar'] ?></td>
                            <td><?= $rows['jasa'] ?></td>
                            <td><?= $rows['produk'] ?></td>
                             <td><a href="keranjang.php?kota=<?php echo $rows['id_kota'];?>&id_produk=<?php echo $rows['id_produk'];?>&jml_produk=<?php echo $rows['jml_order'];?>&detail=true&ongkir=<?php echo $rows['ongkir'];?>&jasa=<?php echo $rows['jasa'];?>">detail pesanan</a></td>
                            <?php if (isset($row_status)) {?>
                            <td><?php if ($rows['status'] == 'selesai') {?>

                            <button id="" type="button" class="btn btn-warning btn-sm btnshow" data-toggle="modal" data-target="#show" value="<?php echo $row_status['id'].'|'.$row_status['file'].'|'.$row_status['tgl_bayar'].'|'.$row_status['keterangan'].'|'.$row_status['id_transaksi'];?>">Detail</button>

                            <?php }else{ echo '<div><button id="btndetail" type="button" class="btn btn-warning btn-sm btnshow" data-toggle="modal" data-target="#show" value="'.$row_status['id'].'|'.$row_status['file'].'|'.$row_status['tgl_bayar'].'|'.$row_status['keterangan'].'|'.$row_status['id_transaksi'].'">Detail</button></div>'; }?>
                            </td>

                            <?php }else if(isset($rows['ongkir'])){?>

                            <td>
                            <button type="button" class="btn btn-primary btn-sm btnbayar" value="<?= $rows['id'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Bayar
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                             <div>
                                <form action="bayar.php"  method="post" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        
                                        <input type="hidden" name="id_transaksi" value="<?= $rows['id'] ?>">
                                        <div class="form-group">
                                            <label for="">Upload Bukti</label>
                                            <input type="file" name="file[]" id="file" class="form-control" accept="image/png, image/jpeg" >
                                         
                                        
                                        </div>
                                        <div class="form-group">
                                            <label for="">Tanggal Bayar</label>
                                            <input type="text" name="tgl_bayar" id="tgl_bayar" class="form-control">
                                        </div> <div class="form-group">
                                            <label for="">Nomer Rekening Pengirim/Nomer Nota Pembayaran</label>
                                            <textArea type="text" name="keterangan" id="keterangan" class="form-control"></textArea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Lanjutkan</button>
                                    </div>
                                </form>
                             </div>
                            </div>
                            </div>
                            </td>

                            <?php  }else{?>
                                <td>
                                Menghitung biaya ongkir...
                                </td>
                            <?php  }?>
                        </tr>
                        
                    <?php }} ?>
                </tbody>
            </table>
        </div>
                </div>
            </div>
        </div>
    </section>  

    <div class="modal fade" id="show" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <strong>Tanggal Bayar </strong><p id="tgl_bayars"></p><hr>
                    <strong>Nomer Rekening Pengirim/Nomer Nota Pembayaran </strong><p id="keterangans"></p><hr>
                    <strong>Bukti </strong><div id="img"></div>
                </div>
                <!-- <form action="" method="post">
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
                </form> -->
            </div>
        </div>
    </div>
   

    <?php include 'layouts/footer.php';?>
    <script>
        // console.log("Hello World!");
        $("#kota_s").hide();
        $("#prov").on( "click", function() { 
            localStorage.setItem('prov','true');
            $("#prov").hide();
        }) 
        $("#btnkota").on( "click", function() { 
           
            $("#kota_s").hide();

        });
        $("#refres").on( "click", function() { 
            localStorage.removeItem('prov');
            localStorage.removeItem('isian');
            $("#prov").show();
            $("#kota_s").hide();
        });
        
        var da =  localStorage.getItem('prov'); 
        var isi =  localStorage.getItem('isian');
      
        if (da == 'true') {
            $("#prv").text(isi);
            $("#kota_s").show();
            $("#prov").hide();
           
        }

        $(".btnshow").on( "click", function() {
            
        var data = $(this).attr('value');
        data = data.split('|');
       
        //  alert(data[0]);
 
        $("#id").val(data[0]);
        $("#img").html('<img src="asset/upload/'+data[1]+'" alt="" style="width:380px;height:380px;">');
        $("#tgl_bayars").text(data[2]);
        $("#keterangans").text(data[3]);
        $("#id_transaksi").text(data[4]);
        // $("#keterangan").text(data[5]);
        // $("#stok").text(data[6]);

        });
        $(".btnbayar").on( "click", function() {

        var data = $(this).attr('value');
        data = data.split('|');
        // alert(data[0]);
        //  console.log(data);
 
        $("#id_transaksi").val(data[0]);
        });
            
     var notif = localStorage.getItem("notif");
        if (notif == "true") {
          $('#notif').append('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Segera lakukan pembayaran.<button type="button" class="close" id="closed" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }else if(notif == "success") {
          $('#notif').append('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Menunggu Verifikasi Pembayaran.<button type="button" class="close" id="closed" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
        $(".close").click(function(){
          localStorage.clear();
        });

    </script>
   


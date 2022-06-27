<?php
session_start();
if(!isset($_SESSION['id'])){
    header("location:login.php");
}
include 'db/database.php';

if(empty($_GET['jml_produk'])){
    header("location:index.php");
}

if(isset($_GET['detail'])){
   echo "<script>localStorage.setItem('adress','true');</script>";
   $jasa = $_GET['jasa'];
   $ongkir = $_GET['ongkir'];
   
}
   
    $ids = $_SESSION['id'];
    $sql_det = "select detail.alamat_lengkap, detail.kode_pos, detail.no_telpon, detail.id, user.nama_lengkap from detail INNER JOIN user on detail.id_user = user.id where detail.id_user='$ids'";
    $result_detail = $mysqli->query($sql_det);
    $row_user = $result_detail->fetch_assoc();

    $date = date("Y-m-d"); 
    $id_produk = $_GET['id_produk'];
       
    $jumlah_beli =$_GET["jml_produk"];
    $sql = "select produk.nama, produk.id, produk.stok, produk.harga, jenis_produk.nama as jenis, jenis_produk.satuan from produk INNER JOIN jenis_produk on produk.id_jenis_produk = jenis_produk.id where produk.id = '$id_produk'";
    
    $result_conten = $mysqli->query($sql);
    $row_produk = $result_conten->fetch_assoc();

    if (isset($_GET['provinsi'])) {
        $id_provinsi =  $_GET['provinsi'];
    } 
    if (isset($_GET['kota'])) {
        $id_kota =  $_GET['kota'];
        $res_kota = "select kota.nama, kota.id, provinsi.nama as provinsi from kota INNER JOIN provinsi on kota.id_provinsi = provinsi.id where kota.id = '$id_kota'";
        $kota_s = $mysqli->query($res_kota);
        $row_kota = $kota_s->fetch_assoc();
    } 
// var_dump($row_produk);
?>
<?php
    $page = "keranjang.php";
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
    <?php  $info_bank = "select * from informasi where id_jenis_informasi = 3"; $result_info = $mysqli->query($info_bank);
    $info = $result_info->fetch_assoc(); ?> 
    <?php  $info_pengiriman = "select * from jasa_pengiriman where id = 1"; $result_info_pengiriman = $mysqli->query($info_pengiriman);
    $info_pengirm = $result_info_pengiriman->fetch_assoc();?>
    
    <section id="content" class="mt-5">
        <div class="container ">
            <div class="row">
                <div class="card-body">
                  <label for="" ><strong>keranjang</strong></label>
                  <div id="addres">
                 
                  <form method="get">
                  <div class="input-group mb-3 col-md-4">
                       <button type="button" id="refres" class="btn btn-warning form-group" >Refres</button> 
                  
                    <select class="form-control" id="provinsi" name="provinsi">
                            <option id="prv">-- pilih provinsi --</option>
                            <?php
                                $prov = "select * from provinsi";
                                $result_prov = $mysqli->query($prov);
                                
                                if ($result_prov->num_rows > 0) {
                                    // output data of each row
                                    while($res_prov = $result_prov->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $res_prov["id"]; ?>"><?php echo $res_prov["nama"]; ?></option>
                            
                            <?php
                                    }
                                }
                        ?>
                    </select> 
                    <input type="text" value="<?php echo  $id_produk;?>" name="id_produk" hidden>
                    <input type="text" value="<?php echo $jumlah_beli;?>" name="jml_produk"hidden >
                    <div class="input-group-append">
                    <button type="submit" class="btn btn-primary form-group" id="prov">Pilih</button> 
                    </div>
                   </div>
                  
                   </form>

                    <form method="get">
                    <div class="input-group mb-3 col-md-4" id="kota_s">
                    <select class="form-control" id="kota" name="kota">
                        <?php
                        // echo $id_provinsi;
                            $kota = "select * from kota where id_provinsi = '$id_provinsi'";
                            $result_kota = $mysqli->query($kota);
                            
                            if ($result_kota->num_rows > 0) {
                                // output data of each row
                                while($res_kota = $result_kota->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $res_kota["id"]; ?>"><?php echo $res_kota["nama"]; ?></option>
                        <?php
                                }
                            }
                       ?>
                   </select>
                    <!-- <input type="number" name="berat" value=''> -->
                    <input type="text" value="<?php echo  $id_produk;?>" name="id_produk" hidden>
                    <input type="text" value="<?php echo $jumlah_beli;?>" name="jml_produk"hidden >
                   <div class="input-group-append">
                   <button type="submit" class="btn btn-primary" id="btnkotaa">Pilih</button>
                   </div>
                   </div>
                   </form>
                   </div>
                   <br>
                    <form action="transaksi.php" method="post">
                    <li class="list-group-item card-title"><strong>Detail</strong> <br> <strong>Dikirm Ke : </strong><p><?php if (isset($_GET['kota'])) {
                        echo $row_kota["nama"].' | '.$row_kota["provinsi"];
                        }?></p>
                        <p><?php if (isset($ids)) {
                        echo $row_user["alamat_lengkap"].' | '.$row_user["kode_pos"].' | '.$row_user["no_telpon"];
                        }?></p> 
                        <strong>Nama Lengkap : </strong><p><?php if (isset($ids)) {
                        echo $row_user["nama_lengkap"];
                        }?></p> <strong>Produk</strong>
                        <p class="card-text">Nama : <?php echo $row_produk["nama"].'<br> Jumlah Beli : '.$jumlah_beli.' '.$row_produk["satuan"].'<br> Harga : Rp.'.$row_produk["harga"].' / '.$row_produk["satuan"];?> </p> <hr><strong>Informasi No Rekening</strong><p> <?php echo $info["nama"].' | '.$info["keterangan"]; ?></p>
                        <hr><strong>Informasi Pengiriman</strong><p> <?php echo $info_pengirm["nama"].'<br> Estimasi biaya = Rp.'.$info_pengirm["biaya"]; ?>/Kg</p>
                    <!-- <hr><strong>Jenis Pengiriman</strong> -->
                    <hr>
                    <?php if (isset($_GET['detail'])) {?>
                        <strong>Total Bayar Produk : </strong><p>Rp.<?php $harga = $row_produk["harga"]; echo $harga*$jumlah_beli; ?></p><hr>
                        <strong>Jasa Pengiriman : </strong><p><?php echo $jasa; ?></p>
                        <strong>Ongkir : </strong><p>Rp.<?php echo $ongkir; ?></p> <hr> 
                        <?php if ($ongkir != null) {?>
                            <strong>Total  : </strong><p>Rp.<?php echo $ongkir+($harga*$jumlah_beli); ?></p> <hr>
                        <?php }else{?>
                            <strong>Total  : </strong><p>Rp.<?php echo ($harga*$jumlah_beli); ?><br> Belum termasuk ongkir, mohon tunggu perhitungan ongkir</p> <hr>
                            <?php }?>
                    <?php }else{?>
                        <strong>Total Estimasi Ongkir : </strong><p>Rp.<?php $harga = $row_produk["harga"]; echo $info_pengirm["biaya"]*$jumlah_beli; ?></p><hr>
                        <strong>Total Bayar Belum Termasuk Ongkir : </strong><p>Rp.<?php $harga = $row_produk["harga"]; echo $harga*$jumlah_beli; ?></p><hr>   
                        
                    <?php }?>
                    
                    </li>
                    <input type="text" value="<?php echo  $row_user["id"];?>" name="id_detail" hidden>
                    <input type="text" value="<?php echo  $row_kota["id"];?>" name="id_kota" hidden>
                    <input type="text" value="<?php echo  $id_produk;?>" name="id_produk" hidden>
                    <input type="text" value="<?php echo $jumlah_beli;?>" name="jml_order" hidden>
                    <input type="text" value="<?php echo $info["id"];?>" name="id_informasi" hidden>
                    <input type="text" value="<?php echo $harga*$jumlah_beli;?>" name="total_bayar" hidden>
                    <button type="submit" class="btn btn-success" id="next">Selanjutnya</button>

                   </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
<div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Produk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="mt-6" method="post">
        <div class="modal-body">
        <div class="card-body text-center">
            <input type="button" id="id" name="id_produk" hidden>
            <label for=""><strong id="nama_produk"></strong></label>
            <div id="img"></div>
            <label for="">Rp.<strong id="harga"></strong> / <span id="satuan"></span> <p>Stok Produk : <strong id="stok"></strong></p></label>
            <p id="keterangan" ></p>
           
        </div>
      <div class="modal-footer">
        <input type="number" class="form-group" name="jml_produk" placeholder="Jumlah Produk">
        <button type="submit" class="btn btn-primary">Beli</button>
      </div>
      </form>
    </div>
  </div>
</div>   

    <?php include 'layouts/footer.php';?>
    <script>
       
        $("#kota_s").hide();
        $("#prov").on( "click", function() { 
            localStorage.setItem('prov','true');
            $("#prov").hide();
        }) 
        $("#btnkotaa").on( "click", function() { 
            localStorage.setItem('kota','true');
        });
        $("#refres").on( "click", function() { 
            localStorage.removeItem('prov'); 
            localStorage.removeItem('kota');
            localStorage.removeItem('isian');
            $("#prov").show();
            $("#kota_s").hide();
        });
        
        var da =  localStorage.getItem('prov'); 
        var kt =  localStorage.getItem('kota'); 
        var isi =  localStorage.getItem('isian');  
        var addres =  localStorage.getItem('adress');
       console.log(kt);
        if (da == 'true') {
            $("#prv").text(isi);
            $("#kota_s").show();
            $("#prov").hide();
           
        } 
        if (kt == 'true') {
            $("#prv").text(isi);
            $("#kota_s").hide();
            $("#prov").hide();
           
        }
        if (addres == 'true') {
            document.getElementById('addres').hidden=true; 
            document.getElementById('next').hidden=true;
        }

        $("#logout").on( "click", function() {
           localStorage.clear(); 
        });
            
        $("#btnkota").on( "click", function() {
           $("#kota_s").show();
        });
            
        $(".show").on( "click", function() {
            
        var data = $(this).attr('value');
        data = data.split('|');
        // alert(data[0]);
        //  console.log(data);
 
        $("#id").val(data[0]);
        $("#nama_produk").text(data[1]);
        $("#img").html('<img src="asset/upload/'+data[2]+'" alt="" style="width:180px;height:180px;">');
        $("#harga").text(data[3]);
        $("#satuan").text(data[4]);
        $("#keterangan").text(data[5]);
        $("#stok").text(data[6]);

        });
            
        $('#provinsi').on('change', function () {
        //ways to retrieve selected option and text outside handler
        if(this.value == 12){
            localStorage.setItem('isian','Kalimantan Barat');
        }else if(this.value == 13){
            localStorage.setItem('isian','Kalimantan Selatan');
        }else if(this.value == 14){
            localStorage.setItem('isian','Kalimantan Tengah');
        }else if(this.value == 15){
            localStorage.setItem('isian','Kalimantan Timur');
        }else if(this.value == 16){
            localStorage.setItem('isian','Kalimantan Utara');
        }
           
        
      
        });
    //  var notif = localStorage.getItem("notif");
    //     if (notif == "true") {
    //       $('#notif').append('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Holy guacamole!</strong> You should check in on some of those fields below.<button type="button" class="close" id="closed" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    //     }
    //     $(".close").click(function(){
    //       localStorage.clear();
    //     });

   
       
       
    </script>
   


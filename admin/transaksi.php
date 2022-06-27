<?php
    include 'includes.php';

    $page = "transaksi.php";
    $title = "Transaksi";    
    $now = date('Y-m-d');

    if($_POST){
        if($_POST['method'] == 'konfirmasi'){
            $sql = "UPDATE transaksi SET status='pesanan diproses' WHERE id=".$_POST['id']."";
            $result = $mysqli->query($sql);
            header("location: transaksi.php", true, 301);
        }elseif($_POST['method'] == 'tolak'){
            $sql = "UPDATE transaksi SET status='ditolak' WHERE id=".$_POST['id']."";
            $result = $mysqli->query($sql);
            header("location: transaksi.php", true, 301);
        }elseif($_POST['method'] == 'ongkir'){
            $sql = "UPDATE transaksi SET ongkir=".$_POST['ongkir']." WHERE id=".$_POST['id']."";
            $result = $mysqli->query($sql);
            header("location: transaksi.php", true, 301);
        }elseif($_POST['method'] == 'status'){
            $sql = "UPDATE transaksi SET status='".$_POST['status']."' WHERE id=".$_POST['id']."";
            $result = $mysqli->query($sql);
            header("location: transaksi.php", true, 301);
        }
    }

    $sql = "SELECT transaksi.id, detail.kode_pos as kode_pos, kota.nama as nama_kota, provinsi.nama as nama_provinsi, transaksi.ongkir, transaksi.jml_order, transaksi.jml_bayar, transaksi.date, transaksi.status, user.nama_lengkap, produk.nama, produk.harga, pembayaran.file, pembayaran.keterangan, pembayaran.tgl_bayar, informasi.nama as nama_bank, detail.no_telpon as no_telpon, detail.alamat_lengkap as alamat FROM transaksi INNER JOIN detail ON detail.id=transaksi.id_detail INNER JOIN user ON user.id=detail.id_user INNER JOIN produk ON produk.id=transaksi.id_produk INNER JOIN informasi ON informasi.id=transaksi.id_informasi LEFT JOIN pembayaran ON pembayaran.id_transaksi=transaksi.id INNER JOIN kota ON transaksi.id_kota=kota.id INNER JOIN provinsi ON kota.id_provinsi=provinsi.id";
   
    $result = $mysqli->query($sql);

    $transaksis = [];
    while($row = $result->fetch_assoc()) {
        // dd($row);
        $transaksis[] = $row;
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
                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Tambah (+)
                </button> -->
            </h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga/Pcs</th>
                        <th>Jumlah Bayar</th>
                        <th>Ongkir</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Bukti Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($transaksis as $key => $transaksi): ?>
                        <tr>
                            <td><?= $key+1; ?></td>
                            <td><?= $transaksi['nama_lengkap']; ?></td>
                            <td><?= $transaksi['nama']; ?></td>
                            <td><?= $transaksi['jml_order']; ?></td>
                            <td><?= rupiah($transaksi['harga']); ?></td>
                            <td><?= rupiah($transaksi['jml_bayar']); ?></td>
                            <td><?= rupiah($transaksi['ongkir']); ?></td>
                            <td><?= tanggal_indo($transaksi['date']); ?></td>
                            <td><?= $transaksi['status']; ?></td>
                            <td>
                                <?php if($transaksi['file'] != NULL){ ?>
                                    <button id="edit" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editmodal" data-val="<?= $transaksi['file'] ?>|<?= $transaksi['keterangan'] ?>|<?= $transaksi['tgl_bayar'] ?>|<?= $transaksi['nama_bank'] ?>|<?= $transaksi['nama_provinsi'] ?>|<?= $transaksi['nama_kota'] ?>|<?= $transaksi['kode_pos'] ?>|<?= $transaksi['no_telpon'] ?>|<?= $transaksi['alamat'] ?>">Cek Pembayaran</button>
                                <?php }else{ ?>
                                    <button id="edit" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editmodal" data-val="<?= $transaksi['file'] ?>|<?= $transaksi['keterangan'] ?>|<?= $transaksi['tgl_bayar'] ?>|<?= $transaksi['nama_bank'] ?>|<?= $transaksi['nama_provinsi'] ?>|<?= $transaksi['nama_kota'] ?>|<?= $transaksi['kode_pos'] ?>|<?= $transaksi['no_telpon'] ?>|<?= $transaksi['alamat'] ?>">Cek Pembayaran</button>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if($transaksi['status'] == 'verifikasi pembayaran') : ?>
                                    <form class="d-inline" action="" method="post">
                                        <input type="hidden" name="method" value="konfirmasi">
                                        <input type="hidden" name="id" value="<?= $transaksi['id'] ?>">
                                        <button type="submit" class="btn btn-success btn-sm">Konfirmasi</button>
                                    </form>
                                    <form class="d-inline" action="" method="post">
                                        <input type="hidden" name="method" value="tolak">
                                        <input type="hidden" name="id" value="<?= $transaksi['id'] ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                    </form>
                                <?php elseif($transaksi['status'] == 'menunggu pembayaran') : ?>
                                    <button id="btnongkir" type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-val="<?= $transaksi['id']; ?>" data-target="#ongkir">Masukan Ongkir</button>
                                <?php else : ?>
                                    <button id="btnstatus" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-val="<?= $transaksi['id']; ?>" data-target="#status">Ubah Status</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cek Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img src="" alt="" style="max-width:100%;" id="bukti">
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Bank Tujuan</label>
                        <input class="form-control" name="bank" id="bank" disabled></input>
                    </div>
                    <div class="form-group">
                        <label for="">Keterangan</label>
                        <textarea class="form-control" name="keterangan" id="keterangan" disabled></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Bayar</label>
                        <input class="form-control" name="tanggal_bayar" id="tanggal_bayar" disabled></input>
                    </div>
                    <div class="form-group">
                        <label for="">Provinsi</label>
                        <input class="form-control" name="provinsi" id="provinsi" disabled></input>
                        <label for="">Kota</label>
                        <input class="form-control" name="kota" id="kota" disabled></input>
                        <label for="">Kode Pos</label>
                        <input class="form-control" name="kode_pos" id="kode_pos" disabled></input>
                        <label for="">No Telpon</label>
                        <input class="form-control" name="no" id="no" disabled></input>
                        <label for="">Alamat</label>
                        <input class="form-control" name="alamat" id="alamat" disabled></input>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ongkir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Masukan Ongkir</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" class="form" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="idongkir">
                        <input type="hidden" name="method" value="ongkir">
                        <div class="form-group mt-3">
                            <label for="">Ongkir</label>
                            <input class="form-control" name="ongkir"></input>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="status" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" class="form" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="idstatus">
                        <input type="hidden" name="method" value="status">
                        <div class="form-group mt-3">
                            <label for="">Status</label>
                            <select class="form-control" name="status">
                                <option value="pesanan diproses">pesanan diproses</option>
                                <option value="pesanan dikirim">pesanan dikirim</option>
                                <option value="pesanan diterima">pesanan diterima</option>
                                <option value="dibatalkan">dibatalkan</option>
                                <option value="selesai">selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

        $('#bukti').attr('src', '../asset/upload/' + val[0]);
        $('#keterangan').val(val[1]);
        $('#tanggal_bayar').val(val[2]);
        $('#bank').val(val[3]);   
        $('#provinsi').val(val[4]);   
        $('#kota').val(val[5]); 
        $('#kode_pos').val(val[6]);
        $('#no').val(val[7]); 
        $('#alamat').val(val[8]);
    }); 

    $(document).on('click','#btnongkir',function(){
        val = $(this).data('val');
        console.log(val);

        $('#idongkir').val(val);
    });

    $(document).on('click','#btnstatus',function(){
        val = $(this).data('val');
        console.log(val);

        $('#idstatus').val(val);
    });
</script>
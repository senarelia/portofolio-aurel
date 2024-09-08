[13.17, 26/8/2024] zen: <?php

    $server="localhost";
    $user="root";
    $password="";
    $database="dbboostrap";

    $koneksi=mysqli_connect($server, $user, $password, $database) or die(mysqli_error($koneksi));

    $q = mysqli_query($koneksi, "SELECT kode FROM tbarang order by kode desc limit 1");
    $datax = mysqli_fetch_array($q);
    if ($datax) {
        $no_terakhir = substr($datax['kode'], -3);
        $no = $no_terakhir +1 ;

        if ($no > 0 and $no<10) {
            $kode= "00".$no;
        } else if ($no > 10 and $no <100) {
            $kode = "0".$no;
        } else if($no > 100){
            $kode = $no;
        }
    } else {
        $kode = "001";
    }
    
    $tahun = date ('Y');
    $vkode = "IVN-" .$tahun .'-'.  $kode;

    
    if(isset($_POST['bsimpan'])){

        if($_GET['hal'] == "edit"){

            $edit = mysqli_query($koneksi, "UPDATE tbarang SET
                                                    nama = '$_POST[tnama]',
                                                    asal =  '$_POST[tasal]',
                                                    username = '$_POST[tuser]',
                                                    jumlah = '$_POST[tjumlah]',
                                                    satuan =  '$_POST[tsatuan]',
                                                    tanggal_diterima = '$_POST[ttanggal_diterima]'
                                             WHERE id_barang = '$_GET[id]'
                                                    ");
        
        if($edit) {
            echo"<script>
                    alert('Edit data sukses!');
                    document.location= 'index.php';
                </script>";
        }else{
            echo"<script>
                    alert('Edit data gagal!');
                    document.location= 'index.php';
                </script>";
        }

    }else{
      
        $simpan = mysqli_query($koneksi, " INSERT INTO tbarang (kode, nama, asal, username, jumlah, satuan, tanggal_diterima)
                                           VALUE ( '$_POST[tkode]',
                                                   '$_POST[tnama]',
                                                   '$_POST[tasal]',
                                                   '$_POST[tuser]',
                                                   '$_POST[tjumlah]',
                                                   '$_POST[tsatuan]',
                                                   '$_POST[ttanggal_diterima]' )
                                                ");

        if($simpan) {
            echo"<script>
                    alert('Simpan data sukses!');
                    document.location= 'index.php';
                </script>";
        }else{
            echo"<script>
                    alert('Simpan data gagal!');
                    document.location= 'index.php';
                </script>";
        }  
    }                                         




    }


$vnama = "";
$vasal = "";
$vusername = "";
$vjumlah = "";
$vsatuan = "";
$vtanggal_diterima = "";

if(isset($_GET['hal'])){

    if ($_GET['hal'] == "edit") {
         
   




        $tampil = mysqli_query($koneksi, "SELECT * FROM tbarang WHERE id_barang = '$_GET[id]' ");
        $data = mysqli_fetch_array($tampil);
        if($data){

            $vkode = $data['kode'];
            $vnama = $data['nama'];
            $vasal = $data['asal'];
            $vusername = $data['username'];
            $vjumlah = $data['jumlah'];
            $vsatuan = $data['satuan'];
            $vtanggal_diterima = $data['tanggal_diterima'];

        }
    }else if ($_GET['hal'] == "hapus") {

        $hapus = mysqli_query($koneksi, "DELETE FROM tbarang WHERE id_barang = '$_GET[id]' ");
        
        if($hapus) {
            echo"<script>
                    alert('Hapus data sukses!');
                    document.location= 'index.php';
                </script>";
        }else{
            echo"<script>
                    alert('Hapus data gagal!');
                    document.location= 'index.php';
                </script>";
        }  
    }
}









?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap-Crud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
        <h3 class="text-center">Data Inventaris</h3>
        <h3 class="text-center">Kantor Kripca</h3>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header bg-info text-light">
                        From input Data Barang
                    </div>
                <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Kode Barang</label>
                        <input type="text" name="tkode" value="<?= $vkode ?>" class="form-control" placeholder="Masukkan Kode Barang">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="tnama"  value="<?= $vnama ?>" class="form-control" placeholder="Masukkan Nama Barang">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Asal Barang</label>
                        <select class="form-select" name="tasal"  value="<?= $vasal ?>" >
                            <option value="<?= $vasal ?>">-Pilih-</option>
                            <option value="Pembelian">Pembelian</option>
                            <option value="Hibah">Hibah</option>
                            <option value="Sumbangan">Sumbangan</option>
                            <option value="Bantuan">Bantuan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="tuser" value="<?= $vusername ?>" class="form-control" placeholder="Masukkan Username">
                    </div>                    

                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="tjumlah" value="<?= $vjumlah ?>" class="form-control" placeholder="Masukkan Jumlah Barang">
                        </div>
                    </div>

                        <div class="col">
                            <div class="mb-3">
                            <label class="form-label">Satuan</label>
                            <select class="form-select" name="tsatuan">
                                <option value="<?= $vsatuan ?>">-Pilih-</option>
                                <option value="Unit">Unit</option>
                                <option value="Kotak">Kotak</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Pak">Pak</option>
                            </select>
                        </div>
                    </div>

                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Diterima</label>
                            <input type="date" name="ttanggal_diterima" value="<?= $vtanggal_diterima ?>" class="form-control" placeholder="Masukkan Jumlah Barang">
                        </div>
                    </div>

                    <div class="text-center">
                        <hr>
                        <button class="btn btn-primary" name="bsimpan" type="submit">Simpan</button>
                        <button class="btn btn-danger" name="bkosong" type="reset">Kosongkan</button>
                    </div>

                </form>
            </div>
                <div class="card-footer bg-info">

                </div>
            </div>
            </div>
        </div> 

        <div class="card mt-3">
            <div class="card-header bg-info text-light">
                Data Barang
            </div>
            <div class="card-body">
                <div class="col-md-6 mx-auto">
                    <form method="POST">
                        <div class="input-group mb-3">
                            <input type="text" name="tcari" value="<?= @$_POST['tcari']; ?>" class="form-control" placeholder="Masukkan kata kunci!">
                            <button class="btn btn-primary" name="bcari" type="cari">Cari</button>
                            <button class="btn btn-danger" nama="breset" type="submit">Reset</button>
                        </div>
                    </form>
                </div>
                <table class="table table-striped table-hover table-bordered">
                    <tr>
                        <th>No.</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Asal Barang</th>
                        <th>Username Pembeli</th>
                        <th>Jumlah</th>
                        <th>Tanggal Diterima</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                    $no = 1;

                    if (isset($_POST['bcari'])){
                        $keyword = $_POST['tcari'];
                        $q = "SELECT * FROM tbarang WHERE kode like '%$keyword%' or asal like '%$keyword' order by id_barang desc";
                    } else {
                        $q = "SELECT * FROM tbarang order by id_barang desc";
                    }

                    $tampil = mysqli_query($koneksi, $q);
                    while ($data = mysqli_fetch_array($tampil)) :
                    ?>


                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $data['kode'] ?></td>
                        <td><?= $data['nama'] ?></td>
                        <td><?= $data['asal'] ?></td>
                        <td><?= $data['username'] ?></td>
                        <td><?= $data['jumlah'] ?> <?= $data['satuan'] ?></td>
                        <td><?= $data['tanggal_diterima'] ?></td>
                        <td>
                            <a href="index.php?hal=edit&id=<?= $data['id_barang'] ?>" class="btn btn-warning">Edit</a>

                            <a href="index.php?hal=hapus&id=<?= $data['id_barang'] ?>" class="btn btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">Hapus</a>

                        </td>
                    </tr>

                    <?php endwhile;?>
                </table>


                
            </div>
            <div class="card-footer bg-info">
                
            </div>
        </div>



    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>

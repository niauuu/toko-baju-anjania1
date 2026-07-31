<?php require_once 'config.php';
if(!isset($_SESSION['role'])||$_SESSION['role']!=='user'){setToast('error','Silakan login.');header("Location:login.php");exit;}
if($_SERVER['REQUEST_METHOD']!=='POST'){header("Location:stok_barang.php");exit;}
 $pid=intval($_POST['produk_id']??0);$jml=intval($_POST['jumlah']??0);
if($pid===0||$jml<1){setToast('error','Data tidak valid.');header("Location:stok_barang.php");exit;}
 $s=$conn->prepare("SELECT * FROM kr_produk WHERE id=?");$s->bind_param("i",$pid);$s->execute();$r=$s->get_result();
if($r->num_rows===0){setToast('error','Produk tidak ditemukan.');header("Location:stok_barang.php");exit;}
 $b=$r->fetch_assoc();
if($b['stok']<$jml){setToast('error','Stok tidak mencukupi. Tersisa '.$b['stok'].'.');header("Location:beli.php?id=$pid");exit;}
 $total=$b['harga']*$jml;
 $s2=$conn->prepare("INSERT INTO kr_transaksi (user_id,produk_id,nama_pembeli,nama_produk,kategori,bahan,harga,jumlah,total_harga) VALUES (?,?,?,?,?,?,?,?,?)");
 $s2->bind_param("iissssiii",$_SESSION['id'],$pid,$_SESSION['nama'],$b['nama_produk'],$b['kategori'],$b['bahan'],$b['harga'],$jml,$total);
if($s2->execute()===false)die("Gagal: ".$s2->error);
 $tid=$s2->insert_id;
 $s3=$conn->prepare("UPDATE kr_produk SET stok=stok-? WHERE id=?");$s3->bind_param("ii",$jml,$pid);$s3->execute();
header("Location:cetak_struk.php?id=$tid");exit;
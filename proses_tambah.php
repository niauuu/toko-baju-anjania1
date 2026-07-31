<?php require_once 'config.php';
if(!isset($_SESSION['role'])||$_SESSION['role']!=='admin'){header("Location:login.php");exit;}
 $np=trim($_POST['nama_produk']??'');$kat=trim($_POST['kategori']??'');$bh=trim($_POST['bahan']??'');$hg=intval($_POST['harga']??0);$st=intval($_POST['stok']??0);$gm=trim($_POST['gambar']??'');$ds=trim($_POST['deskripsi']??'');
if(empty($np)||empty($kat)||empty($bh)||$hg<=0){setToast('error','Isi semua field wajib.');header("Location:tambah.php");exit;}
if(empty($gm))$gm='https://images.unsplash.com/photo-1445205170230-053b83016050?w=400&h=300&fit=crop';
 $s=$conn->prepare("INSERT INTO kr_produk (nama_produk,kategori,bahan,harga,stok,gambar,deskripsi) VALUES (?,?,?,?,?,?,?)");
 $s->bind_param("sssiiis",$np,$kat,$bh,$hg,$st,$gm,$ds);
setToast($s->execute()?'success':'error',$s->execute()?'Produk "'.$np.'" berhasil ditambahkan!':'Gagal menambahkan.');
header("Location:stok_barang.php");exit;
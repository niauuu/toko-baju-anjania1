<?php require_once 'config.php';
if(!isset($_SESSION['role'])||$_SESSION['role']!=='admin'){header("Location:login.php");exit;}
 $id=intval($_GET['id']??0);
 $s=$conn->prepare("SELECT nama_produk FROM kr_produk WHERE id=?");$s->bind_param("i",$id);$s->execute();$b=$s->get_result()->fetch_assoc();
if($b){$conn->prepare("DELETE FROM kr_produk WHERE id=?")->bind_param("i",$id)->execute();setToast('success','"'.$b['nama_produk'].'" dihapus.');}
else setToast('error','Produk tidak ditemukan.');
header("Location:stok_barang.php");exit;
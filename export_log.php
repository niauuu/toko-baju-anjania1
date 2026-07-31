<?php require_once 'config.php';
if(!isset($_SESSION['role'])||$_SESSION['role']!=='admin'){header("Location:login.php");exit;}
header('Content-Type:text/csv;charset=utf-8');
header('Content-Disposition:attachment;filename="log_anjania_'.date('Y-m-d').'.csv"');
 $o=fopen('php://output','w');
fputcsv($o,['ID','Tanggal','Pembeli','Produk','Kategori','Bahan','Harga','Qty','Total']);
 $d=$conn->query("SELECT * FROM kr_transaksi ORDER BY tanggal_transaksi DESC");
while($r=$d->fetch_assoc())fputcsv($o,['#'.str_pad($r['id'],5,'0',STR_PAD_LEFT),date('d/m/Y H:i:s',strtotime($r['tanggal_transaksi'])),$r['nama_pembeli'],$r['nama_produk'],$r['kategori'],$r['bahan'],$r['harga'],$r['jumlah'],$r['total_harga']]);
fclose($o);exit;
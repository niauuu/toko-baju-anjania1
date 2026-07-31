<?php require_once 'config.php';
if(!isset($_SESSION['role'])||$_SESSION['role']!=='admin'){header("Location:login.php");exit;}
 $tp=$conn->query("SELECT COUNT(*) as c FROM kr_produk")->fetch_assoc()['c'];
 $tt=$conn->query("SELECT COUNT(*) as c FROM kr_transaksi")->fetch_assoc()['c'];
 $tpd=$conn->query("SELECT COALESCE(SUM(total_harga),0) as c FROM kr_transaksi")->fetch_assoc()['c'];
 $sr=$conn->query("SELECT COUNT(*) as c FROM kr_produk WHERE stok<=5")->fetch_assoc()['c'];
 $cd=[];for($i=6;$i>=0;$i--){$d=date('Y-m-d',strtotime("-$i days"));$cd[]=['l'=>date('D',strtotime($d)),'c'=>$conn->query("SELECT COUNT(*) as c FROM kr_transaksi WHERE DATE(tanggal_transaksi)='$d'")->fetch_assoc()['c'],'r'=>$conn->query("SELECT COALESCE(SUM(total_harga),0) as c FROM kr_transaksi WHERE DATE(tanggal_transaksi)='$d'")->fetch_assoc()['c']];}
 $rt=$conn->query("SELECT * FROM kr_transaksi ORDER BY tanggal_transaksi DESC LIMIT 5");
 $ls=$conn->query("SELECT * FROM kr_produk WHERE stok<=5 ORDER BY stok ASC");
htmlHead('Dashboard Admin');
?>
<section class="py-8"><div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="reveal mb-8"><h1 class="font-display text-3xl font-bold">Dashboard</h1><p class="text-zinc-600 text-sm mt-1">Selamat datang, <span class="text-copper-400"><?=htmlspecialchars($_SESSION['nama'])?></span></p></div>
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
<?php foreach([['fa-box','Total Produk',$tp,'from-copper-500/15 to-copper-600/5 border-copper-500/15','text-copper-400'],['fa-receipt','Total Transaksi',$tt,'from-emerald-500/15 to-emerald-600/5 border-emerald-500/15','text-emerald-400'],['fa-coins','Pendapatan',formatRupiah($tpd),'from-copper-500/15 to-copper-600/5 border-copper-500/15','text-copper-400'],['fa-triangle-exclamation','Stok Menipis',$sr,'from-red-500/15 to-red-600/5 border-red-500/15','text-red-400']] as $s):?>
<div class="reveal card-hover bg-gradient-to-br <?=$s[3]?> border rounded-2xl p-5"><div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center mb-3"><i class="fas <?=$s[0]?> <?=$s[4]?>"></i></div><p class="text-2xl font-bold text-zinc-100"><?=$s[2]?></p><p class="text-xs text-zinc-600 mt-1"><?=$s[1]?></p></div>
<?php endforeach;?></div>
<div class="grid lg:grid-cols-3 gap-6 mb-8">
<div class="reveal lg:col-span-2 bg-dark-200 border border-white/[0.04] rounded-2xl p-6"><h3 class="font-semibold text-zinc-200 mb-6">Transaksi 7 Hari Terakhir</h3><canvas id="chart7d" height="200"></canvas></div>
<div class="reveal bg-dark-200 border border-white/[0.04] rounded-2xl p-6"><h3 class="font-semibold text-zinc-200 mb-5">Aksi Cepat</h3><div class="space-y-3">
<?php foreach([['tambah.php','fa-plus','bg-copper-500/10 text-copper-400','Tambah Barang','Input produk baru'],['stok_barang.php','fa-boxes-stacked','bg-blue-500/10 text-blue-400','Kelola Stok','Edit & hapus produk'],['logs_pesanan.php','fa-clipboard-list','bg-emerald-500/10 text-emerald-400','Logs Pesanan','Riwayat transaksi'],['logout.php','fa-sign-out-alt','bg-red-500/10 text-red-400','Logout','Keluar akun']] as $a):?>
<a href="<?=$a[0]?>" class="flex items-center gap-3 p-4 bg-white/[0.02] border border-white/[0.03] rounded-xl hover:border-copper-500/25 hover:bg-copper-500/5 transition-all group"><div class="w-10 h-10 rounded-lg <?=$a[2]?> flex items-center justify-center flex-shrink-0"><i class="fas <?=$a[1]?> text-sm"></i></div><div><p class="text-sm font-medium text-zinc-200 group-hover:text-copper-400 transition-colors"><?=$a[3]?></p><p class="text-[11px] text-zinc-700"><?=$a[4]?></p></div></a>
<?php endforeach;?></div></div></div>
<div class="grid lg:grid-cols-2 gap-6">
<div class="reveal bg-dark-200 border border-white/[0.04] rounded-2xl overflow-hidden"><div class="px-6 py-5 border-b border-white/[0.04] flex items-center justify-between"><h3 class="font-semibold text-zinc-200">Transaksi Terbaru</h3><a href="logs_pesanan.php" class="text-xs text-copper-400 hover:underline">Lihat Semua</a></div>
<?php if($rt->num_rows===0):?><div class="p-10 text-center text-zinc-700 text-sm">Belum ada transaksi</div>
<?php else:?><div class="divide-y divide-white/[0.03]"><?php while($r=$rt->fetch_assoc()):?><div class="px-6 py-4 flex items-center justify-between hover:bg-white/[0.02] transition-colors"><div><p class="text-sm text-zinc-200 font-medium"><?=htmlspecialchars($r['nama_pembeli'])?></p><p class="text-xs text-zinc-700"><?=htmlspecialchars($r['nama_produk'])?> &times; <?=$r['jumlah']?></p></div><div class="text-right"><p class="text-sm font-semibold text-copper-400"><?=formatRupiah($r['total_harga'])?></p><p class="text-[10px] text-zinc-700"><?=date('d/m H:i',strtotime($r['tanggal_transaksi']))?></p></div></div><?php endwhile;?></div><?php endif;?></div>
<div class="reveal bg-dark-200 border border-white/[0.04] rounded-2xl overflow-hidden"><div class="px-6 py-5 border-b border-white/[0.04] flex items-center justify-between"><h3 class="font-semibold text-zinc-200"><i class="fas fa-triangle-exclamation text-red-400 mr-2"></i>Stok Menipis</h3><span class="text-xs px-2.5 py-1 bg-red-500/10 text-red-400 rounded-full font-medium"><?=$sr?> item</span></div>
<?php if($ls->num_rows===0):?><div class="p-10 text-center"><i class="fas fa-check-circle text-3xl text-emerald-600 mb-3"></i><p class="text-zinc-600 text-sm">Semua stok aman</p></div>
<?php else:?><div class="divide-y divide-white/[0.03]"><?php while($r=$ls->fetch_assoc()):?><div class="px-6 py-4 flex items-center justify-between hover:bg-white/[0.02] transition-colors"><div class="flex items-center gap-3"><img src="<?=htmlspecialchars($r['gambar'])?>" alt="" class="w-10 h-10 rounded-lg object-cover flex-shrink-0"><div><p class="text-sm text-zinc-200 font-medium"><?=htmlspecialchars($r['nama_produk'])?></p><p class="text-xs text-zinc-700"><?=htmlspecialchars($r['kategori'])?></p></div></div><span class="px-3 py-1 rounded-full text-xs font-bold bg-red-500/10 text-red-400"><?=$r['stok']?></span></div><?php endwhile;?></div><?php endif;?></div>
</div></div></section>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
new Chart(document.getElementById('chart7d'),{type:'bar',data:{labels:<?=json_encode(array_column($cd,'l'))?>,datasets:[
{label:'Transaksi',data:<?=json_encode(array_column($cd,'c'))?>,backgroundColor:'rgba(212,149,106,0.25)',borderColor:'rgba(212,149,106,0.7)',borderWidth:2,borderRadius:8,yAxisID:'y'},
{label:'Pendapatan',data:<?=json_encode(array_column($cd,'r'))?>,type:'line',borderColor:'rgba(52,211,153,0.7)',backgroundColor:'rgba(52,211,153,0.08)',fill:true,tension:.4,pointRadius:4,pointBackgroundColor:'rgba(52,211,153,1)',yAxisID:'y1'}
]},options:{responsive:true,interaction:{intersect:false,mode:'index'},plugins:{legend:{labels:{color:'#71717a',font:{size:11}}}},scales:{x:{ticks:{color:'#52525b'},grid:{color:'rgba(255,255,255,0.02)'}},y:{position:'left',ticks:{color:'#52525b',stepSize:1},grid:{color:'rgba(255,255,255,0.02)'}},y1:{position:'right',ticks:{color:'#52525b',callback:v=>'Rp '+(v/1000)+'K'},grid:{display:false}}}}});
</script>
<?php htmlFoot();?>

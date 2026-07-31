<?php require_once 'config.php';
if(!isset($_SESSION['role'])||$_SESSION['role']!=='admin'){header("Location:login.php");exit;}
 $q=trim($_GET['q']??'');$df=$_GET['date']??'';
 $w="WHERE 1=1";$p=[];$t="";
if($q){$w.=" AND (t.nama_pembeli LIKE ? OR t.nama_produk LIKE ? OR t.kategori LIKE ?)";$l="%$q%";$p=array_merge($p,[$l,$l,$l]);$t.="sss";}
if($df){$w.=" AND DATE(t.tanggal_transaksi)=?";$p[]=$df;$t.="s";}
 $sql="SELECT t.* FROM kr_transaksi t $w ORDER BY t.tanggal_transaksi DESC";$s=$conn->prepare($sql);
if(!empty($p))$s->bind_param($t,...$p);$s->execute();$res=$s->get_result();
 $td=date('Y-m-d');$ttr=$conn->query("SELECT COUNT(*) as c FROM kr_transaksi WHERE DATE(tanggal_transaksi)='$td'")->fetch_assoc()['c'];
 $trv=$conn->query("SELECT COALESCE(SUM(total_harga),0) as c FROM kr_transaksi WHERE DATE(tanggal_transaksi)='$td'")->fetch_assoc()['c'];
 $arv=$conn->query("SELECT COALESCE(SUM(total_harga),0) as c FROM kr_transaksi")->fetch_assoc()['c'];
htmlHead('Logs Pesanan');
?>
<section class="py-8"><div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="reveal flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
<div><h1 class="font-display text-3xl font-bold">Logs Pesanan</h1><p class="text-zinc-600 text-sm mt-1"><?=$res->num_rows?> transaksi</p></div>
<a href="export_log.php" class="px-4 py-2.5 bg-emerald-500/10 border border-emerald-500/15 text-emerald-400 rounded-xl hover:bg-emerald-500/20 transition-all text-xs font-medium btn-press"><i class="fas fa-file-export mr-1.5"></i>Export CSV</a>
</div>
<div class="reveal grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
<div class="bg-dark-200 border border-white/[0.04] rounded-xl p-4"><p class="text-xs text-zinc-600">Hari Ini</p><p class="text-xl font-bold text-zinc-100 mt-1"><?=$ttr?></p></div>
<div class="bg-dark-200 border border-white/[0.04] rounded-xl p-4"><p class="text-xs text-zinc-600">Pendapatan Hari Ini</p><p class="text-xl font-bold text-copper-400 mt-1"><?=formatRupiah($trv)?></p></div>
<div class="bg-dark-200 border border-white/[0.04] rounded-xl p-4"><p class="text-xs text-zinc-600">Total Transaksi</p><p class="text-xl font-bold text-zinc-100 mt-1"><?=$conn->query("SELECT COUNT(*) as c FROM kr_transaksi")->fetch_assoc()['c']?></p></div>
<div class="bg-dark-200 border border-white/[0.04] rounded-xl p-4"><p class="text-xs text-zinc-600">Total Pendapatan</p><p class="text-xl font-bold text-copper-400 mt-1"><?=formatRupiah($arv)?></p></div>
</div>
<div class="reveal bg-dark-200 border border-white/[0.04] rounded-2xl p-5 mb-6">
<form method="GET" class="flex flex-wrap gap-3 items-end">
<div class="flex-1 min-w-[200px]"><label class="block text-xs text-zinc-500 font-medium mb-1.5">Cari</label><div class="relative"><i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-zinc-700 text-xs"></i><input type="text" name="q" value="<?=htmlspecialchars($q)?>" placeholder="Nama, barang..." class="w-full bg-dark-300 border border-white/[0.06] rounded-lg pl-10 pr-4 py-2.5 text-sm text-white placeholder-zinc-700 transition-all"></div></div>
<div class="w-48"><label class="block text-xs text-zinc-500 font-medium mb-1.5">Tanggal</label><input type="date" name="date" value="<?=htmlspecialchars($df)?>" class="w-full bg-dark-300 border border-white/[0.06] rounded-lg px-4 py-2.5 text-sm text-white transition-all"></div>
<button class="px-5 py-2.5 bg-copper-500/10 border border-copper-500/15 text-copper-400 rounded-lg hover:bg-copper-500/20 transition-all text-sm btn-press"><i class="fas fa-filter mr-1.5"></i>Filter</button>
<?php if($q||$df):?><a href="logs_pesanan.php" class="px-5 py-2.5 border border-white/[0.06] text-zinc-500 rounded-lg hover:bg-white/[0.03] transition-all text-sm">Reset</a><?php endif;?>
</form></div>
<div class="reveal bg-dark-200 border border-white/[0.04] rounded-2xl overflow-hidden">
<?php if($res->num_rows===0):?><div class="p-16 text-center"><i class="fas fa-clipboard text-4xl text-zinc-800 mb-4"></i><p class="text-zinc-600">Tidak ada transaksi.</p></div>
<?php else:?><div class="overflow-x-auto"><table class="w-full text-sm"><thead><tr class="bg-dark-300/50 border-b border-white/[0.04]">
<th class="text-left px-5 py-4 text-[11px] text-zinc-500 font-semibold uppercase tracking-wider">ID</th>
<th class="text-left px-5 py-4 text-[11px] text-zinc-500 font-semibold uppercase tracking-wider">Tanggal</th>
<th class="text-left px-5 py-4 text-[11px] text-zinc-500 font-semibold uppercase tracking-wider">Pembeli</th>
<th class="text-left px-5 py-4 text-[11px] text-zinc-500 font-semibold uppercase tracking-wider">Produk</th>
<th class="text-center px-5 py-4 text-[11px] text-zinc-500 font-semibold uppercase tracking-wider">Qty</th>
<th class="text-right px-5 py-4 text-[11px] text-zinc-500 font-semibold uppercase tracking-wider">Total</th>
<th class="text-center px-5 py-4 text-[11px] text-zinc-500 font-semibold uppercase tracking-wider">Aksi</th>
</tr></thead><tbody>
<?php while($r=$res->fetch_assoc()):?>
<tr class="border-b border-white/[0.03] hover:bg-white/[0.02] transition-colors">
<td class="px-5 py-4 text-zinc-500 font-mono text-xs">#<?=str_pad($r['id'],5,'0',STR_PAD_LEFT)?></td>
<td class="px-5 py-4 text-zinc-400 text-xs whitespace-nowrap"><?=date('d/m/Y H:i',strtotime($r['tanggal_transaksi']))?></td>
<td class="px-5 py-4 text-zinc-200 font-medium whitespace-nowrap"><?=htmlspecialchars($r['nama_pembeli'])?></td>
<td class="px-5 py-4 text-zinc-400"><?=htmlspecialchars($r['nama_produk'])?></td>
<td class="px-5 py-4 text-center"><span class="px-2 py-0.5 bg-white/[0.03] rounded-md text-xs font-semibold text-zinc-300"><?=$r['jumlah']?></span></td>
<td class="px-5 py-4 text-right font-semibold text-copper-400 whitespace-nowrap"><?=formatRupiah($r['total_harga'])?></td>
<td class="px-5 py-4 text-center"><a href="cetak_struk.php?id=<?=$r['id']?>" target="_blank" class="w-9 h-9 rounded-lg bg-copper-500/10 text-copper-400 inline-flex items-center justify-center hover:bg-copper-500/20 transition-all"><i class="fas fa-receipt text-xs"></i></a></td>
</tr><?php endwhile;?></tbody></table></div><?php endif;?></div>
</div></section>
<?php htmlFoot();?>
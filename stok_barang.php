<?php require_once 'config.php';
 $search=trim($_GET['q']??'');
 $isAdmin=isset($_SESSION['role'])&&$_SESSION['role']==='admin';
if($search){$like="%$search%";$stmt=$conn->prepare("SELECT * FROM kr_produk WHERE nama_produk LIKE ? OR kategori LIKE ? OR bahan LIKE ? ORDER BY id DESC");$stmt->bind_param("sss",$like,$like,$like);}
else{$stmt=$conn->prepare("SELECT * FROM kr_produk ORDER BY id DESC");}
 $stmt->execute();$result=$stmt->get_result();
htmlHead('Koleksi Busana');
?>
<section class="py-12">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="reveal flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
<div><h1 class="font-display text-3xl font-bold">Koleksi Busana</h1><p class="text-zinc-600 text-sm mt-1"><?=$result->num_rows?> produk tersedia</p></div>
<form method="GET" class="flex gap-2 w-full sm:w-auto">
<div class="relative flex-1 sm:w-72"><i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-zinc-700 text-sm"></i><input type="text" name="q" value="<?=htmlspecialchars($search)?>" placeholder="Cari busana..." class="w-full bg-dark-300 border border-white/[0.06] rounded-xl pl-11 pr-4 py-3 text-sm text-white placeholder-zinc-700 transition-all"></div>
<button class="px-5 py-3 bg-copper-500/10 border border-copper-500/15 text-copper-400 rounded-xl hover:bg-copper-500/20 transition-all text-sm btn-press">Cari</button>
</form>
</div>
<?php if($result->num_rows===0):?>
<div class="text-center py-20"><i class="fas fa-box-open text-5xl text-zinc-800 mb-4"></i><p class="text-zinc-600">Tidak ada produk ditemukan.</p></div>
<?php elseif($isAdmin):?>
<div class="reveal bg-dark-200 border border-white/[0.04] rounded-2xl overflow-hidden"><div class="overflow-x-auto">
<table class="w-full text-sm">
<thead><tr class="bg-dark-300/50 border-b border-white/[0.04]">
<th class="text-left px-5 py-4 text-[11px] text-zinc-500 font-semibold uppercase tracking-wider">Produk</th>
<th class="text-left px-5 py-4 text-[11px] text-zinc-500 font-semibold uppercase tracking-wider">Kategori</th>
<th class="text-left px-5 py-4 text-[11px] text-zinc-500 font-semibold uppercase tracking-wider">Bahan</th>
<th class="text-left px-5 py-4 text-[11px] text-zinc-500 font-semibold uppercase tracking-wider">Harga</th>
<th class="text-center px-5 py-4 text-[11px] text-zinc-500 font-semibold uppercase tracking-wider">Stok</th>
<th class="text-center px-5 py-4 text-[11px] text-zinc-500 font-semibold uppercase tracking-wider">Aksi</th>
</tr></thead><tbody>
<?php while($row=$result->fetch_assoc()):$sc=$row['stok']>10?'text-emerald-400 bg-emerald-500/10':($row['stok']>0?'text-amber-400 bg-amber-500/10':'text-red-400 bg-red-500/10');?>
<tr class="border-b border-white/[0.03] hover:bg-white/[0.02] transition-colors">
<td class="px-5 py-4"><div class="flex items-center gap-3"><img src="<?=htmlspecialchars($row['gambar'])?>" alt="" class="w-12 h-12 rounded-lg object-cover flex-shrink-0"><div><p class="text-zinc-200 font-medium"><?=htmlspecialchars($row['nama_produk'])?></p></div></div></td>
<td class="px-5 py-4 text-zinc-400"><?=htmlspecialchars($row['kategori'])?></td>
<td class="px-5 py-4 text-zinc-500"><?=htmlspecialchars($row['bahan'])?></td>
<td class="px-5 py-4 text-copper-400 font-semibold"><?=formatRupiah($row['harga'])?></td>
<td class="px-5 py-4 text-center"><span class="px-3 py-1 rounded-full text-xs font-semibold <?=$sc?>"><?=$row['stok']?></span></td>
<td class="px-5 py-4"><div class="flex items-center justify-center gap-2">
<a href="edit_barang.php?id=<?=$row['id']?>" class="w-9 h-9 rounded-lg bg-blue-500/10 text-blue-400 flex items-center justify-center hover:bg-blue-500/20 transition-all"><i class="fas fa-pen text-xs"></i></a>
<a href="hapus_barang.php?id=<?=$row['id']?>" onclick="return confirm('Hapus produk ini?')" class="w-9 h-9 rounded-lg bg-red-500/10 text-red-400 flex items-center justify-center hover:bg-red-500/20 transition-all"><i class="fas fa-trash text-xs"></i></a>
</div></td></tr><?php endwhile;?>
</tbody></table></div></div>
<?php else:?>
<div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
<?php while($row=$result->fetch_assoc()):?>
<div class="reveal card-hover bg-dark-200 border border-white/[0.04] rounded-2xl overflow-hidden group">
<div class="img-zoom relative h-56 bg-dark-300">
<img src="<?=htmlspecialchars($row['gambar'])?>" alt="<?=htmlspecialchars($row['nama_produk'])?>" class="w-full h-full object-cover">
<div class="absolute top-3 left-3 px-3 py-1 bg-dark-500/80 backdrop-blur-md rounded-full text-[10px] text-copper-300 font-semibold uppercase tracking-wider"><?=htmlspecialchars($row['kategori'])?></div>
<?php if($row['stok']<=0):?><div class="absolute inset-0 bg-dark-500/60 flex items-center justify-center"><span class="px-4 py-2 bg-red-600/90 text-white text-sm font-semibold rounded-xl">STOK HABIS</span></div><?php endif;?>
</div>
<div class="p-5">
<h3 class="font-medium text-zinc-200"><?=htmlspecialchars($row['nama_produk'])?></h3>
<p class="text-zinc-600 text-xs mt-1.5 line-clamp-2"><?=htmlspecialchars($row['deskripsi']??'')?></p>
<p class="text-copper-400 font-bold text-xl mt-3"><?=formatRupiah($row['harga'])?></p>
<div class="flex items-center justify-between mt-3">
<span class="text-xs text-zinc-600"><i class="fas fa-layer-group mr-1"></i><?=htmlspecialchars($row['bahan'])?></span>
<span class="text-xs px-2 py-0.5 rounded-full font-medium <?=$row['stok']>10?'bg-emerald-500/10 text-emerald-400':($row['stok']>0?'bg-amber-500/10 text-amber-400':'bg-red-500/10 text-red-400')?>"><?=$row['stok']>0?'Stok '.$row['stok']:'Habis'?></span>
</div>
<?php if($row['stok']>0&&isset($_SESSION['role'])&&$_SESSION['role']==='user'):?>
<a href="beli.php?id=<?=$row['id']?>" class="mt-4 w-full block text-center py-3 bg-gradient-to-r from-copper-400 to-copper-600 text-dark-500 font-semibold rounded-xl hover:from-copper-500 hover:to-copper-700 transition-all btn-press text-sm shadow-lg shadow-copper-500/10"><i class="fas fa-shopping-cart mr-2"></i>Beli Sekarang</a>
<?php elseif($row['stok']>0&&!isset($_SESSION['role'])):?>
<a href="login.php" class="mt-4 w-full block text-center py-3 bg-copper-500/10 text-copper-400 border border-copper-500/15 font-medium rounded-xl hover:bg-copper-500/20 transition-all btn-press text-sm">Login untuk Beli</a>
<?php endif;?>
</div></div>
<?php endwhile;?>
</div>
<?php endif;?>
</div></section>
<?php htmlFoot();?>
<?php require_once 'config.php';
 $featured = $conn->query("SELECT * FROM kr_produk ORDER BY id DESC LIMIT 4");
 $totalP = $conn->query("SELECT COUNT(*) as c FROM kr_produk")->fetch_assoc()['c'];
 $totalT = $conn->query("SELECT COUNT(*) as c FROM kr_transaksi")->fetch_assoc()['c'];
htmlHead('Home');
?>

<section class="hero-mesh hero-grid relative min-h-[92vh] flex items-center overflow-hidden">
<div class="absolute top-20 left-10 w-80 h-80 bg-copper-500/[0.04] rounded-full blur-3xl float glow-pulse"></div>
<div class="absolute bottom-20 right-10 w-96 h-96 bg-copper-500/[0.03] rounded-full blur-3xl float" style="animation-delay:-3s"></div>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
<div class="grid lg:grid-cols-2 gap-12 items-center">
<div class="space-y-8">
<div class="inline-flex items-center gap-2 px-4 py-2 bg-copper-500/10 border border-copper-500/15 rounded-full">
<span class="w-1.5 h-1.5 bg-copper-400 rounded-full glow-pulse"></span>
<span class="text-[11px] text-copper-300 font-medium uppercase tracking-[0.15em]">Premium Fashion Collection</span>
</div>
<h1 class="font-display text-5xl sm:text-6xl lg:text-7xl font-bold leading-[1.05]">Tutup<br><span class="shimmer-text">Aura</span><br>Terbaikmu</h1>
<p class="text-zinc-500 text-lg max-w-lg leading-relaxed">Koleksi baju premium dari Toko Baju Anjania. Kualitas terbaik, harga bersahabat, percaya diri setiap hari.</p>
<div class="flex flex-wrap gap-4">
<a href="stok_barang.php" class="px-8 py-4 bg-gradient-to-r from-copper-400 to-copper-600 text-dark-500 font-semibold rounded-xl hover:from-copper-500 hover:to-copper-700 transition-all btn-press shadow-xl shadow-copper-500/15 text-sm"><i class="fas fa-shopping-bag mr-2"></i>Lihat Koleksi</a>
<?php if(!isset($_SESSION['role'])):?>
<a href="register.php" class="px-8 py-4 border border-copper-500/25 text-copper-400 font-semibold rounded-xl hover:bg-copper-500/10 transition-all btn-press text-sm">Daftar Sekarang</a>
<?php endif;?>
</div>
</div>
<div class="relative flex justify-center">
<div class="absolute inset-0 bg-gradient-to-br from-copper-500/[0.08] to-transparent rounded-full blur-3xl scale-75"></div>
<img src="https://images.unsplash.com/photo-1445205170230-053b83016050?w=550&h=450&fit=crop" alt="Busana Premium" class="relative z-10 w-full max-w-lg rounded-3xl shadow-2xl shadow-copper-500/[0.07] float" style="animation-duration:8s">
</div>
</div>
</div>
<div class="absolute bottom-0 left-0 right-0 bg-dark-300/50 backdrop-blur-xl border-t border-white/[0.04]">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 grid grid-cols-3 gap-6 text-center">
<div><p class="text-2xl sm:text-3xl font-display font-bold text-copper-400">8+</p><p class="text-[10px] text-zinc-600 mt-1 uppercase tracking-wider">Kategori</p></div>
<div><p class="text-2xl sm:text-3xl font-display font-bold text-copper-400"><?=$totalP?>+</p><p class="text-[10px] text-zinc-600 mt-1 uppercase tracking-wider">Produk</p></div>
<div><p class="text-2xl sm:text-3xl font-display font-bold text-copper-400"><?=$totalT?>+</p><p class="text-[10px] text-zinc-600 mt-1 uppercase tracking-wider">Terjual</p></div>
</div>
</div>
</section>

<section class="py-20">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="reveal text-center mb-14">
<span class="text-[11px] text-copper-400 uppercase tracking-[0.2em] font-semibold">Koleksi Terbaru</span>
<h2 class="font-display text-3xl sm:text-4xl font-bold mt-3">Rekomendasi Untukmu</h2>
<div class="w-16 h-0.5 bg-gradient-to-r from-copper-400 to-copper-600 mx-auto mt-5 rounded-full"></div>
</div>
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
<?php while($row=$featured->fetch_assoc()):?>
<div class="reveal card-hover bg-dark-200 border border-white/[0.04] rounded-2xl overflow-hidden group">
<div class="img-zoom relative h-52 bg-dark-300">
<img src="<?=htmlspecialchars($row['gambar'])?>" alt="<?=htmlspecialchars($row['nama_produk'])?>" class="w-full h-full object-cover">
<div class="absolute top-3 left-3 px-3 py-1 bg-dark-500/80 backdrop-blur-md rounded-full text-[10px] text-copper-300 font-semibold uppercase tracking-wider"><?=htmlspecialchars($row['kategori'])?></div>
</div>
<div class="p-5">
<h3 class="font-medium text-zinc-200 text-sm leading-tight"><?=htmlspecialchars($row['nama_produk'])?></h3>
<p class="text-copper-400 font-bold text-lg mt-2"><?=formatRupiah($row['harga'])?></p>
<div class="flex items-center justify-between mt-3">
<span class="text-xs text-zinc-600"><?=htmlspecialchars($row['bahan'])?></span>
<span class="text-xs px-2 py-0.5 rounded-full <?=$row['stok']>10?'bg-emerald-500/10 text-emerald-400':($row['stok']>0?'bg-amber-500/10 text-amber-400':'bg-red-500/10 text-red-400')?>"><?=$row['stok']>0?'Stok '.$row['stok']:'Habis'?></span>
</div>
<?php if($row['stok']>0&&isset($_SESSION['role'])&&$_SESSION['role']==='user'):?>
<a href="beli.php?id=<?=$row['id']?>" class="mt-4 w-full block text-center py-2.5 bg-copper-500/10 text-copper-400 border border-copper-500/15 rounded-xl text-sm font-medium hover:bg-copper-500/20 transition-all btn-press">Beli Sekarang</a>
<?php elseif($row['stok']>0&&!isset($_SESSION['role'])):?>
<a href="login.php" class="mt-4 w-full block text-center py-2.5 bg-copper-500/10 text-copper-400 border border-copper-500/15 rounded-xl text-sm font-medium hover:bg-copper-500/20 transition-all btn-press">Login untuk Beli</a>
<?php endif;?>
</div>
</div>
<?php endwhile;?>
</div>
</div>
</section>

<section class="py-20 bg-dark-300/30">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="reveal text-center mb-14">
<span class="text-[11px] text-copper-400 uppercase tracking-[0.2em] font-semibold">Kenapa Kami</span>
<h2 class="font-display text-3xl sm:text-4xl font-bold mt-3">Kepercayaan Pelanggan</h2>
<div class="w-16 h-0.5 bg-gradient-to-r from-copper-400 to-copper-600 mx-auto mt-5 rounded-full"></div>
</div>
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
<?php
 $feats=[['fa-gem','Premium Quality','Semua produk kami menggunakan bahan premium pilihan yang nyaman dan tahan lama.'],['fa-truck-fast','Pengiriman Cepat','Pengiriman ke seluruh Indonesia dalam 1-3 hari kerja via ekspedisi terpercaya.'],['fa-shield-halved','Garansi Retur','Garansi retur 7 hari jika barang tidak sesuai atau cacat produksi.'],['fa-heart','Testimoni Positif','Ribuan pelanggan puas dengan produk dan pelayanan kami.'],['fa-tags','Harga Terjangkau','Harga bersaing tanpa mengorbankan kualitas bahan dan jahitan.'],['fa-palette','Warna Terlengkap','Tersedia dalam berbagai pilihan warna yang update setiap bulan.']];
foreach(array_slice($feats,0,4) as $f):
?>
<div class="reveal card-hover bg-dark-200 border border-white/[0.04] rounded-2xl p-7 text-center group">
<div class="w-14 h-14 bg-copper-500/10 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:bg-copper-500/15 transition-colors"><i class="fas <?=$f[0]?> text-copper-400 text-xl"></i></div>
<h3 class="font-semibold text-zinc-200 mb-2"><?=$f[1]?></h3>
<p class="text-zinc-600 text-sm leading-relaxed"><?=$f[2]?></p>
</div>
<?php endforeach;?>
</div>
</div>
</section>

<section class="py-16">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="reveal text-center mb-8"><span class="text-[10px] text-zinc-700 uppercase tracking-[0.2em] font-semibold">Kategori Produk</span></div>
<div class="reveal flex flex-wrap justify-center gap-4">
<?php foreach(['Kemeja','Kaos','Celana','Jaket','Dress'] as $kat):?>
<a href="stok_barang.php?q=<?=$kat?>" class="px-6 py-3 bg-dark-200 border border-white/[0.04] rounded-xl text-sm text-zinc-400 hover:text-copper-400 hover:border-copper-500/20 transition-all"><?=$kat?></a>
<?php endforeach;?>
</div>
</div>
</section>

<?php htmlFoot(); ?>
<?php require_once 'config.php';
if(!isset($_SESSION['role'])||$_SESSION['role']!=='admin'){header("Location:login.php");exit;}
htmlHead('Tambah Barang');
?>
<section class="py-12"><div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
<a href="admin_dashboard.php" class="reveal inline-flex items-center gap-2 text-sm text-zinc-500 hover:text-copper-400 transition-colors mb-8"><i class="fas fa-arrow-left text-xs"></i>Kembali</a>
<div class="reveal"><h1 class="font-display text-3xl font-bold">Tambah Barang</h1><p class="text-zinc-600 text-sm mt-1">Input produk baju baru</p></div>
<form method="POST" action="proses_tambah.php" class="reveal mt-8 bg-dark-200 border border-white/[0.04] rounded-2xl p-8 space-y-6">
<div class="grid sm:grid-cols-2 gap-6">
<div><label class="block text-xs text-zinc-500 font-medium mb-2 uppercase tracking-wider">Nama Produk</label><input type="text" name="nama_produk" required placeholder="Kemeja Flanel Premium" class="w-full bg-dark-300 border border-white/[0.06] rounded-xl px-4 py-3.5 text-sm text-white placeholder-zinc-700 transition-all"></div>
<div><label class="block text-xs text-zinc-500 font-medium mb-2 uppercase tracking-wider">Kategori</label><select name="kategori" required class="w-full bg-dark-300 border border-white/[0.06] rounded-xl px-4 py-3.5 text-sm text-white transition-all"><option value="" class="bg-dark-500">Pilih</option><?php foreach(['Kemeja','Kaos','Celana','Jaket','Dress'] as $k):?><option value="<?=$k?>" class="bg-dark-500"><?=$k?></option><?php endforeach;?></select></div>
</div>
<div class="grid sm:grid-cols-2 gap-6">
<div><label class="block text-xs text-zinc-500 font-medium mb-2 uppercase tracking-wider">Bahan</label><input type="text" name="bahan" required placeholder="Katun Combed 30s" class="w-full bg-dark-300 border border-white/[0.06] rounded-xl px-4 py-3.5 text-sm text-white placeholder-zinc-700 transition-all"></div>
<div><label class="block text-xs text-zinc-500 font-medium mb-2 uppercase tracking-wider">Harga (Rp)</label><input type="number" name="harga" required min="0" placeholder="95000" class="w-full bg-dark-300 border border-white/[0.06] rounded-xl px-4 py-3.5 text-sm text-white placeholder-zinc-700 transition-all"></div>
</div>
<div><label class="block text-xs text-zinc-500 font-medium mb-2 uppercase tracking-wider">Stok</label><input type="number" name="stok" required min="0" value="0" class="w-full sm:w-48 bg-dark-300 border border-white/[0.06] rounded-xl px-4 py-3.5 text-sm text-white transition-all"></div>
<div><label class="block text-xs text-zinc-500 font-medium mb-2 uppercase tracking-wider">URL Gambar</label><input type="url" name="gambar" id="gi" placeholder="https://images.unsplash.com/..." class="w-full bg-dark-300 border border-white/[0.06] rounded-xl px-4 py-3.5 text-sm text-white placeholder-zinc-700 transition-all"><p class="text-[11px] text-zinc-700 mt-1.5">Kosongkan = gambar default</p></div>
<div id="ip" class="hidden"><div class="w-40 h-32 rounded-xl overflow-hidden border border-white/[0.06]"><img id="pi" src="" alt="" class="w-full h-full object-cover"></div></div>
<div><label class="block text-xs text-zinc-500 font-medium mb-2 uppercase tracking-wider">Deskripsi</label><textarea name="deskripsi" rows="4" placeholder="Deskripsi produk..." class="w-full bg-dark-300 border border-white/[0.06] rounded-xl px-4 py-3.5 text-sm text-white placeholder-zinc-700 transition-all resize-none"></textarea></div>
<div class="pt-4 border-t border-white/[0.04] flex flex-wrap gap-3">
<button type="submit" class="px-8 py-3.5 bg-gradient-to-r from-copper-400 to-copper-600 text-dark-500 font-semibold rounded-xl hover:from-copper-500 hover:to-copper-700 transition-all btn-press shadow-lg shadow-copper-500/15 text-sm"><i class="fas fa-plus mr-2"></i>Tambah</button>
<a href="admin_dashboard.php" class="px-8 py-3.5 border border-white/[0.06] text-zinc-500 rounded-xl hover:bg-white/[0.03] transition-all text-sm">Batal</a>
</div></form></div></section>
<script>document.getElementById('gi').addEventListener('input',function(){if(this.value){document.getElementById('pi').src=this.value;document.getElementById('ip').classList.remove('hidden');}else{document.getElementById('ip').classList.add('hidden');}});</script>
<?php htmlFoot();?>
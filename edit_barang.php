<?php require_once 'config.php';
if(!isset($_SESSION['role'])||$_SESSION['role']!=='admin'){header("Location:login.php");exit;}
 $id=intval($_GET['id']??0);if($id===0){header("Location:stok_barang.php");exit;}
 $s=$conn->prepare("SELECT * FROM kr_produk WHERE id=?");$s->bind_param("i",$id);$s->execute();$r=$s->get_result();
if($r->num_rows===0){header("Location:stok_barang.php");exit;}
 $b=$r->fetch_assoc();
if($_SERVER['REQUEST_METHOD']==='POST'){
    $np=trim($_POST['nama_produk']??'');$kat=trim($_POST['kategori']??'');$bh=trim($_POST['bahan']??'');
    $hg=intval($_POST['harga']??0);$st=intval($_POST['stok']??0);$gm=trim($_POST['gambar']??'');$ds=trim($_POST['deskripsi']??'');
    if(empty($gm))$gm='https://images.unsplash.com/photo-1445205170230-053b83016050?w=400&h=300&fit=crop';
    $s2=$conn->prepare("UPDATE kr_produk SET nama_produk=?,kategori=?,bahan=?,harga=?,stok=?,gambar=?,deskripsi=? WHERE id=?");
    $s2->bind_param("sssiiisi",$np,$kat,$bh,$hg,$st,$gm,$ds,$id);
    if($s2->execute()){setToast('success','Produk berhasil diperbarui!');header("Location:stok_barang.php");exit;}
}
htmlHead('Edit Barang');
?>
<section class="py-12"><div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
<a href="stok_barang.php" class="reveal inline-flex items-center gap-2 text-sm text-zinc-500 hover:text-copper-400 transition-colors mb-8"><i class="fas fa-arrow-left text-xs"></i>Kembali</a>
<div class="reveal"><h1 class="font-display text-3xl font-bold">Edit Barang</h1><p class="text-zinc-600 text-sm mt-1"><?=htmlspecialchars($b['nama_produk'])?></p></div>
<form method="POST" action="" class="reveal mt-8 bg-dark-200 border border-white/[0.04] rounded-2xl p-8 space-y-6">
<div class="w-32 h-24 rounded-xl overflow-hidden border border-white/[0.06]"><img id="pi" src="<?=htmlspecialchars($b['gambar'])?>" alt="" class="w-full h-full object-cover"></div>
<div class="grid sm:grid-cols-2 gap-6">
<div><label class="block text-xs text-zinc-500 font-medium mb-2 uppercase tracking-wider">Nama</label><input type="text" name="nama_produk" required value="<?=htmlspecialchars($b['nama_produk'])?>" class="w-full bg-dark-300 border border-white/[0.06] rounded-xl px-4 py-3.5 text-sm text-white transition-all"></div>
<div><label class="block text-xs text-zinc-500 font-medium mb-2 uppercase tracking-wider">Kategori</label><select name="kategori" required class="w-full bg-dark-300 border border-white/[0.06] rounded-xl px-4 py-3.5 text-sm text-white transition-all"><?php foreach(['Kemeja','Kaos','Celana','Jaket','Dress'] as $k):?><option value="<?=$k?>" <?=$b['kategori']===$k?'selected':''?> class="bg-dark-500"><?=$k?></option><?php endforeach;?></select></div>
</div>
<div class="grid sm:grid-cols-2 gap-6">
<div><label class="block text-xs text-zinc-500 font-medium mb-2 uppercase tracking-wider">Bahan</label><input type="text" name="bahan" required value="<?=htmlspecialchars($b['bahan'])?>" class="w-full bg-dark-300 border border-white/[0.06] rounded-xl px-4 py-3.5 text-sm text-white transition-all"></div>
<div><label class="block text-xs text-zinc-500 font-medium mb-2 uppercase tracking-wider">Harga</label><input type="number" name="harga" required min="0" value="<?=$b['harga']?>" class="w-full bg-dark-300 border border-white/[0.06] rounded-xl px-4 py-3.5 text-sm text-white transition-all"></div>
</div>
<div><label class="block text-xs text-zinc-500 font-medium mb-2 uppercase tracking-wider">Stok</label><input type="number" name="stok" required min="0" value="<?=$b['stok']?>" class="w-full sm:w-48 bg-dark-300 border border-white/[0.06] rounded-xl px-4 py-3.5 text-sm text-white transition-all"></div>
<div><label class="block text-xs text-zinc-500 font-medium mb-2 uppercase tracking-wider">URL Gambar</label><input type="url" name="gambar" id="gi" value="<?=htmlspecialchars($b['gambar'])?>" class="w-full bg-dark-300 border border-white/[0.06] rounded-xl px-4 py-3.5 text-sm text-white transition-all"></div>
<div><label class="block text-xs text-zinc-500 font-medium mb-2 uppercase tracking-wider">Deskripsi</label><textarea name="deskripsi" rows="4" class="w-full bg-dark-300 border border-white/[0.06] rounded-xl px-4 py-3.5 text-sm text-white transition-all resize-none"><?=htmlspecialchars($b['deskripsi']??'')?></textarea></div>
<div class="pt-4 border-t border-white/[0.04] flex flex-wrap gap-3">
<button type="submit" class="px-8 py-3.5 bg-gradient-to-r from-copper-400 to-copper-600 text-dark-500 font-semibold rounded-xl hover:from-copper-500 hover:to-copper-700 transition-all btn-press shadow-lg shadow-copper-500/15 text-sm"><i class="fas fa-save mr-2"></i>Simpan</button>
<a href="stok_barang.php" class="px-8 py-3.5 border border-white/[0.06] text-zinc-500 rounded-xl hover:bg-white/[0.03] transition-all text-sm">Batal</a>
</div></form></div></section>
<script>document.getElementById('gi').addEventListener('input',function(){if(this.value)document.getElementById('pi').src=this.value;});</script>
<?php htmlFoot();?>
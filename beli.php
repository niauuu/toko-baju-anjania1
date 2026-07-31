<?php require_once 'config.php';
if(!isset($_SESSION['role'])||$_SESSION['role']!=='user'){setToast('error','Silakan login terlebih dahulu.');header("Location:login.php");exit;}
 $id=isset($_GET['id'])?intval($_GET['id']):0;
if($id===0){header("Location:stok_barang.php");exit;}
 $stmt=$conn->prepare("SELECT * FROM kr_produk WHERE id=?");$stmt->bind_param("i",$id);$stmt->execute();$res=$stmt->get_result();
if($res->num_rows===0){header("Location:stok_barang.php");exit;}
 $barang=$res->fetch_assoc();
if($barang['stok']<=0){setToast('error','Stok habis.');header("Location:stok_barang.php");exit;}
htmlHead('Beli '.$barang['nama_produk']);
?>
<section class="py-12">
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
<a href="stok_barang.php" class="reveal inline-flex items-center gap-2 text-sm text-zinc-500 hover:text-copper-400 transition-colors mb-8"><i class="fas fa-arrow-left text-xs"></i>Kembali ke Koleksi</a>
<div class="reveal grid md:grid-cols-2 gap-10 bg-dark-200 border border-white/[0.04] rounded-2xl overflow-hidden">
<div class="relative h-72 md:h-auto bg-dark-300">
<img src="<?=htmlspecialchars($barang['gambar'])?>" alt="" class="w-full h-full object-cover">
<div class="absolute top-4 left-4 px-3 py-1.5 bg-dark-500/80 backdrop-blur-md rounded-full text-xs text-copper-300 font-semibold uppercase tracking-wider"><?=htmlspecialchars($barang['kategori'])?></div>
</div>
<div class="p-8 flex flex-col">
<div class="flex-1">
<h1 class="font-display text-2xl sm:text-3xl font-bold"><?=htmlspecialchars($barang['nama_produk'])?></h1>
<p class="text-copper-400 font-bold text-2xl mt-3"><?=formatRupiah($barang['harga'])?></p>
<div class="flex flex-wrap gap-3 mt-5">
<span class="px-3 py-1.5 bg-white/[0.03] rounded-lg text-xs text-zinc-400"><i class="fas fa-layer-group mr-1.5 text-copper-400"></i><?=htmlspecialchars($barang['bahan'])?></span>
<span class="px-3 py-1.5 rounded-lg text-xs font-medium <?=$barang['stok']>10?'bg-emerald-500/10 text-emerald-400':'bg-amber-500/10 text-amber-400'?>"><i class="fas fa-cubes mr-1.5"></i>Stok: <?=$barang['stok']?></span>
</div>
<p class="text-zinc-500 text-sm leading-relaxed mt-5"><?=htmlspecialchars($barang['deskripsi']??'Tidak ada deskripsi.')?></p>
</div>
<form method="POST" action="prosesbeli.php" class="mt-8 pt-6 border-t border-white/[0.04] space-y-4">
<input type="hidden" name="produk_id" value="<?=$barang['id']?>">
<div>
<label class="block text-xs text-zinc-500 font-medium mb-2 uppercase tracking-wider">Jumlah</label>
<div class="flex items-center gap-3">
<button type="button" onclick="changeQty(-1)" class="w-11 h-11 rounded-xl bg-white/[0.03] border border-white/[0.06] flex items-center justify-center text-zinc-400 hover:bg-white/[0.06] transition-all btn-press"><i class="fas fa-minus text-xs"></i></button>
<input type="number" name="jumlah" id="qtyInput" value="1" min="1" max="<?=$barang['stok']?>" required class="w-20 text-center bg-dark-300 border border-white/[0.06] rounded-xl py-2.5 text-white font-semibold text-lg">
<button type="button" onclick="changeQty(1)" class="w-11 h-11 rounded-xl bg-white/[0.03] border border-white/[0.06] flex items-center justify-center text-zinc-400 hover:bg-white/[0.06] transition-all btn-press"><i class="fas fa-plus text-xs"></i></button>
<span class="text-xs text-zinc-700 ml-1">max: <?=$barang['stok']?></span>
</div></div>
<div class="bg-dark-300/50 rounded-xl p-4 flex items-center justify-between">
<span class="text-sm text-zinc-500">Total Harga</span>
<span id="totalHarga" class="text-xl font-bold text-copper-400"><?=formatRupiah($barang['harga'])?></span>
</div>
<button type="submit" class="w-full py-4 bg-gradient-to-r from-copper-400 to-copper-600 text-dark-500 font-bold rounded-xl hover:from-copper-500 hover:to-copper-700 transition-all btn-press shadow-xl shadow-copper-500/15 text-sm"><i class="fas fa-shopping-cart mr-2"></i>Konfirmasi Pembelian</button>
</form></div></div></div></section>
<script>
var h=<?=$barang['harga']?>,mx=<?=$barang['stok']?>,qi=document.getElementById('qtyInput'),te=document.getElementById('totalHarga');
function cq(d){var v=parseInt(qi.value)+d;if(v<1)v=1;if(v>mx)v=mx;qi.value=v;ut();}
qi.addEventListener('input',ut);
function ut(){var q=parseInt(qi.value);if(isNaN(q)||q<1)q=1;if(q>mx)q=mx;te.textContent='Rp '+(q*h).toLocaleString('id-ID');}
</script>
<?php htmlFoot();?>
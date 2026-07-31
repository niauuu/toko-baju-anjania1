<?php require_once 'config.php';
 $id=intval($_GET['id']??0);
if($id===0){header("Location:stok_barang.php");exit;}
 $s=$conn->prepare("SELECT * FROM kr_transaksi WHERE id=?");$s->bind_param("i",$id);$s->execute();$r=$s->get_result();
if($r->num_rows===0){header("Location:stok_barang.php");exit;}
 $trx=$r->fetch_assoc();
 $gbr='https://images.unsplash.com/photo-1445205170230-053b83016050?w=400&h=300&fit=crop';
if(!empty($trx['produk_id'])){$si=$conn->prepare("SELECT gambar FROM kr_produk WHERE id=?");$si->bind_param("i",$trx['produk_id']);$si->execute();$ir=$si->get_result();if($ir->num_rows>0){$iw=$ir->fetch_assoc();if(!empty($iw['gambar']))$gbr=$iw['gambar'];}}
htmlHead('Struk Pembelian');
?>
<section class="no-print py-12"><div class="max-w-lg mx-auto px-4"><a href="stok_barang.php" class="reveal inline-flex items-center gap-2 text-sm text-zinc-500 hover:text-copper-400 transition-colors mb-8"><i class="fas fa-arrow-left text-xs"></i>Kembali Belanja</a></div></section>
<div class="max-w-lg mx-auto px-4 pb-20">
<div id="receipt" class="reveal bg-white text-gray-900 rounded-2xl shadow-2xl overflow-hidden" style="display:block">
<div class="text-center border-b-2 border-dashed border-gray-300 px-8 pt-8 pb-5">
<div class="flex items-center justify-center gap-2 mb-2"><div class="w-8 h-8 bg-gradient-to-br from-amber-500 to-amber-700 rounded-lg flex items-center justify-center"><i class="fas fa-vest text-white text-xs"></i></div><span class="font-bold text-xl" style="font-family:'Cormorant Garamond',serif">Anjania<span class="text-amber-600">.</span></span></div>
<p class="text-xs text-gray-500">Jl. Busana Premium No. 12, Jakarta Selatan</p>
<p class="text-xs text-gray-500">Telp: +62 812-9876-5432</p>
</div>
<div class="px-8 py-4 border-b-2 border-dashed border-gray-300 text-xs space-y-1.5" style="font-family:monospace">
<div class="flex justify-between"><span class="text-gray-500">No. Transaksi</span><span class="font-semibold">#AJ-<?=str_pad($trx['id'],5,'0',STR_PAD_LEFT)?></span></div>
<div class="flex justify-between"><span class="text-gray-500">Tanggal</span><span class="font-semibold"><?=date('d/m/Y H:i:s',strtotime($trx['tanggal_transaksi']))?></span></div>
<div class="flex justify-between"><span class="text-gray-500">Pembeli</span><span class="font-semibold"><?=htmlspecialchars($trx['nama_pembeli'])?></span></div>
</div>
<div class="px-8 py-5 border-b-2 border-dashed border-gray-300">
<div class="flex items-start gap-4"><div class="w-16 h-16 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0"><img src="<?=htmlspecialchars($gbr)?>" alt="" class="w-full h-full object-cover"></div>
<div class="flex-1 text-xs space-y-1" style="font-family:monospace">
<p class="font-bold text-sm text-gray-900"><?=htmlspecialchars($trx['nama_produk'])?></p>
<p class="text-gray-500">Kategori: <?=htmlspecialchars($trx['kategori'])?> | <?=htmlspecialchars($trx['bahan'])?></p>
<div class="flex justify-between mt-2 pt-2 border-t border-gray-200"><span><?=$trx['jumlah']?> x <?=number_format($trx['harga'],0,',','.')?></span><span class="font-bold text-sm"><?=number_format($trx['total_harga'],0,',','.')?></span></div>
</div></div></div>
<div class="px-8 py-5 border-b-2 border-dashed border-gray-300" style="font-family:monospace">
<div class="flex justify-between mt-3 pt-3 border-t border-gray-300"><span class="font-bold text-base">TOTAL</span><span class="font-bold text-base text-amber-700">Rp <?=number_format($trx['total_harga'],0,',','.')?></span></div>
</div>
<div class="px-8 py-5 text-center">
<div class="inline-block px-4 py-1.5 bg-green-50 text-green-700 rounded-full text-xs font-semibold mb-4"><i class="fas fa-check-circle mr-1"></i>PEMBAYARAN BERHASIL</div>
<div class="mt-5 pt-4 border-t border-dashed border-gray-200"><p class="text-xs text-gray-500">Terima kasih berbelanja di Toko Baju Anjania!</p><p class="text-[10px] text-gray-400 mt-1">Simpan struk sebagai bukti pembayaran</p></div>
<div class="mt-4 text-[8px] text-gray-300">========================================</div>
</div></div>
<div class="no-print reveal flex gap-3 mt-6">
<button onclick="window.print()" class="flex-1 py-4 bg-gradient-to-r from-copper-400 to-copper-600 text-dark-500 font-bold rounded-xl hover:from-copper-500 hover:to-copper-700 transition-all btn-press shadow-xl shadow-copper-500/15 text-sm"><i class="fas fa-print mr-2"></i>Cetak Struk</button>
<a href="stok_barang.php" class="flex-1 py-4 border border-copper-500/25 text-copper-400 font-semibold rounded-xl hover:bg-copper-500/10 transition-all btn-press text-sm text-center"><i class="fas fa-shopping-bag mr-2"></i>Belanja Lagi</a>
</div></div>
<?php htmlFoot();?>
<?php
session_start();

 $host = "sql204.infinityfree.com";
 $user = "if0_41899268";
 $pass = "eHEDtbH1jz";
 $db   = "if0_41899268_allstaryk";

 $conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("DB Error: " . $conn->connect_error);
 $conn->set_charset("utf8mb4");

function formatRupiah($a) { return "Rp " . number_format($a, 0, ',', '.'); }
function setToast($type, $msg) { $_SESSION['toast'] = ['type' => $type, 'message' => $msg]; }

function htmlHead($pageTitle = '') {
    $title = $pageTitle ? htmlspecialchars($pageTitle) . ' — ' : '';
    $isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    $isUser = isset($_SESSION['role']) && $_SESSION['role'] === 'user';
    $loggedIn = isset($_SESSION['role']);
    $nama = $loggedIn ? htmlspecialchars(substr($_SESSION['nama'], 0, 15)) : '';
    $role = $loggedIn ? $_SESSION['role'] : '';
    $initial = $loggedIn ? strtoupper(substr($_SESSION['nama'], 0, 1)) : '';

    $toast = '';
    if (isset($_SESSION['toast'])) {
        $t = $_SESSION['toast']; unset($_SESSION['toast']);
        $bg = $t['type']==='success' ? 'bg-emerald-900/90 border-emerald-500' : 'bg-red-900/90 border-red-500';
        $ic = $t['type']==='success' ? 'fa-check-circle text-emerald-400' : 'fa-times-circle text-red-400';
        $toast = "<div id='toastBox' class='fixed top-6 right-6 z-[100] $bg border backdrop-blur-xl rounded-xl px-5 py-4 flex items-center gap-3 toast-enter max-w-sm'><i class='fas $ic text-lg'></i><p class='text-sm text-zinc-100'>".htmlspecialchars($t['message'])."</p></div><script>setTimeout(()=>{const t=document.getElementById('toastBox');if(t){t.classList.remove('toast-enter');t.classList.add('toast-exit');setTimeout(()=>t.remove(),400);}},3500);</script>";
    }

    echo <<<HTML
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{$title}Toko Baju Anjania</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script>
tailwind.config={theme:{extend:{
    colors:{copper:{300:'#E8C4A0',400:'#D4956A',500:'#C17F59',600:'#A86B45',700:'#8B5A3C'},dark:{100:'#1c1917',200:'#161412',300:'#110f0d',400:'#0d0b09',500:'#0a0908'}},
    fontFamily:{display:['Cormorant Garamond','serif'],body:['Poppins','sans-serif']}
}}}
</script>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Poppins',sans-serif;background:#0a0908;color:#faf5f0;overflow-x:hidden}
::-webkit-scrollbar{width:6px}::-webkit-scrollbar-track{background:#0a0908}::-webkit-scrollbar-thumb{background:#D4956A;border-radius:3px}
.reveal{opacity:0;transform:translateY(30px);transition:all .8s cubic-bezier(.16,1,.3,1)}.reveal.active{opacity:1;transform:translateY(0)}
.card-hover{transition:all .4s cubic-bezier(.16,1,.3,1)}.card-hover:hover{transform:translateY(-6px)}
.btn-press{transition:all .15s ease}.btn-press:active{transform:scale(.96)}
.img-zoom{overflow:hidden}.img-zoom img{transition:transform .6s cubic-bezier(.16,1,.3,1)}.img-zoom:hover img{transform:scale(1.06)}
input:focus,select:focus,textarea:focus{outline:none;border-color:#D4956A!important;box-shadow:0 0 0 3px rgba(212,149,106,.12)!important}
.toast-enter{animation:tIn .5s cubic-bezier(.16,1,.3,1) forwards}
.toast-exit{animation:tOut .4s ease forwards}
@keyframes tIn{from{transform:translateX(120%);opacity:0}to{transform:translateX(0);opacity:1}}
@keyframes tOut{from{transform:translateX(0);opacity:1}to{transform:translateX(120%);opacity:0}}
@keyframes shimmer{0%{background-position:-200% center}100%{background-position:200% center}}
.shimmer-text{background:linear-gradient(90deg,#D4956A,#F5DFC8,#D4956A,#F5DFC8,#D4956A);background-size:200% auto;-webkit-background-clip:text;-webkit-text-fill-color:transparent;animation:shimmer 5s linear infinite}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-12px)}}.float{animation:float 6s ease-in-out infinite}
@keyframes glow-pulse{0%,100%{opacity:.4}50%{opacity:.8}}.glow-pulse{animation:glow-pulse 4s ease-in-out infinite}
.hero-mesh{background:radial-gradient(ellipse at 20% 40%,rgba(212,149,106,.08) 0%,transparent 50%),radial-gradient(ellipse at 80% 20%,rgba(212,149,106,.05) 0%,transparent 50%),radial-gradient(ellipse at 50% 90%,rgba(193,127,89,.04) 0%,transparent 40%),#0a0908}
.hero-grid{background-image:linear-gradient(rgba(212,149,106,.02) 1px,transparent 1px),linear-gradient(90deg,rgba(212,149,106,.02) 1px,transparent 1px);background-size:60px 60px}
.nav-link{position:relative}.nav-link::after{content:'';position:absolute;bottom:-3px;left:0;width:0;height:2px;background:#D4956A;transition:width .3s ease;border-radius:1px}.nav-link:hover::after,.nav-link.active::after{width:100%}
@media print{body{background:#fff!important}.no-print{display:none!important}.print-only{display:block!important}}
.print-only{display:none}
</style>
</head>
<body>
 $toast
<nav class="no-print fixed top-0 left-0 right-0 z-50 bg-dark-500/80 backdrop-blur-2xl border-b border-white/[0.04]">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="flex items-center justify-between h-16">
<a href="index.php" class="flex items-center gap-2.5 group">
<div class="w-9 h-9 bg-gradient-to-br from-copper-400 to-copper-600 rounded-lg flex items-center justify-center shadow-lg shadow-copper-500/15 group-hover:shadow-copper-500/30 transition-shadow">
<i class="fas fa-vest text-dark-500 text-sm"></i>
</div>
<span class="font-display text-lg font-bold tracking-wide">Anjania<span class="text-copper-400">.</span></span>
</a>
<div class="hidden lg:flex items-center gap-1">
<a href="index.php" class="nav-link px-4 py-2 text-sm text-zinc-400 hover:text-white transition-colors">Home</a>
<a href="stok_barang.php" class="nav-link px-4 py-2 text-sm text-zinc-400 hover:text-white transition-colors">Koleksi</a>
HTML;
    if ($isAdmin) {
        echo <<<HTML
<a href="admin_dashboard.php" class="nav-link px-4 py-2 text-sm text-zinc-400 hover:text-white transition-colors">Dashboard</a>
<a href="tambah.php" class="nav-link px-4 py-2 text-sm text-zinc-400 hover:text-white transition-colors">Tambah</a>
<a href="logs_pesanan.php" class="nav-link px-4 py-2 text-sm text-zinc-400 hover:text-white transition-colors">Logs</a>
HTML;
    }
    echo <<<HTML
</div>
<div class="flex items-center gap-3">
HTML;
    if ($loggedIn) {
        echo <<<HTML
<div class="hidden sm:flex items-center gap-2">
<div class="w-8 h-8 rounded-full bg-gradient-to-br from-copper-400 to-copper-700 flex items-center justify-center text-dark-500 text-xs font-bold">$initial</div>
<div class="text-xs"><p class="text-zinc-300 font-medium leading-tight">$nama</p><p class="text-copper-400 text-[10px] uppercase tracking-wider font-semibold">$role</p></div>
</div>
<a href="logout.php" class="px-4 py-2 text-xs font-medium bg-red-600/15 text-red-400 border border-red-500/25 rounded-lg hover:bg-red-600/25 transition-all btn-press"><i class="fas fa-sign-out-alt mr-1"></i>Logout</a>
HTML;
    } else {
        echo <<<HTML
<a href="login.php" class="nav-link hidden lg:block px-4 py-2 text-sm text-zinc-400 hover:text-white transition-colors">Login</a>
<a href="register.php" class="px-5 py-2 text-sm font-semibold bg-gradient-to-r from-copper-400 to-copper-600 text-dark-500 rounded-lg hover:from-copper-500 hover:to-copper-700 transition-all btn-press shadow-lg shadow-copper-500/15">Daftar</a>
HTML;
    }
    echo <<<HTML
</div>
<button onclick="document.getElementById('mob').classList.toggle('hidden')" class="lg:hidden text-zinc-400 hover:text-white p-2"><i class="fas fa-bars text-xl"></i></button>
</div>
</div>
<div id="mob" class="hidden lg:hidden bg-dark-500/95 backdrop-blur-2xl border-t border-white/[0.04] pb-4">
<div class="px-4 pt-3 space-y-1">
<a href="index.php" class="block px-4 py-3 text-sm text-zinc-400 hover:text-white hover:bg-white/5 rounded-lg">Home</a>
<a href="stok_barang.php" class="block px-4 py-3 text-sm text-zinc-400 hover:text-white hover:bg-white/5 rounded-lg">Koleksi</a>
HTML;
    if ($isAdmin) echo '<a href="admin_dashboard.php" class="block px-4 py-3 text-sm text-zinc-400 hover:text-white hover:bg-white/5 rounded-lg">Dashboard</a><a href="tambah.php" class="block px-4 py-3 text-sm text-zinc-400 hover:text-white hover:bg-white/5 rounded-lg">Tambah</a><a href="logs_pesanan.php" class="block px-4 py-3 text-sm text-zinc-400 hover:text-white hover:bg-white/5 rounded-lg">Logs</a>';
    if ($loggedIn) echo '<a href="logout.php" class="block px-4 py-3 text-sm text-red-400 hover:bg-red-600/10 rounded-lg">Logout</a>';
    else echo '<a href="login.php" class="block px-4 py-3 text-sm text-zinc-400 hover:text-white hover:bg-white/5 rounded-lg">Login</a><a href="register.php" class="block px-4 py-3 text-sm text-copper-400 font-semibold hover:bg-copper-500/5 rounded-lg">Daftar</a>';
    echo <<<HTML
</div></div></nav>
<main class="pt-16">
HTML;
}

function htmlFoot() {
    echo <<<HTML
</main>
<footer class="no-print mt-20 border-t border-white/[0.04] bg-dark-400">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
<div class="grid grid-cols-1 md:grid-cols-4 gap-10">
<div class="md:col-span-2">
<a href="index.php" class="flex items-center gap-2.5 mb-4">
<div class="w-9 h-9 bg-gradient-to-br from-copper-400 to-copper-600 rounded-lg flex items-center justify-center"><i class="fas fa-vest text-dark-500 text-sm"></i></div>
<span class="font-display text-lg font-bold">Anjania<span class="text-copper-400">.</span></span>
</a>
<p class="text-zinc-600 text-sm leading-relaxed max-w-sm">Toko baju terpercaya sejak 2018. Menyediakan berbagai koleksi pakaian berkualitas premium dengan harga terjangkau.</p>
</div>
<div>
<h4 class="text-sm font-semibold text-zinc-300 mb-4 uppercase tracking-wider">Menu</h4>
<ul class="space-y-2.5 text-sm text-zinc-600">
<li><a href="index.php" class="hover:text-copper-400 transition-colors">Home</a></li>
<li><a href="stok_barang.php" class="hover:text-copper-400 transition-colors">Koleksi</a></li>
<li><a href="login.php" class="hover:text-copper-400 transition-colors">Login</a></li>
<li><a href="register.php" class="hover:text-copper-400 transition-colors">Daftar</a></li>
</ul>
</div>
<div>
<h4 class="text-sm font-semibold text-zinc-300 mb-4 uppercase tracking-wider">Kontak</h4>
<ul class="space-y-2.5 text-sm text-zinc-600">
<li class="flex items-center gap-2"><i class="fas fa-map-marker-alt text-copper-400 w-4"></i>Jakarta Selatan</li>
<li class="flex items-center gap-2"><i class="fas fa-phone text-copper-400 w-4"></i>+62 812-9876-5432</li>
<li class="flex items-center gap-2"><i class="fab fa-whatsapp text-copper-400 w-4"></i>0812-9876-5432</li>
</ul>
</div>
</div>
<div class="mt-10 pt-8 border-t border-white/[0.04] flex flex-col sm:flex-row items-center justify-between gap-4">
<p class="text-xs text-zinc-700">&copy; 2025 Toko Baju Anjania. All rights reserved.</p>
<div class="flex gap-3">
<a href="#" class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-600 hover:text-copper-400 hover:bg-copper-400/10 transition-all"><i class="fab fa-instagram text-sm"></i></a>
<a href="#" class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-600 hover:text-copper-400 hover:bg-copper-400/10 transition-all"><i class="fab fa-tiktok text-sm"></i></a>
<a href="#" class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-600 hover:text-copper-400 hover:bg-copper-400/10 transition-all"><i class="fab fa-facebook text-sm"></i></a>
</div>
</div>
</div>
</footer>
<script>
const obs=new IntersectionObserver(e=>{e.forEach(x=>{if(x.isIntersecting)x.target.classList.add('active')})},{threshold:.08});
document.querySelectorAll('.reveal').forEach(el=>obs.observe(el));
</script>
</body>
</html>
HTML;
}
?>
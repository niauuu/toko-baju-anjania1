<?php require_once 'config.php';
if(isset($_SESSION['role'])){header("Location:".($_SESSION['role']==='admin'?'admin_dashboard.php':'index.php'));exit;}
if($_SERVER['REQUEST_METHOD']==='POST'){
    $email=trim($_POST['email']??'');$password=$_POST['password']??'';
    $stmt=$conn->prepare("SELECT * FROM kr_users WHERE email=?");$stmt->bind_param("s",$email);$stmt->execute();
    $user=$stmt->get_result()->fetch_assoc();
    if($user&&password_verify($password,$user['password'])){
        $_SESSION['id']=$user['id'];$_SESSION['nama']=$user['nama'];$_SESSION['email']=$user['email'];$_SESSION['role']=$user['role'];
        setToast('success','Selamat datang, '.$user['nama'].'!');
        header("Location:".($user['role']==='admin'?'admin_dashboard.php':'index.php'));exit;
    }else{$error="Email atau password salah.";}
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — Toko Baju Anjania</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script>tailwind.config={theme:{extend:{colors:{copper:{300:'#E8C4A0',400:'#D4956A',500:'#C17F59',600:'#A86B45'},dark:{200:'#161412',300:'#110f0d',500:'#0a0908'}},fontFamily:{display:['Cormorant Garamond','serif'],body:['Poppins','sans-serif']}}}}</script>
<style>body{font-family:'Poppins',sans-serif;background:#0a0908;color:#faf5f0}input:focus{outline:none;border-color:#D4956A!important;box-shadow:0 0 0 3px rgba(212,149,106,.12)!important}.btn-press{transition:all .15s ease}.btn-press:active{transform:scale(.96)}.toast-enter{animation:tIn .5s cubic-bezier(.16,1,.3,1) forwards}.toast-exit{animation:tOut .4s ease forwards}@keyframes tIn{from{transform:translateX(120%);opacity:0}to{transform:translateX(0);opacity:1}}@keyframes tOut{from{transform:translateX(0);opacity:1}to{transform:translateX(120%);opacity:0}}</style>
</head>
<body class="min-h-screen flex items-center justify-center p-4" style="background:radial-gradient(ellipse at 30% 40%,rgba(212,149,106,.06) 0%,transparent 50%),#0a0908">

<?php if(isset($_SESSION['toast'])):$t=$_SESSION['toast'];unset($_SESSION['toast']);$bg=$t['type']==='success'?'bg-emerald-900/90 border-emerald-500':'bg-red-900/90 border-red-500';$ic=$t['type']==='success'?'fa-check-circle text-emerald-400':'fa-times-circle text-red-400';?>
<div id="toastBox" class="fixed top-6 right-6 z-[100] <?=$bg?> border backdrop-blur-xl rounded-xl px-5 py-4 flex items-center gap-3 toast-enter max-w-sm"><i class="fas <?=$ic?> text-lg"></i><p class="text-sm text-zinc-100"><?=htmlspecialchars($t['message'])?></p></div>
<script>setTimeout(()=>{const t=document.getElementById('toastBox');if(t){t.classList.remove('toast-enter');t.classList.add('toast-exit');setTimeout(()=>t.remove(),400);}},3500);</script>
<?php endif;?>

<div class="w-full max-w-md">
<div class="text-center mb-8">
<a href="index.php" class="inline-flex items-center gap-2.5 mb-6">
<div class="w-10 h-10 bg-gradient-to-br from-copper-400 to-copper-600 rounded-xl flex items-center justify-center shadow-lg shadow-copper-500/20"><i class="fas fa-vest text-dark-500 text-sm"></i></div>
<span class="font-display text-xl font-bold">Anjania<span class="text-copper-400">.</span></span>
</a>
<h1 class="font-display text-3xl font-bold">Masuk ke Akun</h1>
<p class="text-zinc-600 text-sm mt-2">Masukkan kredensial untuk melanjutkan</p>
</div>
<div class="bg-dark-200 border border-white/[0.04] rounded-2xl p-8 shadow-2xl">
<?php if(isset($error)):?><div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-400 text-sm flex items-center gap-3"><i class="fas fa-exclamation-circle"></i><?=htmlspecialchars($error)?></div><?php endif;?>
<form method="POST" class="space-y-5">
<div>
<label class="block text-xs text-zinc-500 font-medium mb-2 uppercase tracking-wider">Email</label>
<div class="relative"><i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-zinc-700 text-sm"></i>
<input type="email" name="email" required placeholder="nama@email.com" class="w-full bg-dark-300 border border-white/[0.06] rounded-xl pl-11 pr-4 py-3.5 text-sm text-white placeholder-zinc-700 transition-all"></div>
</div>
<div>
<label class="block text-xs text-zinc-500 font-medium mb-2 uppercase tracking-wider">Password</label>
<div class="relative"><i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-zinc-700 text-sm"></i>
<input type="password" name="password" required placeholder="Masukkan password" class="w-full bg-dark-300 border border-white/[0.06] rounded-xl pl-11 pr-4 py-3.5 text-sm text-white placeholder-zinc-700 transition-all"></div>
</div>
<button type="submit" class="w-full py-3.5 bg-gradient-to-r from-copper-400 to-copper-600 text-dark-500 font-semibold rounded-xl hover:from-copper-500 hover:to-copper-700 transition-all btn-press shadow-lg shadow-copper-500/15 text-sm">Masuk</button>
</form>
<div class="mt-6 pt-6 border-t border-white/[0.04] text-center">
<p class="text-sm text-zinc-600">Belum punya akun? <a href="register.php" class="text-copper-400 font-medium hover:underline">Daftar Sekarang</a></p>
</div>
<div class="mt-5 p-3 bg-dark-300/50 rounded-xl"><p class="text-[11px] text-zinc-700 text-center">Demo Admin: <span class="text-zinc-500">admin@anjania.com</span> / <span class="text-zinc-500">admin123</span></p></div>
</div>
</div>
</body></html>
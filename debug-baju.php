<?php
session_start();
 $host = "sql204.infinityfree.com";
 $user = "if0_41899268";
 $pass = "eHEDtbH1jz";
 $db   = "if0_41899268_allstaryk";
 $c = new mysqli($host, $user, $pass, $db);
if ($c->connect_error) die("DB Error: " . $c->connect_error);
 $c->set_charset("utf8mb4");

echo "<div style='background:#111;color:#ddd;padding:30px;font-family:monospace;font-size:14px'>";
echo "<h2 style='color:#D4956A'>DEBUG LOGIN ANJANIA</h2><hr><br>";
echo "DB: <b>$db</b><br><br>";

echo "<b>Semua akun:</b><br><br>";
 $users = $c->query("SELECT id, nama, email, role, password, LENGTH(password) as plen FROM kr_users");
while ($u = $users->fetch_assoc()) {
    $w = $u['role'] === 'admin' ? '#D4956A' : '#a1a1aa';
    echo "<span style='color:$w'>[$u[role]] ID=$u[id] | $u[nama] | $u[email] | hash_len=$u[plen]</span><br>";
    echo "&nbsp;&nbsp;hash: <span style='font-size:10px;color:#555'>$u[password]</span><br><br>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pw = $_POST['password'] ?? '';
    echo "<hr><b>TEST:</b> $email / $pw<br><br>";

    $stmt = $c->prepare("SELECT * FROM kr_users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    echo "Ditemukan: " . $res->num_rows . "<br>";
    if ($res->num_rows > 0) {
        $u = $res->fetch_assoc();
        echo "Role: $u[role]<br>";
        echo "Hash: $u[password]<br>";
        echo "Len: " . strlen($u['password']) . "<br>";
        $v = password_verify($pw, $u['password']);
        echo "Verify: <span style='color:" . ($v ? '#34d399' : '#f87171') . ";font-size:20px'><b>" . ($v ? 'BERHASIL' : 'GAGAL') . "</b></span><br>";
        if (!$v && strlen($u['password']) < 50) echo "<br><span style='color:#f87171'>Hash terlalu pendek! Password disimpan sebagai teks biasa. Klik FIX HASH.</span><br>";
    }
}

echo "<br><hr><form method='POST'>";
echo "Email: <input name='email' style='padding:8px;width:300px;background:#222;border:1px solid #333;color:#fff;margin:5px'><br>";
echo "Pass: <input name='password' style='padding:8px;width:300px;background:#222;border:1px solid #333;color:#fff;margin:5px'><br>";
echo "<button style='padding:10px 30px;background:#D4956A;color:#000;border:none;font-weight:bold;cursor:pointer;margin:10px'>TEST</button>";
echo "</form><br>";
echo "<span style='color:#f87171;font-size:18px'>HAPUS FILE INI!</span></div>";
?>

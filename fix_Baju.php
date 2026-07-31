<?php
 $host = "sql204.infinityfree.com";
 $user = "if0_41899268";
 $pass = "eHEDtbH1jz";
 $db   = "if0_41899268_allstaryk";

 $c = new mysqli($host, $user, $pass, $db);
if ($c->connect_error) die("DB Error: " . $c->connect_error);
 $c->set_charset("utf8mb4");

// Fix kolom
 $c->query("ALTER TABLE kr_users MODIFY COLUMN password VARCHAR(255) NOT NULL");

// Hash baru
 $h = password_hash("admin123", PASSWORD_DEFAULT);

// Update SEMUA admin
 $s = $c->prepare("UPDATE kr_users SET password = ? WHERE role = 'admin'");
 $s->bind_param("s", $h);
 $s->execute();

// Cek
 $cek = $c->query("SELECT password FROM kr_users WHERE role='admin' LIMIT 1")->fetch_assoc();
 $ok = password_verify("admin123", $cek['password']);

echo "<div style='background:#111;color:#ddd;padding:30px;font-family:monospace'>";
echo "<b style='color:#D4956A'>FIX ADMIN ANJANIA</b><hr><br>";
echo "DB: $db<br>";
echo "Kolom password: VARCHAR(255) OK<br>";
echo "Hash: $h<br>";
echo "Hash len: " . strlen($h) . "<br><br>";
echo "Verify: <span style='color:" . ($ok ? '#34d399' : '#f87171') . ";font-size:20px'><b>" . ($ok ? 'BERHASIL' : 'GAGAL') . "</b></span><br>";
echo "Login: <b>admin@anjania.com</b> / <b>admin123</b><br><br>";
echo "<span style='color:#f87171;font-size:18px'>HAPUS FILE INI!</span>";
echo "</div>";
?>

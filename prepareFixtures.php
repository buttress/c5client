<?php
chdir(__DIR__ . '/fixtures');
$token = isset($argv[1]) ? $argv[1] : '';

register_shutdown_function(function () {
    if (is_dir('temp')) {
        foreach (scandir('temp') as $item) {
            if (trim($item, '.') && !is_dir($item)) {
                unlink("temp/{$item}");
            }
        }
    }
});

$info = [
    'legacy' => 'https://api.github.com/repos/concrete5/concrete5-legacy/tags',
    'modern' => 'https://api.github.com/repos/concrete5/concrete5/tags'
];
$headers = [
    'User-Agent: php-github-api (http://github.com/KnpLabs/php-github-api)',
];

if ($token) {
    $headers[] = 'Authorization: token ' . $token;
}

echo "Querying github releases\n";
$info = array_map(function ($item) use ($headers) {
    $ch = curl_init($item);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers,
    ]);
    $result = curl_exec($ch);
    $code = "" . curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($code[0] === '2') {
        return json_decode($result, true);
    }

    return [];
}, $info);

if (empty($info['modern']) && empty($info['legacy'])) {
    die('Unable to query github API.');
}

$highestV7 = $highestV8 = '0';
$highestV7Tag = $highestV8Tag = null;
$highestV6Tag = reset($info['legacy']);

foreach ($info['modern'] as $tag) {
    // Isolate the highest v7 version available
    if (version_compare($highestV7, $tag['name'], '<') && version_compare($tag['name'], '8.0', '<')) {
        $highestV7 = $tag['name'];
        $highestV7Tag = $tag;
    }

    // Isolate the highest v8 version available
    if (version_compare($highestV8, $tag['name'], '<')) {
        $highestV8 = $tag['name'];
        $highestV8Tag = $tag;
    }
}

$versions = [
    'v6' => $highestV6Tag,
    'v7' => $highestV7Tag,
    'v8' => $highestV8Tag,
];

if (!is_dir('temp')) {
    if (!@mkdir('temp') && !is_dir('temp')) {
        die('Unable to create temporary directory. Do you have permission?');
    }
}

foreach ($versions as $name => $version) {
    if ($version) {

        echo "Downloading version {$version['name']}...\n";

        $zip = "temp/{$name}.zip";
        if (file_exists($zip)) {
            unlink($zip);
        }

        $file = fopen($zip, 'w+b');

        $ch = curl_init($version['zipball_url']);

        curl_setopt_array($ch, [
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FILE => $file,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_FOLLOWLOCATION => true
        ]);

        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        fclose($file);

        if (!file_exists($zip) || !filesize($zip)) {
            die("Failed to download zipfile. {$code}..\n");
        }
        $archive = new ZipArchive();
        if (($error = $archive->open($zip)) && $error !== true) {
            die("Unable to open zip file for {$name}.");
        }

        echo "Extracting {$zip}...\n";
        if (!$archive->extractTo("temp/{$name}")) {
            die('Failed to extract zip file.');
        }

        $directories = array_filter(scandir("temp/{$name}"), function ($item) {
            return !!trim($item, '.');
        });
        $directory = array_shift($directories);

        if (file_exists($name)) {
            unlink($name);
        }
        link("temp/{$name}/{$directory}", $name);
    }
}

foreach ($versions as $name => $version) {
    echo "Initializing dependencies for {$name}\n";

    if ($name === 'v6') {
        continue;
    }

    if ($name === 'v7') {
        shell_exec("cd v7/web/concrete; composer install");
    } else {
        shell_exec("cd {$name}; composer install");
    }
}

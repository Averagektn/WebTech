<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    error_reporting(0);
    ini_set('display_errors', 0);

    $url = $_POST['url'];
    $path = $_POST['path'];

    // Check if folder exists
    if (!is_dir($path) || !is_writable($path)) {
        echo 'Directory does not exist or non-writable';
        exit;
    }

    // SSL certificate ignore
    $opts = [
        "ssl" => [
            "verify_peer" => false,
            "verify_peer_name" => false,
        ],
        "http" => [
            "user_agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36",
        ],
    ];
    $context = stream_context_create($opts);

    // Get HTML of the page
    $html = file_get_contents($url, false, $context);

    // Get mages URL
    preg_match_all('/<img.+?src=[\"\'](.+?)[\"\'].*?>/i', $html, $matches);
    $url = parse_url($url);
    foreach ($matches[1] as $image_url) {
        if (!str_starts_with($image_url, $url["scheme"] . "://" . $url["host"])){
            $image_url = $url["scheme"] . "://" . $url["host"] . $image_url;
        }

        // Saved file name
        $filename = basename($image_url);
        // Path to file
        $filepath = $path . DIRECTORY_SEPARATOR . $filename;

        $image_data = file_get_contents($image_url, false, $context);

        if ($image_data !== false){
            file_put_contents($filepath, $image_data);
        }

    }

    echo 'All images were successfully downloaded!';

} else {
    header('Location: index.html');
    exit;
}

<?php
function processPage($url, $path, $depth): void
{
    if ($depth <= 1) {
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

        $pageFolder = $path . DIRECTORY_SEPARATOR . basename($url);
        if (!is_dir($pageFolder)) {
            echo "FOLDER: " . $pageFolder . '<br>';
            mkdir($pageFolder, 0777, true);
        }

        // Get images URL
        preg_match_all('/<img.+?src=[\"\'](.+?)[\"\'].*?>/i', $html, $matches);

        foreach ($matches[1] as $image_url) {
            if (!str_starts_with($image_url, "https://wallpapercave.com")) {
                $image_url = "https://wallpapercave.com" . $image_url;
            }

            // Saved file name
            $filename = basename($image_url);
            // Path to file
            $filepath = $pageFolder . DIRECTORY_SEPARATOR . $filename;

            if (!file_exists($filepath)){
                echo "DOWNLOADED: " . $filepath  . '<br>';
                $image_data = file_get_contents($image_url, false, $context);
                if ($image_data !== false) {
                    file_put_contents($filepath, $image_data);
                }
            }
        }

        // Find and process subpages
        preg_match_all('/<a.+?href=[\"\'](.+?)[\"\'].*?>/i', $html, $subpage_matches);

        for ($i = 0; $i < count($subpage_matches[0]); $i++) {
            if (str_contains($subpage_matches[0][$i], "albumthumbnail")) {
                $subpage_url = $subpage_matches[1][$i];
                if (!str_starts_with($subpage_url, "https://wallpapercave.com")) {
                    // Construct full URL if the link is relative
                    $subpage_url = "https://wallpapercave.com" . $subpage_url;
                }
                echo "SUBPAGE: " . $subpage_url . '<br>';

                // Process the subpage recursively
                processPage($subpage_url, $path, $depth + 1);
            }
        }
    }
}

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

    // Call the processPage function to start the analysis and image download
    processPage($url, $path, 0);

    echo 'All images were successfully downloaded!';
} else {
    header('Location: index.html');
    exit;
}
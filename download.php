<?php
if (isset($_POST['download'])) {
    $youtubeLink = $_POST['youtubeLink'];
    $fileType = $_POST['fileType'];
    $quality = $_POST['quality'];

    // YouTube API kulcs
    $apiKey = 'AIzaSyD8DRjDK1UMDiKmwPMygljSswQjVZgBPvw';

    // YouTube videó információ lekérése
    $videoId = getVideoId($youtubeLink);
    $videoInfo = getVideoInfo($videoId, $apiKey);

    if ($videoInfo) {
        $title = $videoInfo['title'];
        $extension = ($fileType === 'audio') ? 'mp3' : 'mp4';
        $filename = sanitizeFilename($title) . '.' . $extension;

        // Letöltési folyamat
        $downloadUrl = ($fileType === 'audio') ? $videoInfo['audioUrl'] : $videoInfo['videoUrl'];
        downloadFile($downloadUrl, $filename);
    }
}

// YouTube videó ID kinyerése a linkből
function getVideoId($link) {
    $parsedUrl = parse_url($link);
    parse_str($parsedUrl['query'], $queryParams);
    if (isset($queryParams['v'])) {
        return $queryParams['v'];
    } elseif (isset($queryParams['watch?v'])) {
        return $queryParams['watch?v'];
    }
    return false;
}

// YouTube videó információ lekérése a YouTube API-val
function getVideoInfo($videoId, $apiKey) {
    $url = 'https://www.googleapis.com/youtube/v3/videos?id=' . $videoId . '&key=' . $apiKey . '&part=snippet';
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if (isset($data['items'][0])) {
        $title = $data['items'][0]['snippet']['title'];
        $audioUrl = 'https://www.youtube.com/watch?v=' . $videoId;
        $videoUrl = 'https://www.youtube.com/watch?v=' . $videoId;
        return array('title' => $title, 'audioUrl' => $audioUrl, 'videoUrl' => $videoUrl);
    }
    return false;
}

// Biztonságos fájlnév létrehozása
function sanitizeFilename($filename) {
    $filename = preg_replace('/[^a-zA-Z0-9\s\-_.]/', '', $filename);
    $filename = str_replace(' ', '_', $filename);
    return $filename;
}

// Fájl letöltése
function downloadFile($url, $filename) {
    $extension = pathinfo($url, PATHINFO_EXTENSION);
    $downloadFilename = ($extension === 'mp3' || $extension === 'mp4') ? 'zene.' . $extension : $filename;
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $downloadFilename . '"');
    readfile($url);
    exit;
}
?>

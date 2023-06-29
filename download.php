<?php
if (isset($_POST['download'])) {
    $youtubeLink = $_POST['youtubeLink'];
    $fileType = $_POST['fileType'];
    $quality = $_POST['quality'];

    // Letöltési folyamat
    if ($fileType === 'audio') {
        $command = 'youtube-dl -x --audio-format mp3 --audio-quality ' . $quality . ' --output "%(title)s.%(ext)s" ' . escapeshellarg($youtubeLink);
    } else {
        $command = 'youtube-dl -f "bestvideo[height<=' . $quality . ']+bestaudio[ext=m4a]/best[ext=mp4]" --output "%(title)s.%(ext)s" ' . escapeshellarg($youtubeLink);
    }

    // Parancs végrehajtása
    exec($command, $output, $return_var);

    if ($return_var === 0) {
        echo 'A letöltés sikeresen megtörtént.';
    } else {
        echo 'Hiba történt a letöltés során.';
    }
}
?>

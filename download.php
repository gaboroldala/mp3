<?php
if (isset($_GET['youtubeLink']) && isset($_GET['fileType']) && isset($_GET['quality'])) {
  $youtubeLink = $_GET['youtubeLink'];
  $fileType = $_GET['fileType'];
  $quality = $_GET['quality'];

  // Letöltési folyamat
  if ($fileType === 'audio') {
    $command = 'youtube-dl -x --audio-format mp3 --audio-quality ' . $quality . ' ' . escapeshellarg($youtubeLink);
  } else {
    $command = 'youtube-dl -f bestvideo[height<=' . $quality . ']+' . 'bestaudio/best' . ' ' . escapeshellarg($youtubeLink);
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

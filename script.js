document.getElementById('downloadForm').addEventListener('submit', function(event) {
  event.preventDefault();

  var form = event.target;
  var youtubeLink = form.elements.youtubeLink.value;
  var fileType = form.elements.fileType.value;
  var quality = form.elements.quality.value;

  var downloadUrl = '/download.php?youtubeLink=' + encodeURIComponent(youtubeLink) + '&fileType=' + fileType + '&quality=' + quality;

  var link = document.createElement('a');
  link.href = downloadUrl;
  link.setAttribute('download', 'zene.' + fileType);  // A fájl neve: zene.mp3 vagy zene.mp4
  link.style.display = 'none';
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
});

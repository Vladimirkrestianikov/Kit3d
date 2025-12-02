<?php

// test_upload.php
echo "POST max size: " . ini_get('post_max_size') . "\n";
echo "Upload max size: " . ini_get('upload_max_filesize') . "\n";
echo "Memory limit: " . ini_get('memory_limit') . "\n";

if ($_FILES) {
    echo "File received: " . $_FILES['file']['name'] . "\n";
    echo "File size: " . $_FILES['file']['size'] . " bytes\n";
}
?>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <input type="submit" value="Upload">
</form>
<?php
if (isset($_GET['file'])) {
    $filePath = $_GET['file'];

    //check if the file existe on the server
    if (file_exists($filePath)) {
    //Set an HTTP header indicating that the response contains a file transfer description
        header('Content-Description: File Transfer');
    //Set the content type to "application/octet-stream" to indicate a generic byte stream for file download.
        header('Content-Type: application/octet-stream');
    //Specify the content disposition as an attachment and provide the filename for the downloaded file
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
    //Set the expiration of the response to 0, preventing caching by the browser.
        header('Expires: 0');
    //Specify that the response must be revalidated by the browser before reuse.
        header('Cache-Control: must-revalidate');
    //Indicate that the response is intended to be publicly cached.
        header('Pragma: public');
    // Provide the content length of the file to help the browser display a download progress bar
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    } else {
        echo 'File not found.';
    }
} else {
    echo 'File path not provided.';
}
?>

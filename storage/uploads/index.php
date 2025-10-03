<?php
// Simples servidor de imagens para o diretório storage/uploads

// Captura o caminho da URL
$requestUri = $_SERVER['REQUEST_URI'];

// Remove /storage/uploads/ do início
if (strpos($requestUri, '/storage/uploads/') === 0) {
    $filename = substr($requestUri, strlen('/storage/uploads/'));
    
    // Remove query parameters se houver
    if (($pos = strpos($filename, '?')) !== false) {
        $filename = substr($filename, 0, $pos);
    }
    
    $filePath = '/var/www/html/storage/uploads/' . $filename;
    
    if (file_exists($filePath) && is_file($filePath)) {
        // Determina o tipo MIME
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filePath);
        finfo_close($finfo);
        
        // Define headers
        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . filesize($filePath));
        header('Cache-Control: public, max-age=3600');
        
        // Serve o arquivo
        readfile($filePath);
        exit;
    }
}

// Se não encontrou, retorna 404
http_response_code(404);
echo 'Imagem não encontrada';
?>
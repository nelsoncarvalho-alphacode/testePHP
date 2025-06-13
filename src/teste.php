<?php
$conn = mysqli_connect("mysql", "wesley", "1234", "teste-pratico", 3307);

if (!$conn) {
    die("❌ Connection failed: " . mysqli_connect_error()); // Shows exact error
}

?>
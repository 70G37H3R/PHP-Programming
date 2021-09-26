<?php
require "../bootstrap.php";

use CT275\Lab4\Book;



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delkey'])) {
        $key = $_POST['delkey'];
        echo $key;
        $delBook = Book::where("id", $key)->delete();
    }
    
}

header('location: ./books.php');
?>

<?php
require "../bootstrap.php";

use CT275\Lab4\Author;

?>
<style>
    table,
    th,
    td {
        border: 1px solid black;
    }

    label {
        display: inline-block;
        width: 150px;
    }
</style>
<h2>Search</h2>
<form method="POST">

    <label>Title:</label> <input type="text" name="searchkey" />
    <input type="submit" name="submit" value="Save" />
    <br>
    <label>Result:</label><?php
                            if (isset($_POST['searchkey'])) {
                                $key = $_POST['searchkey'];

                                $search = Author::withWhereHas('books', fn($query) =>
                                $query->where('title', 'like', "%{$key}%" ))
                                ->orWhere('first_name', 'like', "%{$key}%")->with('books')
                                ->orWhere('last_name', 'like', "%{$key}%")->with('books')
                                ->get();
                                
                                
                                foreach ($search as $rs) {
                                    echo "<p> test 2=" . $rs . "</p>";
                                    $booklist=$rs->books;
                                    foreach ($booklist as $book) {
                                        echo "<p> Book title=" . $book->title . "</p>";
                                        echo "<p> Book Pages Count =" . $book->pages_count  . "</p>";
                                        echo "<p> Book price =" . $book->price  . "</p>";
                                        echo "<p> Book des =" . $book->description  . "</p>";
                                        
                                    }
                                    echo "<p> Author =" . $rs->first_name . $rs->last_name 
                                        . " (" . $rs->email . ")" ."</p>";

                                   
                                }
                                
                            }

                            ?>
</form>
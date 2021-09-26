<?php
require "../bootstrap.php";

use CT275\Lab4\Author;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;


$builder = new CaptchaBuilder;
$builder->build();


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

    <br><br><br>
    <img src="<?php echo $builder->inline(); ?>" />
    <span>
        <input type="text" id="phrase" name="phrase" class="form-control" />
    </span>
    <br><br>

    <label>Title:</label> <input type="text" name="searchkey" />
    <input type="submit" name="submit" value="Save" />
    <br>
    <label>Result:</label>
    <table style="width:100%">
        <tr>
            <th>Title</th>
            <th>Num of Pages</th>
            <th>Price</th>
            <th>Description</th>
            <th>Author</th>
        </tr>
        <?php


        if (PhraseBuilder::comparePhrases($_SESSION['phrase'], $_POST['phrase'])) {

            if (isset($_POST['searchkey'])) {
                $key = $_POST['searchkey'];

                $search = Author::withWhereHas('books', fn ($query) =>
                $query->where('title', 'like', "%{$key}%"))
                    ->orWhere('first_name', 'like', "%{$key}%")->with('books')
                    ->orWhere('last_name', 'like', "%{$key}%")->with('books')
                    ->get();


                foreach ($search as $rs) {

                    $booklist = $rs->books;
                    echo "<tr>";
                    foreach ($booklist as $book) {

                        echo "<td> Book title=" . $book->title . "</td>";
                        echo "<td> Book Pages Count =" . $book->pages_count  . "</td>";
                        echo "<td> Book price =" . $book->price  . "</td>";
                        echo "<td> Book des =" . $book->description  . "</td>";
                    }
                    echo "<td> Author =" . $rs->first_name . " " . $rs->last_name
                        . " (" . $rs->email . ")" . "</td>";
                    echo "</tr>";
                }
            }
        }

        $_SESSION['phrase'] = $builder->getPhrase();

        ?>
</form>
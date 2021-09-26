<?php
require "../bootstrap.php";

use CT275\Lab4\Book;


if (isset($_REQUEST['upkey'])) {
    $key = $_REQUEST['upkey'];
    $temp = Book::where('id', '=', $key)->get();
  
    if (isset($_POST['title']) && isset($_POST['pages_count']) && isset($_POST['price']) && isset($_POST['description'])) {
        $search = Book::where('id', '=', $key)->update(['title' => $_POST['title'],'pages_count' => $_POST['pages_count'],
                                                        'price' => $_POST['price'],'description' => $_POST['description']]);


        header('location: ./books.php');
    }
    
}

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
<h2>Update book</h2>
<?php
foreach ($temp as $rs) {
?>
<form method="POST">
    <label>Title:</label> <input type="text" name="title" value= "<?php echo $rs->title?>" /> <br><br>
    <label>Num of Pages:</label> <input type="text" name="pages_count" value= "<?php echo $rs->pages_count?>" /> <br><br>
    <label>price:</label> <input type="text" name="price" value= "<?php echo $rs->price?>" /> <br><br>
    <label>Description:</label> <input type="text" name="description" value= "<?php echo $rs->description?>" /> <br><br>


    <input type="submit" name="submit" value="Save" />
</form>
<?php }?>
<?php

$id = $_GET['id'];

$book = R::load( 'books' . $year, $id );

?>



<form action="/" method="POST">

    <p>
        <strong>Title</strong></br>
        <input type="text" name="title" value="<?php echo $book['title']; ?>" required />
    </p>

    <p>
        <strong>Author</strong></br>
        <input type="text" name="author" value="<?php echo $book['author']; ?>" required />
    </p>

    <p>
        <strong>Total</strong></br>
        <input type="number" name="total" value="<?php echo $book['total']; ?>" required />
    </p>

    <p>
        <strong>Read</strong></br>
        <input type="number" name="read" value="<?php echo $book['read']; ?>" required autofocus />
    </p>

    <input type="hidden" name="id" value="<?php echo $book['id']; ?>" />

    <p>
        <button type="submit" name="edit">Edit</button>
    </p>

</form>

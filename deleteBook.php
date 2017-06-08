<?php

$book = R::load( 'books'.$year, $id );
R::trash($book);
header("Location: ".$_SERVER['HTTP_REFERER']);
exit();
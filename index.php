<?php
session_start();

if (isset($_POST['changeYear']))
    $_SESSION['year'] = $_POST['changeYear'];

define("CURRENT_YEAR", date('Y'));
if ($_SESSION['year'])
    $year = $_SESSION['year'];
else
    $year = CURRENT_YEAR;


require_once('rb.php');
require_once('functions.php');
R::setup( 'mysql:host=localhost;dbname=books', 'root', '' );
$book = R::dispense( 'books' . $year  );

if ( isset($_POST['submit']) ) { // if added book
    addBook($_POST, $book);
}

if ( isset($_GET['delete']) ) { // if delete book
    deleteBook($_GET['id'], $year);
}

if ( isset($_POST['edit']) ) { // if edit book
    $data = $_POST;
    //echo 'edit';
    $book = R::load( 'books'.$year, $_POST['id']);
    $book->title = $data['title'];
    $book->author = $data['author'];
    $book->read = $data['read'];
    $book->total = $data['total'];
    if ($data['read']/$data['total'] === 1) {
        $book->finish = 1;
        $date = getdate();
        $var = $date['year'] . '-' . $date['mon'] . '-' . $date['mday'] . '<br />';
        $book->date = $var;
    }
    R::store( $book );
}

//echo session_save_path();
//echo session_id();
//echo session_cache_expire();




if ( isset($_POST['year']) ) {
    //echo 'hi';
    createYear($_POST['year']);
}


?><link rel="stylesheet" href="style.css">
    <title>My Books</title>
<a href="/?create=year">Create year</a>
<?php


if ( isset($_GET['create']) && $_GET['create'] == 'year'){
    require_once('addYearForm.php');
} else {
    if (isset($_GET['form'])) {
        require('edit.php');
    } else {
        require('form.php');
    }
}



require('list.php');


printSelectYear(getAllYears(), $year); // вывод выбора всех годов
echo '<div>';

echo getAveragePages(getRemainPages($year), getRemainDays());

echo getPercentDo($year);

echo '</div>';
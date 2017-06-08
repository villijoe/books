<?php

function getAllYears(){
    $listTables = R::inspect();
    foreach ($listTables as $table) {
        $year = str_replace('books', '', $table);
        $listYears[] = $year;
    }
    return $listYears;
}

function printSelectYear($listYears, $year){
    echo '<form id="changeYear" method=post action="/">';
    echo '<select name="changeYear" onchange="this.form.submit()">';
    for($i = 0; $i < count($listYears); $i++){
        if ($year == $listYears[$i])
            $selected = ' selected';
        else
            $selected = '';
        echo '<option' . $selected . '>';
        echo $listYears[$i];
        echo '</option>';
    }
    echo '</select>';
    echo '</form>';
}

function getRemainPages($year) {
    $arr = R::getAll( 'SELECT `total` FROM books' . $year . ' WHERE finish=0' );
    $started = R::getAll( 'SELECT `read` FROM books' . $year . ' WHERE finish=0 AND `read` > 0' );

    $sum = 0;

    foreach($arr as $num) {
        $sum += $num['total'];
    }

    $read = 0;

    foreach($started as $start) {
        $read += $start['read'];
    }

    return $sum-$read;
}

function getRemainDays() {
    $date = getdate();
    return 366-$date['yday']; // количество дней до конца года
}

function getAveragePages($remainPages, $remainDays) {
    return $remainPages . '(pages) / ' . $remainDays . '(days) = ' . round($remainPages / $remainDays, 2);
}

function getPercentDo($year) {
    $arr = R::getAll( 'SELECT `read`, `total` FROM books' . $year );

    $read = 0;
    $total = 0;

    foreach($arr as $item) {
        $read += $item['read'];
        $total += $item['total'];
    }

    if ($total == 0) {
        return '<br /> Нет книг в списке.';
    } else {
        return '<br />' . $read . '(read) / ' . $total . '(total) = ' . round($read / $total, 4) * 100 . ' %';
    }
}

function createYear($year){
    $table = R::dispense('books' . $year);
    R::store($table);
}

function addBook($data, $book) {
    $book->title = $data['title'];
    $book->author = $data['author'];
    $book->read = $data['read'];
    $book->total = $data['total'];
    if ($data['read']/$data['total'] === 1) {
        $book->finish = 1;
    } else
        $book->finish = 0;
    $book->date = '0000-00-00';
    R::store( $book );
}

function deleteBook($id, $year) {
    $book = R::load( 'books'.$year, $id );
    R::trash($book);
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit();
}
<?php

$rows = R::getAll( 'SElECT * FROM books' . $year . ' ORDER BY `date`' );

echo '<div id="list">';

$i = 0;

foreach( $rows as $row ) {

    $i++;

    $style = $row['finish'] ? 'color:red;text-decoration:line-through' : 'color:green;';

    echo '<strong style="', $style, '">', $i, '. ', $row['title'], '. ', $row['author'], '. ', $row['read'], '/', $row['total'],
            '<a href="/?form=edit&id=', $row['id'], '">Edit</a><a href="/?delete=book&id=' , $row['id'], '">X</a></strong><br />';
}

echo '</div>';
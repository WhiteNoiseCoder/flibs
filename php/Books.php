<?php
include './DbFunctions.php';

class Books extends DbFunction{

function get_books($string){
        $query = "SELECT BookId, Title FROM libbook WHERE Title LIKE '%{$string}%' LIMIT 2;";
        return $this->query_to_json($query);
}
}


if (strcmp("{$argv[1]}", "get_books") == 0){
        $books = new Books();
        $books->get_books($argv[2]);
}

?>
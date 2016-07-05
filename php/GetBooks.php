<?php
include './DbFunctions.php';

class Books extends DbFunction{

function get_books($string){
        $query = "SELECT BookId, Title, AvtorId, FirstName, MiddleName, LastName 
        	    FROM libbook 
        	    JOIN libavtor USING(BookId) 
        	    JOIN libavtorname USING(AvtorId) 
        	    WHERE Title LIKE '%{$string}%' AND Deleted = 0 LIMIT 100;";
        return $this->query_to_json($query);
}
}

$books = new Books();
if (strcmp("{$argv[1]}", "get_books") == 0){
        echo $books->get_books($argv[2]);
}

echo ($books->get_books($_GET['t']));

?>
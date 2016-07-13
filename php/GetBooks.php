<?php
include './DbFunctions.php';

class Books extends DbFunction{

function get_books($string){
        $query = "SELECT BookId, Title, AvtorId, FirstName, MiddleName, LastName 
        	    FROM libbook 
        	    JOIN libavtor USING(BookId) 
        	    JOIN libavtorname USING(AvtorId) 
        	    WHERE (Title LIKE '%{$string}%' OR LastName LIKE '%{$string}%')
        		AND Deleted = 0
		    LIMIT 200
		    ;";
        	    //GROUP BY LastName
		    //ORDER BY LastName
        	    //ORDER BY CASE WHEN LEFT(MiddleName, 1) = 'mb_substr($string, 0, 1)' THEN 1 ELSE 2 END, Title
        	    //WHERE Title LIKE '%{$string}%' OR FirstName LIKE '%{$string}%' OR LastName LIKE '%{$string}%' OR MiddleName LIKE '%{$string}%' 
        return $this->query_to_json($query);
}
}

$books = new Books();
if (strcmp("{$argv[1]}", "get_books") == 0){
        echo $books->get_books($argv[2]);
}

echo ($books->get_books($_GET['t']));

?>
<?php
include './DbFunctions.php';

class Books extends DbFunction{

function get_books($string){
        $query = "	SELECT BookId, Title, AvtorId, FirstName, MiddleName, LastName, SUM(MatchTitle), SUM(MatchLastName), SUM(MatchTitle) + SUM(MatchLastName)
			FROM (
			    SELECT BookId, Title, AvtorId, FirstName, MiddleName, LastName, 
				MATCH (Title) AGAINST ('{$string}') as MatchTitle, 0 AS MatchLastName
			    FROM libbook 
				JOIN libavtor USING(BookId)
				JOIN libavtorname USING(AvtorId)
			    WHERE MATCH (Title) AGAINST ('{$string}*' IN BOOLEAN MODE)

		            UNION

			    SELECT BookId, Title, AvtorId, FirstName, MiddleName, LastName,
				0 AS MatchTitle, MATCH (LastName) AGAINST ('{$string}') as MatchLastName
			    FROM libbook 
				JOIN libavtor USING(BookId)
				JOIN libavtorname USING(AvtorId)
			    WHERE MATCH (LastName) AGAINST ('{$string}*' IN BOOLEAN MODE)
			) AS books
			GROUP BY BookId, Title, AvtorId, FirstName, MiddleName, LastName
			ORDER BY SUM(MatchTitle) + SUM(MatchLastName) DESC, LastName, Title
			LIMIT 200;";
        return $this->query_to_json($query);
}
}

$books = new Books();
if (strcmp("{$argv[1]}", "get_books") == 0){
        echo $books->get_books($argv[2]);
}

echo ($books->get_books($_GET['t']));

?>
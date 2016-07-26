<?php
include './DbFunctions.php';

class Books extends DbFunction{

function get_books($string){
        $query = "	SELECT BookId, Title, AvtorId, FirstName, MiddleName, LastName, 
    			    SUM(MatchTitle), SUM(MatchLastName), SUM(MatchFirstName), SUM(MatchMiddleName),
    			    SUM(MatchTitle) + SUM(MatchLastName) + SUM(MatchFirstName) + SUM(MatchMiddleName)
			FROM (
			    SELECT BookId, Title, AvtorId, FirstName, MiddleName, LastName, 
				MATCH (Title) AGAINST ('{$string}') as MatchTitle, 0 AS MatchLastName, 0 AS MatchMiddleName, 0 AS MatchFirstName
			    FROM libbook 
				JOIN libavtor USING(BookId)
				JOIN libavtorname USING(AvtorId)
			    WHERE (MATCH (Title) AGAINST ('{$string}*' IN BOOLEAN MODE))
				AND Deleted = 0

		            UNION

			    SELECT BookId, Title, AvtorId, FirstName, MiddleName, LastName,
				0 AS MatchTitle, 
				MATCH (LastName) AGAINST ('{$string}') as MatchLastName,
				MATCH (FirstName) AGAINST ('{$string}') as MatchFirstName,
				MATCH (MiddleName) AGAINST ('{$string}') as MatchMiddleName
			    FROM libbook 
				JOIN libavtor USING(BookId)
				JOIN libavtorname USING(AvtorId)
			    WHERE MATCH (LastName) AGAINST ('{$string}*' IN BOOLEAN MODE) 
				AND (Lang = 'ru' AND FileType = 'fb2')

			) AS books
			GROUP BY BookId, Title, AvtorId, FirstName, MiddleName, LastName
			ORDER BY SUM(MatchTitle) + SUM(MatchLastName) + SUM(MatchFirstName) + SUM(MatchMiddleName) DESC, LastName, Title
			LIMIT 200;";
        return $this->query_to_json($query);
}
}

$books = new Books();
if (strcmp("{$argv[1]}", "get_books") == 0){
        echo $books->get_books($argv[2]);
}

echo ($books->get_books($_GET['t']));

/*
		            UNION

			    SELECT BookId, Title, AvtorId, FirstName, MiddleName, LastName,
				0 AS MatchTitle, MATCH (FirstName) AGAINST ('{$string}') as MatchFirstName
			    FROM libbook 
				JOIN libavtor USING(BookId)
				JOIN libavtorname USING(AvtorId)
			    WHERE MATCH (FirstName) AGAINST ('{$string}*' IN BOOLEAN MODE) 
				AND (Lang = 'ru' AND FileType = 'fb2')

		            UNION

			    SELECT BookId, Title, AvtorId, FirstName, MiddleName, LastName,
				0 AS MatchTitle, MATCH (MiddleName) AGAINST ('{$string}') as MatchMiddleName
			    FROM libbook 
				JOIN libavtor USING(BookId)
				JOIN libavtorname USING(AvtorId)
			    WHERE MATCH (MiddleName) AGAINST ('{$string}*' IN BOOLEAN MODE) 
				AND (Lang = 'ru' AND FileType = 'fb2')

*/
?>

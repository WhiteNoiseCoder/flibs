<?php
require ("configuration.php");

class DbFunction {


function query_to_json($query){
        $username = DB_USER;
        $password = DB_PASSWORD;
        $my_db = DB_DATABASE;
        $my_db_host = DB_HOST;

	try {
            $dbh = new PDO("mysql:host={$my_db_host};dbname={$my_db};charset=utf8", $username, $password);
	    $myarray = array();
            foreach($dbh->query($query) as $row) {
                $myarray[] = $row;
    	    }
    	    $dbh = null;
	
	} catch (PDOException $e) {
	    print "Error!: " . $e->getMessage() . "<br/>";
	    die();
	}
        
        return json_encode($myarray);
}

}

?>
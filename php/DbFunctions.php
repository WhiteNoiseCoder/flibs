<?php
require ("configuration.php");

class DbFunction {

        function __construct(){
                $this->connect();
        }

function connect() {
        $username = DB_USER;
        $password = DB_PASSWORD;
        $my_db = DB_DATABASE;
        $my_db_host = DB_HOST;

                //connection to the database
        $this->dbconn = mysql_connect($my_db_host, $username, $password)
        or die("Unable to connect to MySQL");
	mysql_select_db($my_db)
        or die("Unable to connect to database: " . mysql_error());
}

function my_query($query){
        $this->connect();
        $result = mysql_query($this->dbconn, "$query");

        if (!$result) {
                        //error_log("Произошла ошибка.\n");
                error_log(pg_last_error($this->dbconn));
                $this->echo_error();
                        //exit;
        }
        
        return $result;
}

function query_to_json($query){
        $result = $this->my_query($query);
        $myarray = array();

        while ($row = pg_fetch_row($result)) {
                $myarray[] = $row;
        }
        
        $json = json_encode($myarray);
        return $json;
}

}

?>
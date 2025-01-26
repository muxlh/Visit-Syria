<?php
class connect{
    private static PDO $connection;
    private static $servername="localhost";
    private static $dbname="visit_syria";
    private static $username="root";
    private static $password="";

    public static function setConnection() {
        $dsn="mysql:host=".self::$servername.";dbname=".self::$dbname.";charset=UTF8";
        self::$connection= new PDO($dsn,self::$username,self::$password);
	} 

    public static function getConnection() {
		return self::$connection;
	}
}
?>

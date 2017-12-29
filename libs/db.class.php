<?php
/*
 * VS_db class
 * This class gives a static instance of the connection to a DB, all mysql transactions should happen via this class
 * @author :SANDEEP/Veera
 * 
 * @lock:THIS CLASS SHOULD NOT BE MODIFIED
 */
class VS_db{

	private $connection; // variable used to store the connetion details
	private $result; //variable used to store the executed query
	private $count; //variable used to store the number of rows in a table
	private $numfields;//variable used to store the number of fields in the table
	private $array;//variable used to store the table record as an array
	private $logger;
	private static $instance = NULL;

	/**
	*
	* the constructor is set to private so
	* so nobody can create a new instance using new
	*
	*/
	public function __construct()
	{
		$this->connection = $this->getInstance();
	}



        public function getInstance()
	{
            if (!self::$instance)
            {
                
                self::$instance = mysqli_connect(__VS_SERVER_PATH, __VS_DB_USER, __VS_DB_PSWD,__VS_DB_NAME);
                //mysql_select_db(__VS_DB_NAME,self::$instance) OR die("Cannot select database!");
            }
            return self::$instance;
	}

	/*
	 * query();
	 * Method to perform query with the MySql DB.
	 * It stores the result  in a private variable,
	 * @param none
	 * @return the query database
	 * @return false on database not found
	 */
	public function query($querystr) {
            $result = mysqli_query($this->getInstance(),$querystr);
            //print_r($result);
            return $result;
	}
}
?>
<?php




    class DatabaseLogin
    {


  	/**
     * @var object  database tengingin.
     */
    private $db_connection = null;
    

    	/*session_destroy();

   		public function __construct()
    	{
        // störtum session
    	    session_start();
   	 	}*/

   	 function getDbConnection()
   	 {
   	 	require_once("../config/db.php");
   	 	 return $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE,DB_PORT);
   	 }
	}
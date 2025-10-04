<?php
    /**
     * Class to manage the connection and the requests with the database 
     */
    class Database
    {
        protected $connection = null;

        /**
         * Construct
         */
        public function __construct()
        {
            try 
            {
                $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
            
                if (mysqli_connect_errno()) 
                {
                    throw new Exception("Could not connect to database.");   
                }
            } 
            catch (Exception $e) 
            {
                throw $e;   
            }			
        }

        /**
         * Gets the connection
         */
        public function getConnection()
        {
            return $this->connection;
        }

        /**
         * Execute a query
         * @param query
         */
        public function insert($query)
        {
            try 
            {
                if($this->connection->query($query) === FALSE) 
                {
                    throw new Exception("Error to execute the query");
                }
            } 
            catch(Exception $e) 
            {
                throw $e;
            }
        }
    }
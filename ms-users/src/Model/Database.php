<?php
    /**
     * Class to manage the connection and the requests with the database 
     */
    class Database
    {
        protected $connection = null;

        /**
         * Contruct
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
         * Creates the connection
         */
        public function getConnection()
        {
            return $this->connection;
        }

        /**
         * Executes a query
         * @param query
         */
        public function executeStatement($query)
        {
            try 
            {
                if(!$stmt = $this->connection->prepare($query))
                {
                    throw new Exception("Error to execure query");
                };

                $stmt->execute();
                $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);				
                $stmt->close();
                return $result;
            } 
            catch(Exception $e) 
            {
                throw $e;
            }
        }
    }
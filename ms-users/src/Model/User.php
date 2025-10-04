<?php
    require_once PROJECT_ROOT_PATH . "/src/Model/Database.php";

    /**
     * Class to manage users
     */
    class User
    {
        private $log = null;
        private $db = null;

        /**
         * Constructor
         */
        public function __construct()
        {
            $this->log = new Log();
            $this->db = new Database();
        }

        /**
         * Get user by id
         * @param id
         */
        public function getUser($id)
        {
            try 
            {
                $this->log->save("Searching user width id: ".$id);

                $user = $this->db->executeStatement("SELECT * FROM users WHERE id=$id");

                if(empty($user))
                {
                     $this->log->save("No user found with id: ".$id);
                     return [];
                }
                else
                {
                    $this->log->save("User found with id: ".$id);
                    $this->log->save(implode(",",$user[0]));
                    return $user[0];
                }
            } 
            catch(Exception $e) 
            {
                $this->log->save("Error to get user with id: ".$id);
                $this->log->save($e->getMessage());
                throw $e;
            }
        }

        /**
         * Ge all users
         */
        public function getUsers()
        {
            try 
            {
                $this->log->save("Searching all users");

                $users = $this->db->executeStatement("SELECT * FROM users ORDER BY id ASC");

                $this->log->save("Found ".count($users)." users");

                return $users;
            } 
            catch(Exception $e)
            {
                throw $e;
            }
        }

        /**
         * Creates and load a table with the users
         */
        public function createTable()
        {
            $this->log->save("Creating a table and inserting users");

            $dsn = "mysql:host=".DB_HOST.";dbname=".DB_DATABASE_NAME.";charset=utf8mb4";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try
            {
                $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
                $sql_file = PROJECT_ROOT_PATH . '/sql/schema.sql';
                $sql_script = file_get_contents($sql_file);
                $pdo->exec($sql_script);
                
                $users = $this->db->executeStatement("SELECT * FROM users");

                $this->log->save("Database created with ".count($users)." users successfully");
            } 
            catch (Exception $e) 
            {
                throw $e->getMessage();
            }
        }
    }
?>
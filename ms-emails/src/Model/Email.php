<?php
    require_once PROJECT_ROOT_PATH . "/src/Model/Database.php";

    /**
     * Class to manage users
     */
    class Email
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
         * Saves the enmail in DB
         * @param email
         */
        public function save($email)
        {
            try
            {
                $this->log->save("Saving user email: " . $email);
                $this->db->insert("INSERT INTO emails (email) VALUES ('".$email."')");
                $this->log->save("Email saved!");
            }
            catch(Exception $e)
            {
                $this->log->save("Error save email: " . $email);
                throw $e;
            }
        }

        /**
         * Creates a emails table
         */
        public function createTable()
        {
            $this->log->save("Creating the email table");

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

                $this->log->save("Email table created successfully");
            } 
            catch (Exception $e) 
            {
                throw $e->getMessage();
            }
        }
    }
?>
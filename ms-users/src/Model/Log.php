<?php
    /**
     * Class to manage the logs
     */
    class Log
    {
        private $file = "/log/logs.log";

        /**
         * Saves a new log
         */
        public function save($text)
        {
            $log = date("Y-m-d H:i:s") . " " . $text . PHP_EOL;
            file_put_contents(PROJECT_ROOT_PATH . $this->file, $log, FILE_APPEND);
        }

        /**
         * Reset all logs
         */
        public function reset()
        {
            file_put_contents(PROJECT_ROOT_PATH . $this->file, "");
            $this->save("Deleting logs in users microservice");
            $this->save("Logs deleted");
        }
    }

?>
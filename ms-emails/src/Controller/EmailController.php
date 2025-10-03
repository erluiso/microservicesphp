<?php
    header("Access-Control-Allow-Origin: *"); // Allow CORS (if required)
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require PROJECT_ROOT_PATH . '/config/db.php';
    require PROJECT_ROOT_PATH . '/src/Model/Email.php';
    require PROJECT_ROOT_PATH . '/src/Model/Log.php';

    $method = $_SERVER['REQUEST_METHOD'];

    $log = new Log();

    // Basic routing
    if ($uri[1] === 'emails') 
    {
        // We create UserModel instance
        $email = new Email();

        switch ($method) 
        {
            case 'GET':

                $log->save("A $method request has been received: ".$url);

                if(isset($uri[2]) && trim($uri[2]) != "") 
                {
                    //Load table
                    if($uri[2] === "createTable")
                    {  
                        $email->createTable();
                        echo "Email table created successfully!";
                    }
                    else
                    {
                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, 'user-service:80/users/'.$uri[2]);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

                        if(curl_exec($ch) === false) 
                        {
                            echo 'Curl error: ' . curl_error($ch);
                            exit;
                        } 
                        else 
                        {
                            $response = curl_exec($ch);

                            curl_close($ch);

                            $userEmail = json_decode($response,true);
                            $userEmail = $userEmail[0]["email"];

                            if($email->save($userEmail))
                            {
                                //Here we can call to a function to send emails
                                $log->save("Emails sended to ".$userEmail);

                                echo "ok";
                            }
                            else
                            {
                                echo "ko";
                            };
                        }
                    }
                }

            break;
        }
    } 
    else if($uri[1] === 'resetLogs')
    {
        switch ($method) 
        {
            case 'GET':

                $log->reset();

            break;
        }
    }
    else
    {
        http_response_code(404);
        $log->save("Route not found");
        echo ("Route not found");
    }
?>
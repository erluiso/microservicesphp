<?php
    require PROJECT_ROOT_PATH . '/config/db.php';
    require PROJECT_ROOT_PATH . '/src/Model/User.php';
    require PROJECT_ROOT_PATH . '/src/Model/Log.php';

    $method = $_SERVER['REQUEST_METHOD'];

    $log = new Log();

    // Basic routing
    if ($uri[1] === 'users') 
    {
        // We create UserModel instance
        $user = new User();

        switch ($method) 
        {
            case 'GET':

                $log->save("A $method request has been received: ".$url);

                if(isset($uri[2]) && trim($uri[2]) != "") 
                {
                    //Load table
                    if($uri[2] === "createTable")
                    {  
                        $user->createTable();
                        echo "Table and users created successfully!";
                    }
                    else
                    {
                        //Search user by id
                        echo json_encode($user->getUser($uri[2]));
                    }
                }
                else
                {
                    //Get all users
                    echo json_encode($user->getUsers());
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
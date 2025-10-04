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
        $userModel = new User();

        switch ($method) 
        {
            case 'GET':

                $log->save("A $method request has been received: ".$url);

                if(isset($uri[2]) && trim($uri[2]) != "") 
                {
                    //Load table
                    if($uri[2] === "createTable")
                    {  
                        try
                        {
                            $userModel->createTable();
                            echo json_encode(
                                [
                                    "error" => ["code" => 0,"message" => ""],
                                    "message" => "Table and users created successfully!"
                                ]
                            );
                        }
                        catch(Exception $e)
                        {
                            echo json_encode(
                                [
                                    "error" => ["code" => 1,"message" => $e->getMessage()],
                                    "message" => ""
                                ]
                            );
                        }
                    }
                    else
                    {
                        //Search user by id
                        try
                        {
                            $user = $userModel->getUser($uri[2]);
                            echo json_encode(
                                [
                                    "error" => ["code" => 0,"message" => ""],
                                    "user" => $user
                                ]
                            );
                        }
                        catch(Exception $e)
                        {
                            echo json_encode(
                                [
                                    "error" => ["code" => 1,"message" => $e->getMessage()],
                                    "user" => []
                                ]
                            );
                        }
                    }
                }
                else
                {
                    //Get all users
                    try
                    {
                        $users = $userModel->getUsers();
                        echo json_encode(
                            [
                                "error" => ["code" => 0,"message" => ""],
                                "users" => $users
                            ]
                        );
                    }
                    catch(Exception $e)
                    {
                        echo json_encode(
                            [
                                "error" => ["code" => 1,"message" => $e->getMessage()],
                                "users" => []
                            ]
                        );
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
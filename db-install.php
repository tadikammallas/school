<?php 
    ##################################################
    # author: sandeep/veera
    # initialisation file for database
    # DO NOT CHANGE THIS FILE
    ##################################################
    define('DS', DIRECTORY_SEPARATOR);
    define("__BASE_PATH",dirname(__FILE__).DS);
    
    define('__VS_APPS_PATH',__BASE_PATH . 'apps' .DS);
    define('__VS_LIBS_PATH',__BASE_PATH . 'libs' .DS);
    
    include_once('tools/print.php');
    include_once(__VS_LIBS_PATH.'config.php');
    include_once(__VS_LIBS_PATH.'utils.php');
    include_once(__VS_LIBS_PATH.'VS-baseController.php');
    
    
    /**
     * creating database
     */
    $conn = mysqli_connect(__VS_SERVER_PATH, __VS_DB_USER, __VS_DB_PSWD);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    // Create database
    $sql = "CREATE DATABASE ".__VS_DB_NAME;
    if (mysqli_query($conn, $sql)) {
        printMsg("Database created successfully") ;
    } else {
        printMsg("Error creating database: " . mysqli_error($conn)) ;
    }
    
    /* 
    * to create all default tables
    */

    $dir = __VS_APPS_PATH;
    $files1 = scandir($dir);
    $classArr = [];
    for($i=0;$i<count($files1);$i++){
        if($files1[$i] != '.' && $files1[$i] != '..'){
            echo 'including file'.__VS_APPS_PATH.DS.$files1[$i].'<br /> ';
            include_once (__VS_APPS_PATH.DS.$files1[$i]);
            $name = explode('.', $files1[$i]);

            $nameCount = count($name);
            if($nameCount >= 2){
                array_push($classArr, $name[$nameCount - 2]);
            }
        }

    }

    echo '<br /> <br /> <br /> ';
    for($j=0;$j<count($classArr);$j++){
        $class = 'VS_'.$classArr[$j];
        $action = 'VS_create'; 
        echo $classArr[$j] .' table created successfulley <br /> ';
        $controller = new $class();
        $controller->$action();
    }

    mysqli_close($conn);
    
    echo '<br /> <br /> <br /> ## DB INITIALISED SUCCESSFULLY##'
    
?>
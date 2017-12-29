<?php

/**
 * user class
 * author sandeep/veera
 */

class VS_user extends VS_baseController{
    public $DBO;
    public function __construct(){
        $this->DBO = new VS_db();
    }
    
    /**
     * create
     * 
     * Hook for the create call, to be called only during installation
     * {uId} - unique id for every user
     * {status} - status of the user whether they are active, inactive or deleted 
     * {onlineStatus} - online status of the user, to know whether they logged in or not
     * {loginTime} - login time of the user
     * {name} - name of the user
     * {emailId} - gives emailid 
     * {password} - gives password of the user account
     * {creationDate} - gives the date of creation of the user
     * @args - none
     */	
    public function VS_create()
    {
        $create=$this->DBO->query("CREATE TABLE IF NOT EXISTS `users` (
                                                                                  `uId` int(11) NOT NULL AUTO_INCREMENT,
                                                                                  `emailId` varchar(1024) DEFAULT NULL,
                                                                                  `password` varchar(1024) DEFAULT NULL, 
                                                                                  `userName` varchar(1024) DEFAULT NULL,
                                                                                  `onlineStatus` smallint(2) DEFAULT 0,
                                                                                  `status` smallint(2) DEFAULT 0,
                                                                                   PRIMARY KEY (`uId`)
                                                                        ) ");
        $query=$this->DBO->query("CREATE TABLE IF NOT EXISTS `roles` (
                                                                        `roleId` int(10) NOT NULL AUTO_INCREMENT,
                                                                        `roleName` varchar(25) NOT NULL UNIQUE,
                                                                       `creationDate` int(11) DEFAULT NULL,
                                                                       `modifiedDate` int(11) DEFAULT NULL,
                                                                        `data` varchar(5048) DEFAULT NULL,
                                                                        PRIMARY KEY (`roleId`)
                                                                      ) ");

        $create=$this->DBO->query("CREATE TABLE IF NOT EXISTS `userProfile` (
                                                                                  `uId` int(11),
                                                                                  `firstName` TEXT  DEFAULT NULL,
                                                                                  `lastName` TEXT  DEFAULT NULL, 
                                                                                  `DOB` TEXT  DEFAULT NULL,
                                                                                  `basicDegree` TEXT  DEFAULT NULL,
                                                                                  `tagLine` TEXT  DEFAULT NULL,
                                                                                  `currentCountry` TEXT  DEFAULT NULL,
                                                                                  `homeCountry` TEXT  DEFAULT NULL,
                                                                                  `currentState` TEXT  DEFAULT NULL,
                                                                                  `homeState` TEXT  DEFAULT NULL,
                                                                                  `currentTown` TEXT  DEFAULT NULL,
                                                                                  `homeTown` TEXT  DEFAULT NULL,
                                                                                  `motherTongue` TEXT  DEFAULT NULL,
                                                                                  `marritalStatus` TEXT  DEFAULT NULL,
                                                                                  `anniversday` TEXT  DEFAULT NULL,
                                                                                  `sex` TEXT  DEFAULT NULL,
                                                                                  `religion` TEXT  DEFAULT NULL,
                                                                                  `picture` TEXT  DEFAULT NULL,
                                                                                  `mobile` TEXT  DEFAULT NULL,
                                                                                  `landLine` TEXT  DEFAULT NULL,
                                                                                  `favorateBook` TEXT  DEFAULT NULL,
                                                                                  `favorateMovie` TEXT  DEFAULT NULL,
                                                                                  `favorateMusic` TEXT  DEFAULT NULL,
                                                                                  `favorateSport` TEXT  DEFAULT NULL,
                                                                                  `about` TEXT  DEFAULT NULL,
                                                                                  `marriedWith` TEXT  DEFAULT NULL
                                                                        ) ");
        $createTime=time();
        $this->DBO->query("INSERT INTO `roles`(`roleName`,`creationDate`,`modifiedDate`) VALUES ('administrator','$createTime','$createTime') ");
        $this->DBO->query("INSERT INTO `roles`(`roleName`,`creationDate`,`modifiedDate`) VALUES ('management','$createTime','$createTime') ");
        $this->DBO->query("INSERT INTO `roles`(`roleName`,`creationDate`,`modifiedDate`) VALUES ('principal','$createTime','$createTime') ");
        $this->DBO->query("INSERT INTO `roles`(`roleName`,`creationDate`,`modifiedDate`) VALUES ('parent','$createTime','$createTime') ");
        $this->DBO->query("INSERT INTO `roles`(`roleName`,`creationDate`,`modifiedDate`) VALUES ('teacher','$createTime','$createTime') ");
        $this->DBO->query("INSERT INTO `roles`(`roleName`,`creationDate`,`modifiedDate`) VALUES ('student','$createTime','$createTime') ");
        
        $query=$this->DBO->query("CREATE TABLE IF NOT EXISTS `userRole` (
												  `uRoleId` int(10) NOT NULL AUTO_INCREMENT,
												  `uId` int(10) NOT NULL,
												  `roleId` int(10) NOT NULL,
												  PRIMARY KEY (`uRoleId`),
												  FOREIGN KEY (`roleId`) REFERENCES roles(`roleId`),
												   INDEX(`uId`)
										) ");
                                                                                
        $this->createAdmin();
        
        
    }
    
    function createAdmin(){
        $this->DBO->query("INSERT INTO `userRole` (`uId`,`roleId`) VALUES (1,1)");

        $defaultImg = DEFAULTIMG;


        $password=htpass('test1234');

        if (!file_exists(DATAPATH.'1/profile'.DS))
        {
			$command = 'mkdir -p ' . DATAPATH.'1/profile'.DS;
			$output = `$command`;
        }
        $q1 = $this->DBO->query("INSERT INTO `users` (`status`,`userName`,`emailId`,`password`) VALUES ('1','admin','admin@test.com','$password')");

        $q2 = $this->DBO->query("INSERT INTO `userProfile` (`uId`,`picture`) VALUES ('1','$defaultImg)')");
        echo '</br>admin created successfully</br';
    }
    
    public function VS_add(){
        extract($_POST);
        $this->DBO->query("INSERT INTO `users`(`emailId`,`password`,`userName`) VALUES ('$email','$password','$userName') ");
        $this->ajaxResponse('',$email.'inserted');	
    }
    
    public function VS_register(){
        extract($_POST);
    }
    
    public function VS_login(){
        extract($_POST);
        $queryStr = '';
        if($emailId){
            $queryStr .= "emailId = '".$emailId."'";
        }
        else if($userName){
            $queryStr .= "emailId = '".$userName."'";
        }
        if($password){
            $pswd = htpass($password);
            $queryStr .= "and password = '".$pswd."'";
        }
        //echo "SELECT uId FROM `users` where ".$queryStr;
        $result= $this->DBO->query("SELECT * FROM `users` where ".$queryStr);
       $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
       $this->ajaxResponse($data);
    }
    
    public function VS_getUser(){
       $result= $this->DBO->query("SELECT * FROM `users` ");
       $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
       $this->ajaxResponse($data);
    }
    
    public function VS_uploadFile(){
        $target_dir = __BASE_PATH."uploads".DS;
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
//        // Check file size
//        if ($_FILES["fileToUpload"]["size"] > 500000) {
//            echo "Sorry, your file is too large.";
//            $uploadOk = 0;
//        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

}

?>
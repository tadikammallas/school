<?php

/**
 * subject grade
 * author sandeep/veera
 */

class VS_grade extends VS_baseController{
    public $DBO;
    public function __construct(){
        $this->DBO = new VS_db();
    }
    
    /**
     * create
     * 
     */	
    public function VS_create()
    {
        $create=$this->DBO->query("CREATE TABLE IF NOT EXISTS `grade` (
                                                                            `gradeId` int(11) NOT NULL AUTO_INCREMENT,
                                                                            `gradeName` int(11) DEFAULT 0,
                                                                            `time` int(11) DEFAULT 0,
                                                                            `status` smallint(2) DEFAULT 0,
                                                                             PRIMARY KEY (`gradeId`)
                                                                        ) ");
        
        $create=$this->DBO->query("CREATE TABLE IF NOT EXISTS `userGrade` (
                                                                            `id` int(11) NOT NULL AUTO_INCREMENT,
                                                                            `gradeId` int(10),
                                                                            `uId` int(11) DEFAULT 0,
                                                                            `time` int(11) DEFAULT 0,
                                                                            `status` smallint(2) DEFAULT 0,
                                                                             PRIMARY KEY (`id`)
                                                                        ) ");
    }
    
    public function VS_add(){
        extract($_POST);
        $this->DBO->query("INSERT INTO `grade`(`gradeName`,`status`) VALUES ('$gradeName','$status') ");
        $this->ajaxResponse('',$gradeName.'@'.$status.'inserted');	
    }
    
    public function VS_addUserGrade(){
        extract($_POST);
        $time = time();
        $this->DBO->query("INSERT INTO `userGrade`(`gradeId`,`uId`,`time`) VALUES ('$gradeId','$uId','$time') ");
        $this->ajaxResponse('',$gradeId.'@'.$uId.'inserted');	
    }
    
    
    public function VS_removeGrade(){
        extract($_POST);
        $this->DBO->query("DELETE FROM `grade` where gradeName = '$gradeName' ");
        $this->ajaxResponse('',$gradeName.'deleted');	
    }
    
    
    
}

?>
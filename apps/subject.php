<?php

/**
 * subject class
 * author sandeep/veera
 */

class VS_subject extends VS_baseController{
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
        $create=$this->DBO->query("CREATE TABLE IF NOT EXISTS `subjects` (
                                                                            `subId` int(10) NOT NULL AUTO_INCREMENT,
                                                                            `subName` varchar(1024) DEFAULT NULL, 
                                                                            `standard` varchar(1024) DEFAULT NULL,
                                                                            `status` smallint(2) DEFAULT 0,
                                                                             PRIMARY KEY (`subId`)
                                                                        ) ");
    }
    
    public function VS_add(){
        extract($_POST);
        $this->DBO->query("INSERT INTO `subjects`(`subName`,`standard`) VALUES ('$subName','$standard') ");
        $this->ajaxResponse('',$subName.'@'.$standard.'inserted');	
    }
    
    public function VS_remove(){
        extract($_POST);
        $result = $this->DBO->query("DELETE FROM `subjects` where subName = '$subName' and standard = '$standard' ");
        $this->ajaxResponse('',$subName.'@'.$standard.'deleted');	
    }
    
}

?>
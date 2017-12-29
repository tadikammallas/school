<?php

/**
 * subject class
 * author sandeep/veera
 */

class VS_atteandance extends VS_baseController{
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
        $create=$this->DBO->query("CREATE TABLE IF NOT EXISTS `atteandance` (
                                                                            `id` int(10) NOT NULL AUTO_INCREMENT,
                                                                            `uId` int(11) DEFAULT 0,
                                                                            `time` int(11) DEFAULT 0,
                                                                            `status` smallint(2) DEFAULT 0,
                                                                             PRIMARY KEY (`id`)
                                                                        ) ");
    }
    
    public function VS_add(){
        extract($_POST);
        $this->DBO->query("INSERT INTO `atteandance`(`uId`,`time`,`status`) VALUES ('$uId','$time','$status') ");
        $this->ajaxResponse('',$uId.'@'.$status.'inserted');	
    }
    
    public function VS_remove(){
        extract($_POST);
        $this->DBO->query("DELETE FROM `atteandance` where uId = $uId ");
        $this->ajaxResponse('',$subName.'@'.$standard.'deleted');	
    }
    
    public function VS_update(){
        extract($_POST);
        $this->DBO->query("UPDATE `atteandance` SET `status`='$status'where uId = $uId ");
        $this->ajaxResponse('',$uId.'@'.$status.'deleted');	
    }
    
    
    public function VS_getAtteandance(){
        $status = '';
        extract($_POST);
        $queryStr = '';
        if($uId){
            if($queryStr == ''){
                $queryStr .= 'WHERE ';
            }
            $queryStr .= 'users.uId='.$uId;
        }
        if($status){
            if($queryStr == ''){
                $queryStr .= 'WHERE ';
            }
            $queryStr .= 'atteandance.status='.$status;
        }
        $query=$this->DBO->query("SELECT * FROM `users` RIGHT JOIN `atteandance` ON atteandance.uId = users.uId ");
        $data = mysqli_fetch_all($query,MYSQLI_ASSOC);
        $this->ajaxResponse($data);
    }
    
    
}

?>
<?php
/**
 * Basic controller class, all controller class should be extended from this
 * @author:sandeep/veera
 */

class VS_baseController
{

    public function  __construct()
    {

    } 
    
    
    /*
     * ajaxResponse
     * function that handles the ajaxResponse
     * @args  	$html - the html data that has to be passed on to the javascript
     * 				$message - message that will be displayed in the footer region
     * 				$data - optional data array, to be passed to the javascript 
     * 				$result - optional variable to denote success or failure
     */
    public function ajaxResponse($data,$message='') 
    {
        $myResult['MESSAGE'] = cleanText($message);
        $myResult['DATA'] = $data;

        //header("Cache-Control: no-cache, must-revalidate" ); 
        //header("Pragma: no-cache" );
        //header("Content-type: application/json");
        // for jquery bug,
        header('Content-type: text/plain');
        //echo 'test';//json_encode($myResult);
        echo json_encode($myResult);
    	return;
    }
    
}
?>
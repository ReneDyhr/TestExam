<?php
class Alert{

	/**
    *
    * Create Alert for client
    *
    * @param string $type  contains the type for the alert
    * @param array $message  contains the messages for the alert
    * @return boolean
    */
    public static function setAlert($type="info", $message=array()){
        if(empty($message)){
            return false;
        }
        $data="";
        $message = implode("<br />", $message);
        if($type=="info"){
            $data.="  $('.alert-info').show();\n";
            $data.="  $('.alert_text').html('$message');\n";
        }
        if($type=="success"){
            $data.="  $('.alert-success').show();\n";
            $data.="  $('.alert_text').html('$message');\n";
        }
        if($type=="warning"){
            $data.="  $('.alert-warning').show();\n";
            $data.="  $('.alert_text').html('$message');\n";
        }
        if($type=="danger"){
            $data.="  $('.alert-danger').show();\n";
            $data.="  $('.alert_text').html('$message');\n";
        }
        $data.="setTimeout(\"$('.alert').hide();\",10000);\n";
        $_SESSION['data_alert'] = $data;
        return true;
    }


    /**
    *
    * Print alerts
    *
    * @return html data
    */
    public static function printAlerts(){
        $data = "<div class=\"alert alert-info\" role=\"alert\"><span class=\"alert_text\"></span></div>\n";
        $data .= "<div class=\"alert alert-success\" role=\"alert\"><span class=\"alert_text\"></span></div>\n";
        $data .= "<div class=\"alert alert-warning\" role=\"alert\"><span class=\"alert_text\"></span></div>\n";
        $data .= "<div class=\"alert alert-danger\" role=\"alert\"><span class=\"alert_text\"></span></div>\n";
		if (!empty($_SESSION['data_alert'])) {
		    $data .= "<script type=\"text/javascript\">\n";
		    $data .= "  $(document).ready(function() {\n";
		    $data .= $_SESSION['data_alert'];
		    $data .= "  });\n";
		    $data .= "</script>\n";
			unset($_SESSION['data_alert']);
		}
        return $data;
    }

}

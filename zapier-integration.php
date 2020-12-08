<?php
// Google ReCaptcha "secret". Please, get it on https://www.google.com/recaptcha/admin/create
//(leave string empty if you don't want to use gReCaptcha in your forms; learn more about gReCaptcha integration: https://designmodo.com/startup/documentation/#grecaptcha)
$gRecaptchaSecret = '';
// URL of this file using https
$scriptUrl = "https://".$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"];

$url = ''; // add your Zapier webhook url 

if (!empty($_POST)){

    foreach($_POST as $fieldKey=>$fieldValue){
		if(!empty($fieldValue)){
			switch($fieldKey){
                case "email":
					// $message .= '<b>email:</b>'.$fieldValue.'<br/>';
                    $zapier_request["email"] = $fieldValue;
					continue;
                    default:
					$zapier_request .= "<b>".str_replace("_"," ",ucfirst($fieldKey)).":</b> ".str_replace("\n", "<br />", $fieldValue).'<br />';
            }
            }
     }
      /* ZAPIER INTEGRATION */
	  if(!empty($url)){
        function zapier($url, $json, $headers) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
           // $output = curl_exec($ch);
            curl_close($ch);
 }
    $json = json_encode($zapier_request);
    $headers = array('Accept: application/json', 'Content-Type: application/json');
    // call the zapier() function
    zapier($url, $json, $headers);

 }
        if (empty($url)){
	    $response = 'Error: not Zapier integration is set. Check our <a href="https://designmodo.com/startup/documentation/" target="_blank" class="link color-transparent-white">documentation</a> to know how to do that.';
        echo $response;
	    }
            if(!empty($url)){
		    $response = "ok";
            echo $response;
        }

}
else{
	echo 'Error: $_POST PHP variable is empty (no data received from form). Check if your &lt;form&gt; tag has method="POST" attribute.';
}
?>


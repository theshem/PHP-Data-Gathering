<?php
// set url address and temporary cookie file
$ckfile = tempnam("../tmp", "HASH");
$url = "http://localhost/grabber/Secure-Form/secure-form.php";	// TODO: fix the address

#=========================== + GET SEARCH FORM ========================
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfile);
$data = curl_exec($ch);
#=========================== - GET SEARCH FORM ========================

#========================= + GET DOCUMENT OBJECTS =====================
// create DOM object
$doc = new DOMDocument();

// load HTML from string
@$doc->loadHTML($data);
#========================= - GET DOCUMENT OBJECTS =====================

#=========================== + SET POST PARAMS ========================
// list input tags
$inputs = $doc->getElementsByTagName('input');

// make an array of the existing input tags
foreach ($inputs as $input) {
	$input_arr[$input->getAttribute('name')] = $input->getAttribute('value');
}

// assign post params array
$post_arr = array(
	'fname'		=>	'Hashem',
	'lname'		=>	'Qolami',
	'TOKEN'		=>	rawurlencode($input_arr['TOKEN']),
	'submit'	=>	'Submit',
);

// convert array to string
$post_str = '';
foreach ($post_arr as $key=>$val) {
	if(strlen($post_str)>0) $post_str .='&';
	$post_str .= "$key=$val";
}
#=========================== - SET POST PARAMS ========================

// show post array and string type for checking
echo '<pre>';
print_r($post_arr);
echo $post_str;
echo '</pre>';

#========================== + GET THE RESULT ===========================
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_str);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
$data = curl_exec($ch);

echo $data;
#========================== - GET THE RESULT ===========================
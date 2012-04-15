<?php

/* STEP 1. let’s create a cookie file */
$ckfile = tempnam ("./tmp", "CURLCOOKIE");
$url = "http://localhost/Secure-Form/secure-form.php";

/* STEP 2. visit the homepage to set the cookie properly */
$ch = curl_init($url);
curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile); 
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

$myhtml = curl_exec ($ch);

// create DOM object
$doc = new DOMDocument();

// load HTML from string
@$doc->loadHTML($myhtml);

// list input tags
$input_arr = $doc->getElementsByTagName('input');

foreach ($input_arr as $input) {
       $post_data[$input->getAttribute('name')] = $input->getAttribute('value');
}

echo '<pre>';
print_r($post_data);
echo '</pre>';

echo $myhtml;

$post_data['fname']='Hashem';
$post_data['lname']='Qolami';

$ch = curl_init($url);
curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile); 
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

// doing a POST request
curl_setopt($ch, CURLOPT_POST, 1);

// adding the post variables to the request
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

$output = curl_exec($ch);

curl_close($ch);

echo '<pre>';
print_r($post_data);
echo '</pre>';

echo $output;
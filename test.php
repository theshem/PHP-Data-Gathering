<?php
$ckfile = tempnam ("./tmp", "CURLCOOKIE");
$url = "http://tibf.ir/Book/Search/Farsi/Default.aspx";

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

$post_data['ctl00$ContentPlaceHolder1$PriceValueRange$FromTextBox']=0;
$post_data['ctl00$ContentPlaceHolder1$PriceValueRange$ToTextBox']=10000000000;
$post_data['ctl00$ContentPlaceHolder1$SearchInNavigator1$MainDropDownList']='F';

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
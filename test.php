<?php
// set url address and temporary cookie file
$ckfile = tempnam("./tmp", "CURLCOOKIE");
$url = "http://tibf.ir/Book/Search/Farsi/Default.aspx";

#=========================== + GET SEARCH FORM ========================
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
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
	'__VIEWSTATE'				=>	rawurlencode($input_arr['__VIEWSTATE']),
	'__EVENTVALIDATION'			=>	rawurlencode($input_arr['__EVENTVALIDATION']),
	'__EVENTTARGET'				=>	'',
	'__EVENTARGUMENT'			=>	'',
	'__LASTFOCUS'				=>	'',
	'ctl00$QuickNewsTextBox'	=>	'',
	'ctl00$ContentPlaceHolder1$SearchInNavigator1$MainDropDownList'	=>	'F',
	'ctl00$ContentPlaceHolder1$TitleTextBox'						=>	'',
	'ctl00$ContentPlaceHolder1$IsbnTextBox'							=>	'',
	'ctl00$ContentPlaceHolder1$AuthorTextBox'						=>	'',
	'ctl00$ContentPlaceHolder1$PublisherTextBox'					=>	'',
	'ctl00$ContentPlaceHolder1$PriceValueRange$FromTextBox'			=>	0,
	'ctl00$ContentPlaceHolder1$PriceValueRange$ToTextBox'			=>	1000000000000000000000,
	'ctl00$ContentPlaceHolder1$IssueDateFarsiBookDateRange$DateRange1$FromPersianDateTextBox'	=>	'',
	'ctl00$ContentPlaceHolder1$IssueDateFarsiBookDateRange$DateRange1$ToPersianDateTextBox'		=>	'',
	'ctl00$ContentPlaceHolder1$SubjectTextBox'						=>	'',
	'ctl00$ContentPlaceHolder1$SearchImageButton.x'					=>	0,
	'ctl00$ContentPlaceHolder1$SearchImageButton.y'					=>	0	
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

///////////////////////////////////////////////////////////////////////////////////////////////
///////----------------------------			PAGE #2			----------------------------///////
///////////////////////////////////////////////////////////////////////////////////////////////

// create DOM object
$doc = new DOMDocument();

// load HTML from string
@$doc->loadHTML($data);

// list input tags
$inputs = $doc->getElementsByTagName('input');

// make an array of the existing input tags
foreach ($inputs as $input) {
	$input_arr[$input->getAttribute('name')] = $input->getAttribute('value');
}

unset($post_arr);

// assign post params array
$post_arr = array(
	'__VIEWSTATE'				=>	rawurlencode($input_arr['__VIEWSTATE']),
	'__EVENTVALIDATION'			=>	rawurlencode($input_arr['__EVENTVALIDATION']),
	'__EVENTTARGET'				=>	rawurlencode('ctl00$ContentPlaceHolder1$BookGridView'),	// STATIC PARAM
	'__EVENTARGUMENT'			=>	rawurlencode('Page$2'),									// DYNAMIC PARAM:	Page$3, Page$4, ...
	'__LASTFOCUS'				=>	'',
	'ctl00$QuickNewsTextBox'	=>	'',
	'ctl00$ContentPlaceHolder1$SearchInNavigator1$MainDropDownList'	=>	'F',
	'ctl00$ContentPlaceHolder1$TitleTextBox'						=>	'',
	'ctl00$ContentPlaceHolder1$IsbnTextBox'							=>	'',
	'ctl00$ContentPlaceHolder1$AuthorTextBox'						=>	'',
	'ctl00$ContentPlaceHolder1$PublisherTextBox'					=>	'',
	'ctl00$ContentPlaceHolder1$PriceValueRange$FromTextBox'			=>	0,
	'ctl00$ContentPlaceHolder1$PriceValueRange$ToTextBox'			=>	1000000000000000000000,
	'ctl00$ContentPlaceHolder1$IssueDateFarsiBookDateRange$DateRange1$FromPersianDateTextBox'	=>	'',
	'ctl00$ContentPlaceHolder1$IssueDateFarsiBookDateRange$DateRange1$ToPersianDateTextBox'		=>	'',
	'ctl00$ContentPlaceHolder1$SubjectTextBox'						=>	'',
);

// convert array to string
$post_str = '';
foreach ($post_arr as $key=>$val) {
	if(strlen($post_str)>0) $post_str .='&';
	$post_str .= "$key=$val";
}
#==========================- - SET POST PARAMS ========================

// show post array and string type for checking
echo '<pre>';
print_r($post_arr);
echo $post_str;
echo '</pre>';

#========================-- + GET THE RESULT ===========================
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_str);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
$data = curl_exec($ch);

echo $data;

///////////////////////////////////////////////////////////////////////////////////////////////
///////----------------------------			PAGE #3			----------------------------///////
///////////////////////////////////////////////////////////////////////////////////////////////

// create DOM object
$doc = new DOMDocument();

// load HTML from string
@$doc->loadHTML($data);

// list input tags
$inputs = $doc->getElementsByTagName('input');

// make an array of the existing input tags
foreach ($inputs as $input) {
	$input_arr[$input->getAttribute('name')] = $input->getAttribute('value');
}

unset($post_arr);

// assign post params array
$post_arr = array(
	'__VIEWSTATE'				=>	rawurlencode($input_arr['__VIEWSTATE']),
	'__EVENTVALIDATION'			=>	rawurlencode($input_arr['__EVENTVALIDATION']),
	'__EVENTTARGET'				=>	rawurlencode('ctl00$ContentPlaceHolder1$BookGridView'),	// STATIC PARAM
	'__EVENTARGUMENT'			=>	rawurlencode('Page$3'),									// DYNAMIC PARAM:	Page$3, Page$4, ...
	'__LASTFOCUS'				=>	'',
	'ctl00$QuickNewsTextBox'	=>	'',
	'ctl00$ContentPlaceHolder1$SearchInNavigator1$MainDropDownList'	=>	'F',
	'ctl00$ContentPlaceHolder1$TitleTextBox'						=>	'',
	'ctl00$ContentPlaceHolder1$IsbnTextBox'							=>	'',
	'ctl00$ContentPlaceHolder1$AuthorTextBox'						=>	'',
	'ctl00$ContentPlaceHolder1$PublisherTextBox'					=>	'',
	'ctl00$ContentPlaceHolder1$PriceValueRange$FromTextBox'			=>	0,
	'ctl00$ContentPlaceHolder1$PriceValueRange$ToTextBox'			=>	1000000000000000000000,
	'ctl00$ContentPlaceHolder1$IssueDateFarsiBookDateRange$DateRange1$FromPersianDateTextBox'	=>	'',
	'ctl00$ContentPlaceHolder1$IssueDateFarsiBookDateRange$DateRange1$ToPersianDateTextBox'		=>	'',
	'ctl00$ContentPlaceHolder1$SubjectTextBox'						=>	'',
);

// convert array to string
$post_str = '';
foreach ($post_arr as $key=>$val) {
	if(strlen($post_str)>0) $post_str .='&';
	$post_str .= "$key=$val";
}
#==========================- - SET POST PARAMS ========================

// show post array and string type for checking
echo '<pre>';
print_r($post_arr);
echo $post_str;
echo '</pre>';

#========================-- + GET THE RESULT ===========================
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_str);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
$data = curl_exec($ch);

echo $data;
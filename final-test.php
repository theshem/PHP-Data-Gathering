<?php
header('Content-type: text/html; charset=utf-8', true);

// set url address and temporary cookie file ///////////
$ckfile = tempnam("./tmp", "CURLCOOKIE");
$url = "http://tibf.ir/Book/Search/Farsi/Default.aspx";
$output_array = array();

function gather_data($old_data, $page_number){
	global $url, $ckfile, $output_array, $ch;
	
	// create DOM object
	$doc = new DOMDocument();
	// load HTML from string
	@$doc->loadHTML($old_data);
	
	#=========================== + SET POST PARAMS =========================#
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
		'__EVENTTARGET'				=>	rawurlencode('ctl00$ContentPlaceHolder1$BookGridView'),	// STATIC PARAM
		'__EVENTARGUMENT'			=>	rawurlencode('Page$'.$page_number),						// DYNAMIC PARAM:	Page$3, Page$4, ...
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
		'ctl00$ContentPlaceHolder1$SubjectTextBox'						=>	''	
	);
	
	if($page_number == 1){
		$post_arr['ctl00$ContentPlaceHolder1$SearchImageButton.x'] = 0;
		$post_arr['ctl00$ContentPlaceHolder1$SearchImageButton.y'] = 0;
	}
	
	// convert array to string
	$post_str = '';
	foreach ($post_arr as $key=>$val) {
		if(strlen($post_str)>0) $post_str .='&';
		$post_str .= "$key=$val";
	}
	#=========================== - SET POST PARAMS =========================#
	
	#========================== + GET THE RESULT ===========================#
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_str);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
	$data = curl_exec($ch);
	
	// create DOM object
	$doc = new DOMDocument();
	// load HTML from string
	@$doc->loadHTML(@mb_convert_encoding($data, 'HTML-ENTITIES', 'utf-8'));
	
	$table = $doc->getElementById('ctl00_ContentPlaceHolder1_BookGridView');
	
	$tr_arr = $table->getElementsByTagName('tr');
	
	foreach($tr_arr as $tr){
		$td_arr = $tr->getElementsByTagName('td');
		foreach($td_arr as $td){
			$temp[] = trim($td->textContent);
		}
		//	$temp[0]: ID	$temp[1]: ISBN Code
		if(is_array($temp) && is_numeric($temp[0]) && !is_numeric($temp[1])){
			$output_array[] = $temp;
		}
		unset($temp);
	}
	return $data;
}


#=========================== + GET FORM VALUES =========================#
#=============================== [FOR ONCE] ============================#
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfile);
$data = curl_exec($ch);
#=========================== - GET FORM VALUES =========================#

$limit = (isset($_GET['limit']) and is_numeric($_GET['limit'])) ? $_GET['limit'] : 1;

for($i=1; $i<=$limit; $i++){
	$data = gather_data($data, $i);
}

echo '<pre>';
print_r($output_array);
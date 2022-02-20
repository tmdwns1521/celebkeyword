<?php
$se_keys = $_POST['se_key'];
$se_url = $_POST['se_url'];

include_once 'simple_html_dom.php';
function file_get_contents_curl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // https 일때 이 한줄 추가 필요
    //Set curl to return the data instead of printing it to the browser.
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
$check = [];

ini_set("default_socket_timeout", 30);
require_once('restapi.php');

$config = parse_ini_file("sample.ini");
// print_r($config);
$kewords = preg_replace("/\s+/", "", $se_keys);
function debug($obj, $detail = false)
{
    if (is_array($obj)) {
        echo "size : " . count($obj) . "\n";
    }
    if ($detail) {
        print_r($obj);
    }
}
$DEBUG = false;
$api = new RestApi($config['BASE_URL'], $config['API_KEY'], $config['SECRET_KEY'], $config['CUSTOMER_ID']);
$data = array(
  "hintKeywords" => $kewords,
  "showDetail" => "1"
);
$keywordList = $api->GET('/keywordstool',$data);
$main_arr = [];
for($a = 0; $a < 1; $a++){
  $arr = [];
  if(array_key_exists($a,$keywordList["keywordList"])){
    $Related_keword = ($keywordList["keywordList"][$a]["relKeyword"]);
    $monthlypc = ($keywordList["keywordList"][$a]["monthlyPcQcCnt"]);
    if(strpos($monthlypc,'<') !== false){
      $monthlypc = '10';
    }
    array_push($check,(int)$monthlypc);
    $monthlymobile = ($keywordList["keywordList"][$a]["monthlyMobileQcCnt"]);
    if(strpos($monthlymobile,'<') !== false){
      $monthlymobile = '10';
    }
    array_push($check,(int)$monthlymobile);
  }
  else{
    break;
  }
}

$se_key = urlencode($se_keys);
$page_num = 1;
$blog_url = [];
for($j=1; $j<5; $j++){
  $save_url = ((string)'https://s.search.naver.com/p/review/search.naver?rev=43&where=view&api_type=11&start='.$page_num.'&query='.$se_key);
  $save_str = file_get_contents_curl($save_url);
  $enc = mb_detect_encoding($save_str, array('EUC-KR', 'UTF-8', 'shift_jis', 'CN-GB'));
  if ($enc != 'UTF-8') {
      $save_str = iconv($enc, 'UTF-8', $save_str);
  }
  // Create a DOM object
  $html = new simple_html_dom();
  // Load HTML from a string
  $html->load($save_str);
  $arr_result = $html->find('a[class=\"api_txt_lines]');
  if(count($arr_result) > 0){ //위의 이미지에서 a 태그에 포함되는 html dom 객체를 가져옴
    foreach($arr_result as $e){
      $section_name=$e->href;
      $section_name = str_replace("?Redirect=Log&logNo=","/",$section_name);
      $section_name = str_replace('"','',$section_name);
      $section_name = str_replace('\\','',$section_name);

      array_push($blog_url,$section_name);
      }
    }else{
      echo "";
    }
    $page_num = $page_num + 30;
}
  if(in_array($se_url,$blog_url)){
    $title_rank = array_search($se_url,$blog_url)+1;
  }else{
    $title_rank = 'X';
  }
array_push($check,$title_rank);
$page_num = 1;
$blog_url = [];
for($j=1; $j<5; $j++){
  $save_url = ((string)'https://s.search.naver.com/p/blog/search.naver?where=blog&sm=tab_pge&api_type=1&query='.$se_key.'&rev=43&start='.$page_num);
  $save_str = file_get_contents_curl($save_url);
  $enc = mb_detect_encoding($save_str, array('EUC-KR', 'UTF-8', 'shift_jis', 'CN-GB'));
  if ($enc != 'UTF-8') {
      $save_str = iconv($enc, 'UTF-8', $save_str);
  }
  // Create a DOM object
  $html = new simple_html_dom();
  // Load HTML from a string
  $html->load($save_str);
  $arr_result = $html->find('a[class=\"api_txt_lines]');
  if(count($arr_result) > 0){ //위의 이미지에서 a 태그에 포함되는 html dom 객체를 가져옴
    foreach($arr_result as $e){
      $section_name=$e->href;
      $section_name = str_replace("?Redirect=Log&logNo=","/",$section_name);
      $section_name = str_replace('"','',$section_name);
      $section_name = str_replace('\\','',$section_name);

      array_push($blog_url,$section_name);
      }
    }else{
      echo "";
    }
    $page_num = $page_num + 30;
}
  if(in_array($se_url,$blog_url)){
    $title_rank = array_search($se_url,$blog_url)+1;
  }else{
    $title_rank = 'X';
  }

array_push($check,$title_rank);
echo json_encode($check, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
?>

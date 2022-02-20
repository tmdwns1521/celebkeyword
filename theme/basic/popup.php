<?php
ini_set("memory_limit" , -1);
error_reporting(0);
if ($member['mb_level'] <= 2){
  alert("레벨업을 해주세요.", G5_BBS_URL."/board.php?bo_table=free");
}
include_once('./_common.php');

if (!defined('_GNUBOARD_')) exit;
include_once(G5_PATH.'/head.php');
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
$hash_tag = ($_POST['var']);
$se_url = ($_POST['var2']);
$se_m_url = str_replace("//","//m.",$se_url);
$m_strs = file_get_contents_curl($se_m_url);
$enc = mb_detect_encoding($m_strs, array('EUC-KR', 'UTF-8', 'shift_jis', 'CN-GB'));
if ($enc != 'UTF-8') {
    $m_strs = iconv($enc, 'UTF-8', $m_strs);
}
// Create a DOM object
$html = new simple_html_dom();
// Load HTML from a string
$html->load($m_strs);
$arr_results = $html->find('div[id="viewTypeSelector"]');
if(count($arr_results) > 0){ //위의 이미지에서 a 태그에 포함되는 html dom 객체를 가져옴
  foreach($arr_results as $e){
    $section_name = $e->plaintext;
    $section_names = preg_replace("/\s+/", "", $section_name);
  }
}else{
  $arr_results = $html->find('div[class="se-main-container"]');
  if(count($arr_results) > 0){
    foreach($arr_results as $e){
      $section_name = $e->plaintext;
      $section_names = preg_replace("/\s+/", "", $section_name);
    }
  }else{
    $section_names = None;
  }
}
$hash_tag = explode("#",$hash_tag);
array_shift($hash_tag);
echo '<div class="pop_up_table" style="display: flex; padding-bottom: 10%; padding-right:10%; padding-left:10%;">';
echo '<table style="text-align:center; width: 200%">';
echo '<td style="border:solid 1px;">#태그 키워드</td><td style="border:solid 1px">키워드 노출</td><td style="border:solid 1px">태그 반복</td>';
foreach ($hash_tag as $se_key) {
  $se_key = preg_replace("/\s+/", "", $se_key);
  $re_title = $se_key;
  $se_key = urlencode($se_key);
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
  // echo $se_url;
  // print_r($blog_url);
  if(in_array($se_url,$blog_url)){
    $title_rank = array_search($se_url,$blog_url)+1;
  }else{
    $title_rank = 'X';
  }
  $re_title = preg_replace("/\s+/","",$re_title);
  $keword_in_count = substr_count($section_names,$re_title);
  echo '<tr>';
  echo '<td style="border:solid 1px">';?><?php echo $re_title; ?><?php echo '</td>';
  echo '<td style="border:solid 1px">';?><?php echo $title_rank; ?><?php echo '</td>';
  echo '<td style="border:solid 1px">';?><?php echo $keword_in_count; ?><?php echo '</td>';
  echo '</tr>';
}
echo '</table>';
echo '</div>';
 ?>
 <?php
 include_once(G5_THEME_PATH.'/tail.php');
 ?>

<?php
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/keyword_check.php');
    return;
}
if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}

include_once(G5_THEME_PATH.'/head.php');

if(defined('_INDEX_')) { // index에서만 실행
	include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
}
?>
<?php
if ($member['mb_level'] <= 1){
  alert("회원가입을 해주세요.", G5_BBS_URL."/login.php?url=".urlencode(G5_URL."/mykeword_check.php"));
}
if ($member['mb_level'] <= 2){
  alert("레벨업을 해주세요!", G5_BBS_URL."/board.php?bo_table=free");
}
  ini_set("memory_limit" , -1);
  error_reporting(0);

 ?>
 <div id="loading">
    <img src='<?php echo G5_THEME_URL; ?>/img/cat.gif' id ="logo_imgs" alt="loading">
  </div>
  <script>
  $(document).ready(function() {
    $('#loading').hide();
    $('#next').submit(function(){
      $('#containers').hide();
      $('#loading').show();
      return true;
    });
  });
  </script>
  <div id="containers">
    <div class="container">
			<section class="content_bgcolor-4" id="main_key">
				<span class="input input--madoka">
          <form method="post" action="<?php echo G5_URL; ?>/keyword_check.php" id='next'>
            <table>
              <td style="width:100%; padding: 0;"><input class="input__field input__field--madoka" type="text" name="stx" id="input-31" />
    					<label class="input__label input__label--madoka" for="input-31">
    						<svg class="graphic graphic--madoka" width="100%" height="100%" viewBox="0 0 404 77" preserveAspectRatio="none">
    							<path d="m0,0l404,0l0,77l-404,0l0,-77z"/>
    						</svg>
    						<span class="input__label-content input__label-content--madoka">검색 키워드를 입력해 주세요</span>
    					</label></td>
              <td><div class="input-group-append" style="height: 51px;">
                <button type="submit" id="sch_submit" value="검색" class="btn btn-primary"><i class="fas fa-search fa-sm"></i></button>
              </div></td>
            </table>
          </form>
				</span>
			</section>
		</div><!-- /container -->


		<script src="<?php echo G5_THEME_URL; ?>/js/classie.js"></script>
		<script src="<?php echo G5_THEME_URL; ?>/js/clas.js"></script>
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Content Row -->
          <div class="row">
            <!-- Pending Requests Card Example -->
            <?php
            if(empty($_POST['stx'])){
              echo "";
            }else{
              if ($member['mb_level'] > 3){
                echo "";
              }else{
                if ($member[mb_point] < 50){
                  alert("포인트가 부족합니다..");
                }else{
                  insert_point($member[mb_id], -50, "$board[bo_subject] $wr_id 포스팅 분석", $bo_table, $wr_id, $g5['time_ymdhis']);
                }
              }
              if(isset($_POST['stx'])){
                $keword = $_POST['stx'];
                $keword = preg_replace("/\s+/", "", $keword);
                $url = "https://search.naver.com/search.naver?where=nexearch&sm=top_hty&fbm=1&ie=utf8&query=".$keword;
                $ch = curl_init();
                $timeout = 5;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                $html = curl_exec($ch);
                curl_close($ch);
                $dom = new DOMDocument();
                $Relation_keyword = [];
                @$dom->loadHTML("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">".$html);
                $element = $dom->getElementById('nx_footer_related_keywords');
                if($element){
                  echo '<div class="col-xl-3 col-md-6 mb-4">';
                    echo '<div class="card border-left-warning shadow h-100 py-2">';
                    echo '<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">';
                    echo '<h6 class="m-0 font-weight-bold text-primary" style="color:black !important;">연관 검색어 분석</h6>';
                  echo '</div>';
                      echo '<div class="card-body">';
                        echo '<div id="relation_keyword" class="row no-gutters align-items-center">';
                          echo '<div class="col mr-2">';
                          echo '<table>';
                            echo '<tr>';
                            foreach($element->getElementsByTagName('li') as $list){
                              echo '<td class="relation_key"># ';?> <?php echo $list->textContent; ?><?php echo '</td>';
                            }
                            echo '</tr>';
                          echo '</table>';
                            echo '<div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="padding-top: 4%;"> ';?><?php echo $keword; ?><?php echo ' 연관 검색어</div>';
                          echo '</div>';
                        echo '</div>';
                      echo '</div>';
                    echo '</div>';
                  echo '</div>';
                }
              }
              if(isset($_POST['stx'])){
                $keword = $_POST['stx'];
                $keword = preg_replace("/\s+/", "", $keword);
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
                $url = "https://search.naver.com/search.naver?where=nexearch&sm=top_hty&fbm=1&ie=utf8&query=".$keword;
                $str = file_get_contents_curl($url);
                $enc = mb_detect_encoding($str, array('EUC-KR', 'UTF-8', 'shift_jis', 'CN-GB'));
                if ($enc != 'UTF-8') {
                    $str = iconv($enc, 'UTF-8', $str);
                }
                // Create a DOM object
                $html = new simple_html_dom();
                // Load HTML from a string
                $html->load($str);
                $arr_result = $html->find('div.main_pack>div,section');
                $section_tap = True;
                $already_section = [];
                $section_lists = [];
                if(count($arr_result) > 0){ //위의 이미지에서 a 태그에 포함되는 html dom 객체를 가져옴
                  foreach($arr_result as $e){
                    if($section_tap==False){
                      break;
                    }
                    $section_name =  $e->plaintext;
                    $se_name = explode(' ', $section_name );
                    if(!empty($se_name)){
                        foreach ($se_name as $value){
                          if($value==""){
                            echo "";
                          }elseif($value=="이전"){
                            $section_tap = False;
                            break;
                          } else{
                            if(in_array($value,$already_section)){
                              break;
                            }else{
                              array_push($already_section,$value);
                              $value = str_replace("영어사전·웹수집이", "영어사전·웹수집", $value);
                              $value = str_replace("플레이스내", "플레이스", $value);
                              $value = str_replace("플레이스플레이스", "플레이스", $value);
                              $value = str_replace("실시간검색도움말", "실시간검색", $value);
                              $value = str_replace("네이버쇼핑이", "네이버쇼핑", $value);
                              $value = str_replace("인플루언서이", "인플루언서", $value);
                              $value = str_replace("뮤직이", "뮤직", $value);
                              $value = str_replace("새로", "새로 오픈했어요", $value);
                              if(strpos($value,"옵션") !== false){
                                echo "";
                                break;
                              }else{
                                if(strpos($value,".") !== false){
                                  array_push($section_lists,'웹사이트');
                                  break;
                                }else{
                                  array_push($section_lists,$value);
                                  break;
                                }
                              }
                              echo "";
                            }
                          }
                      }
                    }
                  }
                } else { echo ""; }
                include_once 'simple_html_dom.php';
                function file_get_contents_curls($url) {
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
                $url = "https://m.search.naver.com/search.naver?sm=mtp_hty.top&where=m&query=".$keword;
                $str = file_get_contents_curls($url);
                $enc = mb_detect_encoding($str, array('EUC-KR', 'UTF-8', 'shift_jis', 'CN-GB'));
                if ($enc != 'UTF-8') {
                    $str = iconv($enc, 'UTF-8', $str);
                }
                // Create a DOM object
                $html = new simple_html_dom();
                // Load HTML from a string
                $html->load($str);
                $arr_result = $html->find('div[id=ct]>div,section');
                $section_tap = True;
                $already_sectioned = [];
                $section_listed = [];
                for($i=0;$i<2;$i++){
                  array_shift( $arr_result );
                }
                if(count($arr_result) > 0){ //위의 이미지에서 a 태그에 포함되는 html dom 객체를 가져옴
                  foreach($arr_result as $e){
                    if($section_tap==False){
                      break;
                    }
                    $section_name =  $e->plaintext;
                    $se_name = explode(' ', $section_name );
                    if(!empty($se_name)){
                        foreach ($se_name as $value){
                          if($value==""){
                            echo "";
                          }elseif($value=="이전페이지"){
                            $section_tap = False;
                            break;
                          } else{
                            if(in_array($value,$already_sectioned)){
                              break;
                            }else{
                              array_push($already_sectioned,$value);
                              $value = str_replace("영어사전·웹수집이", "영어사전·웹수집", $value);
                              $value = str_replace("플레이스MY", "플레이스", $value);
                              $value = str_replace("플레이스안내MY", "플레이스", $value);
                              $value = str_replace("플레이스플레이스", "플레이스", $value);
                              $value = str_replace("실시간검색도움말", "실시간검색", $value);
                              $value = str_replace("네이버쇼핑이", "네이버쇼핑", $value);
                              $value = str_replace("인플루언서이", "인플루언서", $value);
                              $value = str_replace("뮤직이", "뮤직", $value);
                              $value = str_replace("새로", "새로 오픈했어요", $value);
                              $value = str_replace("연관검색어", "", $value);
                              $value = str_replace("최신", "최신 컨텐츠", $value);
                              if(strpos($value,"문서") !== false){
                                array_push($section_listed,'웹사이트');
                                break;
                              }else{
                                array_push($section_listed,$value);
                                break;
                              }
                            }
                          }
                      }
                      echo "";
                    }
                  }
                } else { echo ""; }
                if($section_lists){
                  echo '<div class="col-xl-3 col-md-6 mb-4">';
                    echo '<div class="card border-left-warning shadow h-100 py-2">';
                    echo '<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">';
                    echo '<h6 class="m-0 font-weight-bold text-primary" style="color:black !important;">키워드 섹션 분석</h6>';
                  echo '</div>';
                      echo '<div class="card-body">';
                        echo '<div id="section_p_m" class="row no-gutters align-items-center">';
                          echo '<div class="col mr-2" id="section_p_m">';
                          echo '<div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="padding-top: 4%;"> ';?><?php echo $keword; ?><?php echo ' 섹션(PC)</div>';
                          echo '<table>';
                          $s_p_n = 1;
                            foreach($section_lists as $values){
                              echo '<tr>';
                              echo '<td class="relation_key">';?> <?php echo $s_p_n; echo " "; echo $values; ?><?php echo '</td>';
                              echo '</tr>';
                              $s_p_n++;
                            }
                          echo '</table>';
                          echo '</div>';
                        echo '</div>';
                        echo '<div id="section_p_m" class="row no-gutters align-items-center">';
                          echo '<div class="col mr-2" >';
                          echo '<div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="padding-top: 4%;"> ';?><?php echo $keword; ?><?php echo ' 섹션(MOBILE)</div>';
                          echo '<table>';
                          $s_m_n = 1;
                            foreach($section_listed as $valued){
                              echo '<tr>';
                              echo '<td class="relation_key">';?> <?php echo $s_m_n; echo " "; echo $valued; ?><?php echo '</td>';
                              echo '</tr>';
                              $s_m_n++;
                            }
                          echo '</table>';
                          echo '</div>';
                        echo '</div>';
                      echo '</div>';
                    echo '</div>';
                  echo '</div>';
                }
              }
              if(isset($_POST['stx'])){
                $keword = $_POST['stx'];
                $keword = preg_replace("/\s+/", "", $keword);
                function kewords($keword){
 									  ini_set("default_socket_timeout", 30);
 									  require_once('restapi.php');

 									  $config = parse_ini_file("sample.ini");
 									  // print_r($config);

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
 									    "hintKeywords" => $keword,
 									    "showDetail" => "1"
 									  );
 									  $keywordList = $api->GET('/keywordstool',$data);
 									  $main_arr = [];
 									  for($a = 0; $a <= 19; $a++){
 									    $arr = [];
 											if(array_key_exists($a,$keywordList["keywordList"])){
 												$Related_keword = ($keywordList["keywordList"][$a]["relKeyword"]);
 										    $monthlypc = ($keywordList["keywordList"][$a]["monthlyPcQcCnt"]);
 												if(strpos($monthlypc,'<') !== false){
 													$monthlypc = '10';
 												}
 										    $monthlymobile = ($keywordList["keywordList"][$a]["monthlyMobileQcCnt"]);
 												if(strpos($monthlymobile,'<') !== false){
 													$monthlymobile = '10';
 												}
 										    $arr[$a] = [$Related_keword,$monthlypc,$monthlymobile];
 										    array_push($main_arr, $arr);
 											}
 											else{
 												break;
 											}
 									  }
 									  return $main_arr;
 									}
                   $keword_list = (kewords($keword));
 									$keword_one = ($keword_list[0][0][0]);
 									$pc_search = ($keword_list[0][0][1]);
 									$mobile_search = ($keword_list[0][0][2]);
 									$pc_mobile_search = ((int)$pc_search+(int)$mobile_search);
                  echo '<div class="col-xl-3 col-md-6 mb-4" id="col_4_mb">';
                    echo '<div class="card border-left-primary shadow h-100 py-2">';
                    echo '<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">';
                    echo '<h6 class="m-0 font-weight-bold text-primary" style="color:black !important;">월간 검색량 분석</h6>';
                  echo '</div>';
                      echo '<div class="card-body">';
                        echo '<div class="row no-gutters align-items-center">';
                          echo '<div class="col mr-2">';
                          echo '<span><i class="fas fa-desktop fa-3x text-gray-1000"></i></span>';
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">';?><?php echo number_format((int)($pc_search)); ?><?php echo '</div>';
                            echo '<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">월간 검색량(PC)</div>';
                          echo '</div>';
                        echo '</div>';
                        echo '<div class="row no-gutters align-items-center">';
                          echo '<div class="col mr-2">';
                          echo '<span><i class="fas fa-mobile fa-3x text-gray-1000"></i></span>';
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">';?><?php echo number_format((int)($mobile_search)); ?><?php echo '</div>';
                            echo '<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">월간 검색량(모바일)</div>';
                          echo '</div>';
                        echo '</div>';
                        echo '<div class="row no-gutters align-items-center">';
                          echo '<div class="col mr-2">';
                          echo '<span><i class="fas fa-globe fa-3x text-gray-1000"></i></span>';
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">';?><?php echo number_format((int)($pc_mobile_search)); ?><?php echo '</div>';
                            echo '<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">월간 검색량(통합)</div>';
                          echo '</div>';
                        echo '</div>';
                      echo '</div>';
                    echo '</div>';
                  echo '</div>';
                }
                if(isset($_POST['stx'])){
                  $keword = $_POST['stx'];
                  $keword = preg_replace("/\s+/", "", $keword);
                  function getWebPage($url)
    									{
    									    $ch = curl_init();
    									    curl_setopt($ch, CURLOPT_URL, $url);
    									    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    									    curl_setopt($ch, CURLOPT_HEADER, false);
    									    $res = curl_exec($ch);
    									    curl_close($ch);
    									    return $res;
    									}
                  $kan = ((string)'https://s.search.naver.com/p/blog/search.naver?where=blog&sm=tab_pge&api_type=1&query='.$keword.'&rev=43&start=31&dup_remove=1&post_blogurl=&post_blogurl_without=&nso=p%3A1m&');
      						$blog_month = getWebPage($kan);
      						$blog_month_list = explode('"',$blog_month);
      						$blog_month_num = round((int)$blog_month_list[3],-1);
                  $kan2 = 'https://s.search.naver.com/p/cafe/search.naver?where=article&ie=utf8&query='.$keword.'&prdtype=0&t=0&st=rel&date_option=3&srchby=text&dup_remove=1&cafe_url=&without_cafe_url=&sm=tab_viw.cafe&nso=so:r,p:1m,a:all&abuse=0&ac=1&aq=0&converted=0&is_dst=0&nlu_query=%7B%22r_category%22%3A%2219+33%22%7D&nqx_context=&nx_and_query=&nx_search_hlquery=&nx_search_query=&nx_sub_query=&people_sql=0&spq=0&x_tab_article=&is_person=0&start=11&display=10&prmore=1&_callback=viewMoreContents';
    							$cafe_month = getWebPage($kan2);
    							$cafe_month_list = explode('"',$cafe_month);
    							$cafe_month_num = round((int)$cafe_month_list[3],-1);
                  $blog_cafe_num = $blog_month_num+$cafe_month_num;
                  echo '<div class="col-xl-3 col-md-6 mb-4" id="col_4_mb">';
                    echo '<div class="card border-left-success shadow h-100 py-2">';
                    echo '<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">';
                    echo '<h6 class="m-0 font-weight-bold text-primary" style="color: black !important;">월간 문서 발행량 분석</h6>';
                  echo '</div>';
                      echo '<div class="card-body">';
                        echo '<div class="row no-gutters align-items-center">';
                          echo '<div class="col mr-2">';
                          echo '<i class="far far fa-copy fa-3x text-gray-1000"></i>';
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">';?><?php echo number_format((int)($blog_month_num)); ?><?php echo '</div>';
                            echo '<div class="text-xs font-weight-bold text-success text-uppercase mb-1">월간 문서 발행량(블로그)</div>';
                          echo '</div>';
                        echo '</div>';
                        echo '<div class="row no-gutters align-items-center">';
                          echo '<div class="col mr-2">';
                          echo '<i class="far far fa-copy fa-3x text-gray-1000"></i>';
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">';?><?php echo number_format((int)($cafe_month_num)); ?><?php echo '</div>';
                            echo '<div class="text-xs font-weight-bold text-success text-uppercase mb-1">월간 문서 발행량(카페)</div>';
                          echo '</div>';
                        echo '</div>';
                        echo '<div class="row no-gutters align-items-center">';
                          echo '<div class="col mr-2">';
                          echo '<i class="far far fa-copy fa-3x text-gray-1000"></i>';
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">';?><?php echo number_format((int)($blog_cafe_num)); ?><?php echo '</div>';
                            echo '<div class="text-xs font-weight-bold text-success text-uppercase mb-1">월간 문서 발행량(통합)</div>';
                          echo '</div>';
                        echo '</div>';
                      echo '</div>';
                    echo '</div>';
                  echo '</div>';
                }
                if(isset($blog_month_num)){
    							if(strpos($pc_mobile_search, 'NANNAN') !== false) {
    								echo "대기";
    							} else {
                  echo '<div class="col-xl-3 col-md-6 mb-4" id="col_4_mb">';
                    echo '<div class="card border-left-info shadow h-100 py-2">';
                    echo '<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">';
                    echo '<h6 class="m-0 font-weight-bold text-primary" style="color:black !important;">콘텐츠별 키워드 경쟁 강도 분석</h6>';
                  echo '</div>';
                      echo '<div class="card-body">';
                        echo '<div class="row no-gutters align-items-center">';
                          echo '<div class="col mr-2">';
                            echo '<i id="fab_key" class="fab fa-acquisitions-incorporated fa-3x text-gray-1000"></i>';
                              echo '<div class="col-auto">';
                                echo '<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">';?><?php
                                $rate_blog = round((int)$blog_month_num/$pc_mobile_search*100);
                                echo (string)$rate_blog.'%'; ?><?php echo '</div>';
                              echo '</div>';
                              echo '<div id = "colms" class="col">';
                                echo '<div class="progress progress-sm mr-2">';
                                  echo '<div class="progress-bar bg-info" role="progressbar" style="width:';?><?php echo (string)$rate_blog; ?><?php echo '%;';?><?php if ($rate_blog <= 30){
                                    $color1 = 'green';
                                    $compete1 = '약함';
                                  } elseif (30 < $rate_blog and $rate_blog <= 80){
                                    $color1 = 'darkblue';
                                    $compete1 = '보통';
                                  }else{
                                    $color1 = 'red';
                                    $compete1 = '강함';
                                  }?><?php echo 'background-color:'?><?php echo $color1; ?><?php echo' !important;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>';
                                echo '</div>';
                                echo '<div class="text-xs font-weight-bold text-info text-uppercase mb-1" id="upeer_cont" style="color:';?><?php echo $color1; echo '!important; padding-top: 5%;">경쟁 강도 : ';?><?php echo $compete1; echo'</div>';
                              echo '<div class="text-xs font-weight-bold text-info text-uppercase mb-1">키워드 <br/>경쟁강도(블로그)</div>';
                            echo '</div>';
                          echo '</div>';
                        echo '</div>';
                        echo '<div class="row no-gutters align-items-center">';
                          echo '<div class="col mr-2">';
                            echo '<i id="fab_key" class="fab fa-acquisitions-incorporated fa-3x text-gray-1000"></i>';
                              echo '<div class="col-auto">';
                                echo '<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">';?><?php
                                $rate_cafe = round((int)$cafe_month_num/$pc_mobile_search*100);
                                 echo (string)$rate_cafe.'%'; ?><?php echo '</div>';
                              echo '</div>';
                              echo '<div id = "colms" class="col">';
                                echo '<div class="progress progress-sm mr-2">';
                                  echo '<div class="progress-bar bg-info" role="progressbar" style="width:';?><?php echo (string)$rate_cafe; ?><?php echo '%;';?><?php if ($rate_cafe <= 30){
                                    $color2 = 'green';
                                    $compete2 = '약함';
                                  } elseif (30 < $rate_cafe and $rate_cafe <= 80){
                                    $color2 = 'darkblue';
                                    $compete2 = '보통';
                                  }else{
                                    $color2 = 'red';
                                    $compete2 = '강함';
                                  }?><?php echo 'background-color:'?><?php echo $color2; ?><?php echo' !important;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>';
                                echo '</div>';
                              echo '</div>';
                              echo '<div class="text-xs font-weight-bold text-info text-uppercase mb-1" id="upeer_cont" style="color:';?><?php echo $color2; echo '!important; padding-top: 5%;">경쟁 강도 : ';?><?php echo $compete2; echo'</div>';
                              echo '<div class="text-xs font-weight-bold text-info text-uppercase mb-1">키워드 <br/>경쟁강도(카페)</div>';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="row no-gutters align-items-center">';
                          echo '<div class="col mr-2">';
                            echo '<i id="fab_key" class="fab fa-acquisitions-incorporated fa-3x text-gray-1000"></i>';
                              echo '<div class="col-auto">';
                                echo '<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">';?><?php
                                $blog_cafe_rate = (round((int)$blog_month_num/$pc_mobile_search*100)+round((int)$cafe_month_num/$pc_mobile_search*100));
                                 echo (string)$blog_cafe_rate.'%'; ?><?php echo '</div>';
                              echo '</div>';
                              echo '<div id = "colms" class="col">';
                                echo '<div class="progress progress-sm mr-2">';
                                  echo '<div class="progress-bar bg-info" role="progressbar" style="width: ';?><?php echo (string)$blog_cafe_rate; ?><?php echo '%;';?><?php if ($blog_cafe_rate <= 30){
                                    $color3 = 'green';
                                    $compete3 = '약함';
                                  } elseif (30 < $blog_cafe_rate and $blog_cafe_rate <= 80){
                                    $color3 = 'darkblue';
                                    $compete3 = '보통';
                                  }else{
                                    $color3 = 'red';
                                    $compete3 = '강함';
                                  }?><?php echo 'background-color:'?><?php echo $color3; ?><?php echo' !important;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>';
                                echo '</div>';
                              echo '</div>';
                              echo '<div class="text-xs font-weight-bold text-info text-uppercase mb-1" id="upeer_cont" style="color:';?><?php echo $color3; echo '!important; padding-top: 5%;">경쟁 강도 : ';?><?php echo $compete3; echo'</div>';
                              echo '<div class="text-xs font-weight-bold text-info text-uppercase mb-1">키워드 <br/>경쟁강도(통합)</div>';
                            echo '</div>';
                        echo '</div>';
                      echo '</div>';
                    echo '</div>';
                  echo '</div>';
                }
    					}
              if(isset($_POST['stx'])){
                $keword = $_POST['stx'];
                $keword = preg_replace("/\s+/", "", $keword);
                ini_set("default_socket_timeout", 30);
                require_once 'restapi.php';

                $config = parse_ini_file("sample.ini");

                $DEBUG = false;

                $api = new RestApi($config['BASE_URL'], $config['API_KEY'], $config['SECRET_KEY'], $config['CUSTOMER_ID']);

                $req_performance_bulk = array (
                		"items" => array (
                				0 => array (
                						"device" => "BOTH",
                						"keywordplus" => true,
                						"keyword" => $keword,
                						"bid" => 100000
                				)
                		)
                );
                $response = $api->POST('/estimate/performance-bulk', $req_performance_bulk);
                $click = ($response['items'][0]['clicks']);
                $impressions = ($response['items'][0]['impressions']);
                $cost = ($response['items'][0]['cost']);
                echo '<div class="col-xl-3 col-md-6 mb-4" id="col_4_mb" style="height: 365px">';
                  echo '<div class="card border-left-success shadow h-100 py-2">';
                  echo '<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">';
                  echo '<h6 class="m-0 font-weight-bold text-primary" style="color:black !important;">월간 예상 실적 분석</h6>';
                echo '</div>';
                    echo '<div class="card-body">';
                      echo '<div class="row no-gutters align-items-center" id="click_know">';
                        echo '<div class="col mr-2">';
                        echo '<i class="fas fa-search fa-3x text-gray-1000"></i>';
                          echo '<div class="h5 mb-0 font-weight-bold text-gray-800">';?><?php echo number_format((int)($impressions)); ?><?php echo '</div>';
                          echo '<div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="color:black !important; ">월간 예상 노출수</div>';
                        echo '</div>';
                      echo '</div>';
                      echo '<div class="row no-gutters align-items-center" id="click_know">';
                        echo '<div class="col mr-2">';
                        echo '<i class="fas fa-mouse-pointer fa-3x text-gray-1000"></i>';
                          echo '<div class="h5 mb-0 font-weight-bold text-gray-800">';?><?php echo number_format((int)($click)); ?><?php echo '</div>';
                          echo '<div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="color:black !important; ">월간 예상 클릭수</div>';
                        echo '</div>';
                      echo '</div>';
                      echo '<div class="row no-gutters align-items-center" id="click_know">';
                        echo '<div class="col mr-2" style="padding-top: 5%;">';
                        echo '<i class="fas fa-won-sign fa-3x text-gray-1000"></i>';
                          echo '<div class="h5 mb-0 font-weight-bold text-gray-800">';?><?php echo number_format((int)($cost)); ?><?php echo ' ₩</div>';
                          echo '<div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="color:black !important; ">월간 예상 광고비용</div>';
                        echo '</div>';
                      echo '</div>';
                      echo '<div class="row no-gutters align-items-center" id="click_know">';
                        echo '<div class="col mr-2" style="padding-top: 5%;">';
                        echo '<i class="fas fa-won-sign fa-3x text-gray-1000"></i>';
                          echo '<div class="h5 mb-0 font-weight-bold text-gray-800">';?><?php
                          try { echo number_format(round((int)($cost)/(int)($click),-1)); } catch(Exception $e){ echo "0"; } ?><?php echo ' ₩</div>';
                          echo '<div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="color:black !important; ">예상 평균 클릭당비용</div>';
                        echo '</div>';
                      echo '</div>';
                    echo '</div>';
                  echo '</div>';
                echo '</div>';
              echo '</div>';
              }
              if(isset($_POST['stx'])){
                $keword = $_POST['stx'];
                $keword = preg_replace("/\s+/", "", $keword);
                if(isset($keword_list)){
                  echo '<div class="col-xl-3 col-md-6 mb-4">';
                    echo '<div class="card border-left-successf shadow h-100 py-2">';
                    echo '<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">';
                    echo '<h6 class="m-0 font-weight-bold text-primary" style="color: black !important;">연관 키워드 분석</h6>';
                  echo '</div>';
                      echo '<div class="card-body">';
                        echo '<div class="row no-gutters align-items">';
                          echo '<div class="col mr-2">';
                          echo '<table class="relation_table" id="relation_keys">';
                          echo '<thead style="background-color: lightgoldenrodyellow;">';
                          echo '<tr>';
                          echo '<th style= "border-right: solid 1px; border-left: solid 1px;"><button onclick="sortTD ( 0 )"><i class="fas fa-chevron-up"></i></button>키워드<button onclick="reverseTD ( 0 )"><i class="fas fa-chevron-down"></i></button></th>';
                          echo '<th><button onclick="sortTD ( 1 )"><i class="fas fa-chevron-up"></i></button>월간 검색량(PC)<button onclick="reverseTD ( 1 )"><i class="fas fa-chevron-down"></i></button></th>';
                          echo '<th><button onclick="sortTD ( 2 )"><i class="fas fa-chevron-up"></i></button>월간 검색량(모바일)<button onclick="reverseTD ( 2 )"><i class="fas fa-chevron-down"></i></button></th>';
                          echo '<th><button onclick="sortTD ( 3 )"><i class="fas fa-chevron-up"></i></button>월간 검색량(통합)<button onclick="reverseTD ( 3 )"><i class="fas fa-chevron-down"></i></button></th>';
                          echo '<th><button onclick="sortTD ( 4 )"><i class="fas fa-chevron-up"></i></button>월간 문서발행량(통합)<button onclick="reverseTD ( 4 )"><i class="fas fa-chevron-down"></i></button></th>';
                          echo '<th style= "border-right: solid 1px;">콘텐츠별 키워드 경쟁 강도</th>';
                          echo '</tr>';
                          echo '</thead>';
                          echo '<tbody>';
                          foreach ($keword_list as $key => $value) {
                            echo "<tr>";
                            foreach ($value as $k => $v) {
                              echo "<td style='border-right: solid 1px; border-left: solid 1px; '>$v[0]</td>"; // Get value.
                              echo "<td>";?><?php echo number_format((int)($v[1]));?><?php echo"</td>";
                              echo "<td>";?><?php echo number_format((int)($v[2]));?><?php echo"</td>";
                              $re_sum = (int)$v[1]+(int)$v[2];
                              echo "<td>";?><?php echo number_format((int)($re_sum));?><?php echo"</td>";
                              $kan = ((string)'https://s.search.naver.com/p/blog/search.naver?where=blog&sm=tab_pge&api_type=1&query='.(string)$v[0].'&rev=43&start=31&dup_remove=1&post_blogurl=&post_blogurl_without=&nso=p%3A1m&');
                              $ch = curl_init();
                              curl_setopt($ch, CURLOPT_URL, $kan);
                              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                              curl_setopt($ch, CURLOPT_HEADER, false);
                              $res1 = curl_exec($ch);
                              curl_close($ch);
                  						$blog_month_list = explode('"',$res1);
                  						$blog_month_num = round((int)$blog_month_list[3],-1);
                              $kan2 = 'https://s.search.naver.com/p/cafe/search.naver?where=article&ie=utf8&query='.(string)$v[0].'&prdtype=0&t=0&st=rel&date_option=3&srchby=text&dup_remove=1&cafe_url=&without_cafe_url=&sm=tab_viw.cafe&nso=so:r,p:1m,a:all&abuse=0&ac=1&aq=0&converted=0&is_dst=0&nlu_query=%7B%22r_category%22%3A%2219+33%22%7D&nqx_context=&nx_and_query=&nx_search_hlquery=&nx_search_query=&nx_sub_query=&people_sql=0&spq=0&x_tab_article=&is_person=0&start=11&display=10&prmore=1&_callback=viewMoreContents';
                              $ch = curl_init();
                              curl_setopt($ch, CURLOPT_URL, $kan2);
                              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                              curl_setopt($ch, CURLOPT_HEADER, false);
                              $res2 = curl_exec($ch);
                              curl_close($ch);
                							$cafe_month_list = explode('"',$res2);
                							$cafe_month_num = round((int)$cafe_month_list[3],-1);
                              $blog_cafe_num = $blog_month_num+$cafe_month_num;
                              echo "<td>";?><?php echo number_format((int)($blog_cafe_num));?><?php echo"</td>";
                              $contents_rate = round($blog_cafe_num/$re_sum*100,-1);
                              if($contents_rate <= 30){
                                $contents_fiber = '약함';
                                $contents_fiber_style = 'green';
                              }elseif (30 < $contents_rate and $contents_rate <= 80){
                                $contents_fiber = '보통';
                                $contents_fiber_style = 'darkblue';
                              }else{
                                $contents_fiber = '강함';
                                $contents_fiber_style = 'red';
                              }
                              echo "<td style='color:$contents_fiber_style !important; border-right: solid 1px;'>$contents_fiber</td>";
                              echo "</tr>";
                          }
                          }
                          echo '</tbody>';
                          echo '</table>';
                          echo '</div>';
                        echo '</div>';
                      echo '</div>';
                    echo '</div>';
                  echo '</div>';
                echo'</div>';
                }
								}
                if(isset($_POST['stx'])){
                  $keword = $_POST['stx'];
                  $keword = preg_replace("/\s+/", "", $keword);
                echo '<div class="col-xl-8 col-lg-7" id="relation_keys">';
                  echo '<div class="card shadow mb-4">';
                    echo '<!-- Card Header - Dropdown -->';
                    echo '<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">';
                      echo '<h6 class="m-0 font-weight-bold text-primary">하루 검색량 분석</h6>';
                    echo '</div>';
                    echo '<!-- Card Body -->';
                    echo '<div class="card-body">';
                      echo '<div class="chart-area">';
							  // 네이버 데이터랩 통합검색어 트렌드 Open API 예제
							  $client_id_day = "vTXbYVv2Tq4JSO2xMs02"; // 네이버 개발자센터에서 발급받은 CLIENT ID
							  $client_secret_day = "iNSNnJ2RYu";// 네이버 개발자센터에서 발급받은 CLIENT SECRET
							  $url = "https://openapi.naver.com/v1/datalab/search";
							  date_default_timezone_set('Asia/Seoul');
							  $timestamp = strtotime("-1 days");
							  $today_ago = date("Y-m-d", $timestamp);
							  $onemonthago = strtotime("$today_ago -1 months");
							  $onemonthago_1 = date("Y-m-d", $onemonthago);
							  $body = "{\"startDate\":\"$onemonthago_1\",\"endDate\":\"$today_ago\",\"timeUnit\":\"date\",\"keywordGroups\":[{\"groupName\":\"$keword\",\"keywords\":[\"$keword\"]}]}";
							  $ch = curl_init();
							  curl_setopt($ch, CURLOPT_URL, $url);
							  curl_setopt($ch, CURLOPT_POST, true);
							  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							  $headers = array();
							  $headers[] = "X-Naver-Client-Id: ".$client_id_day;
							  $headers[] = "X-Naver-Client-Secret: ".$client_secret_day;
							  $headers[] = "Content-Type: application/json";
							  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
							  // SSL 이슈가 있을 경우, 아래 코드 주석 해제
							  // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
							  curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
							  $response = curl_exec ($ch);
							  $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
							  curl_close ($ch);
							  $yummy = json_decode($response, true);
							  $ratio_data = ($yummy['results'][0]['data']);
							  $ratio_array = [];
							  $period_array = [];
							  foreach($ratio_data as $value)
							  {
							    // echo $value['period'];
							    $dates = explode("-",(string)$value['period']);
							    array_shift($dates);
							    $want_date = implode(".",$dates);
							    array_push($period_array, $want_date);
							    array_push($ratio_array, $value['ratio']);
							  }
								$ratio_sum = round(array_sum($ratio_array),-1);
								$ratio_average = $pc_mobile_search/$ratio_sum;
								$ratio_arrays = [];
								foreach($ratio_array as $value)
							  {
									$ratio_search_count = round($value*$ratio_average,-1);
									array_push($ratio_arrays,$ratio_search_count);
								}
                        echo '<canvas id="month_search_chart"></canvas>';
                      echo '</div>';
                    echo '</div>';
                  echo '</div>';
                echo '</div>';
              }
              if(isset($_POST['stx'])){
                $keword = $_POST['stx'];
                $keword = preg_replace("/\s+/", "", $keword);
                echo '<div class="col-xl-8 col-lg-7">';
                  echo '<div class="card shadow mb-4">';
                    echo '<!-- Card Header - Dropdown -->';
                    echo '<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">';
                      echo '<h6 class="m-0 font-weight-bold text-primary">월간 검색량 분석</h6>';
                    echo '</div>';
                    echo '<!-- Card Body -->';
                    echo '<div class="card-body">';
                      echo '<div class="chart-area">';
                      $client_id_month = "2ppHOz5C4VuiewatQDnm"; // 네이버 개발자센터에서 발급받은 CLIENT ID
      							  $client_secret_month = "EaUBxVvxLm";// 네이버 개발자센터에서 발급받은 CLIENT SECRET
      							  $url = "https://openapi.naver.com/v1/datalab/search";
      							  date_default_timezone_set('Asia/Seoul');
      							  $timestamp = strtotime("-1 month");
      							  $onemonth_ago = date("Y-m-d", $timestamp);
      							  $oneyearsago = strtotime("$today_ago -1 year");
      							  $oneyearsago_1 = date("Y-m-d", $oneyearsago);
      							  $body_y = "{\"startDate\":\"$oneyearsago_1\",\"endDate\":\"$onemonth_ago\",\"timeUnit\":\"month\",\"keywordGroups\":[{\"groupName\":\"$keword\",\"keywords\":[\"$keword\"]}]}";
      							  $ch = curl_init();
      							  curl_setopt($ch, CURLOPT_URL, $url);
      							  curl_setopt($ch, CURLOPT_POST, true);
      							  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      							  $headers = array();
      							  $headers[] = "X-Naver-Client-Id: ".$client_id_month;
      							  $headers[] = "X-Naver-Client-Secret: ".$client_secret_month;
      							  $headers[] = "Content-Type: application/json";
      							  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      							  // SSL 이슈가 있을 경우, 아래 코드 주석 해제
      							  // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      							  curl_setopt($ch, CURLOPT_POSTFIELDS, $body_y);
      							  $response = curl_exec ($ch);
      							  $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      							  curl_close ($ch);
      							  $yummy = json_decode($response, true);
      							  $ratio_data = ($yummy['results'][0]['data']);
      							  $ratio_array = [];
      							  $period_array_y = [];
      							  foreach($ratio_data as $value)
      							  {
      							    // echo $value['period'];
      							    $dates = explode("-",(string)$value['period']);
      									$dates = array_diff($dates, array(end($dates)));
      							    $want_date = implode(".",$dates);
      							    array_push($period_array_y, $want_date);
      							    array_push($ratio_array, $value['ratio']);
      							  }
      								$all_search = 100*$pc_mobile_search/round(end($ratio_array),1);
      								$ratio_arrays_y = [];
      								foreach($ratio_array as $value)
      							  {
      									$ratio_search_count = round($value*$all_search/100,-2);
      									array_push($ratio_arrays_y,$ratio_search_count);
      								}
                      echo '<canvas id="yearChart"></canvas>';
                      echo '</div>';
                    echo '</div>';
                  echo '</div>';
                echo '</div>';
              }
              if(isset($_POST['stx'])){
                $keword = $_POST['stx'];
                $keword = preg_replace("/\s+/", "", $keword);
                $client_id_pc = "u6MAX4bSsW1Ta51SCdVJ"; // 네이버 개발자센터에서 발급받은 CLIENT ID
							  $client_secret_pc = "a3Pht12ytT";// 네이버 개발자센터에서 발급받은 CLIENT SECRET
							  $url = "https://openapi.naver.com/v1/datalab/search";
							  date_default_timezone_set('Asia/Seoul');
							  $timestamp = strtotime("-1 days");
							  $today_ago = date("Y-m-d", $timestamp);
							  $body = "{\"startDate\":\"2016-01-01\",\"endDate\":\"$today_ago\",\"timeUnit\":\"month\",\"keywordGroups\":[{\"groupName\":\"$keword\",\"keywords\":[\"$keword\"]}],\"device\":\"pc\"}";
							  $ch = curl_init();
							  curl_setopt($ch, CURLOPT_URL, $url);
							  curl_setopt($ch, CURLOPT_POST, true);
							  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							  $headers = array();
							  $headers[] = "X-Naver-Client-Id: ".$client_id_pc;
							  $headers[] = "X-Naver-Client-Secret: ".$client_secret_pc;
							  $headers[] = "Content-Type: application/json";
							  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
							  // SSL 이슈가 있을 경우, 아래 코드 주석 해제
							  // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
							  curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
							  $response = curl_exec ($ch);
							  $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
							  curl_close ($ch);
							  $yummy = json_decode($response, true);
							  $ratio_data = ($yummy['results'][0]['data']);
							  $ratio_array = [];
							  foreach($ratio_data as $value)
							  {
							    array_push($ratio_array, $value['ratio']);
							  }
								$ratio_sum_pc = round(array_sum($ratio_array),-1);
              }
              if(isset($_POST['stx'])){
                $keword = $_POST['stx'];
                $keword = preg_replace("/\s+/", "", $keword);
                $client_id_pm = "ix2YY5HsjiON1y5hgrYs"; // 네이버 개발자센터에서 발급받은 CLIENT ID
							  $client_secret_pm = "1FXs_pSG3e";// 네이버 개발자센터에서 발급받은 CLIENT SECRET
							  $url = "https://openapi.naver.com/v1/datalab/search";
							  date_default_timezone_set('Asia/Seoul');
							  $timestamp = strtotime("-1 days");
							  $today_ago = date("Y-m-d", $timestamp);
							  $body = "{\"startDate\":\"2016-01-01\",\"endDate\":\"$today_ago\",\"timeUnit\":\"month\",\"keywordGroups\":[{\"groupName\":\"$keword\",\"keywords\":[\"$keword\"]}],\"device\":\"mo\"}";
							  $ch = curl_init();
							  curl_setopt($ch, CURLOPT_URL, $url);
							  curl_setopt($ch, CURLOPT_POST, true);
							  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							  $headers = array();
							  $headers[] = "X-Naver-Client-Id: ".$client_id_pm;
							  $headers[] = "X-Naver-Client-Secret: ".$client_secret_pm;
							  $headers[] = "Content-Type: application/json";
							  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
							  // SSL 이슈가 있을 경우, 아래 코드 주석 해제
							  // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
							  curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
							  $response = curl_exec ($ch);
							  $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
							  curl_close ($ch);
							  $yummy = json_decode($response, true);
							  $ratio_data = ($yummy['results'][0]['data']);
							  $ratio_array = [];
							  foreach($ratio_data as $value)
							  {
							    array_push($ratio_array, $value['ratio']);
							  }
								$ratio_sum = round(array_sum($ratio_array),-1);
              }
              if(isset($_POST['stx'])){
                $pc_rate = round(($ratio_sum_pc/($ratio_sum_pc+$ratio_sum))*100,1);
                $mobile_rate = 100-$pc_rate;
                $pc_mobile_chart = [];
                array_push($pc_mobile_chart, $mobile_rate);
                array_push($pc_mobile_chart, $pc_rate);
                echo '<div class="col-xl-4 col-lg-5">';
                  echo '<div class="card shadow mb-4" id="chart_key_l">';
                    echo '<!-- Card Header - Dropdown -->';
                    echo '<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">';
                      echo '<h6 class="m-0 font-weight-bold text-primary">키워드 검색 범위 비율</h6>';
                    echo '</div>';
                    echo '<!-- Card Body -->';
                    echo '<div class="card-body">';
                      echo '<div class="chart-pie pt-4 pb-2">';
                        echo '<canvas id="myPieChart"></canvas>';
                      echo '</div>';
                      echo '<div class="mt-4 text-center small">';
                        echo '<span class="mr-2">';
                          echo '<i class="fas fa-circle text-primary"></i> PC';
                        echo '</span>';
                        echo '<span class="mr-2">';
                          echo '<i class="fas fa-circle text-success"></i> MOBILE';
                        echo '</span>';
                      echo '</div>';
                    echo '</div>';
                  echo '</div>';
              }
              if(isset($_POST['stx'])){
                $keword = $_POST['stx'];
                $keword = preg_replace("/\s+/", "", $keword);
                $client_id_gen = "PTeap5M8YIdLjDa09z_g"; // 네이버 개발자센터에서 발급받은 CLIENT ID
							  $client_secret_gen = "3IvPay9mc6";// 네이버 개발자센터에서 발급받은 CLIENT SECRET
							  $url = "https://openapi.naver.com/v1/datalab/search";
							  date_default_timezone_set('Asia/Seoul');
							  $timestamp = strtotime("-1 days");
							  $today_ago = date("Y-m-d", $timestamp);
							  $body = "{\"startDate\":\"2016-01-01\",\"endDate\":\"$today_ago\",\"timeUnit\":\"month\",\"keywordGroups\":[{\"groupName\":\"$keword\",\"keywords\":[\"$keword\"]}],\"gender\":\"f\"}";
							  $ch = curl_init();
							  curl_setopt($ch, CURLOPT_URL, $url);
							  curl_setopt($ch, CURLOPT_POST, true);
							  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							  $headers = array();
							  $headers[] = "X-Naver-Client-Id: ".$client_id_gen;
							  $headers[] = "X-Naver-Client-Secret: ".$client_secret_gen;
							  $headers[] = "Content-Type: application/json";
							  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
							  // SSL 이슈가 있을 경우, 아래 코드 주석 해제
							  // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
							  curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
							  $response = curl_exec ($ch);
							  $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
							  curl_close ($ch);
							  $yummy = json_decode($response, true);
							  $ratio_data = ($yummy['results'][0]['data']);
							  $ratio_array = [];
							  foreach($ratio_data as $value)
							  {
							    array_push($ratio_array, $value['ratio']);
							  }
								$ratio_sum_f = round(array_sum($ratio_array),-1);
              }
              if(isset($_POST['stx'])){
                $keword = $_POST['stx'];
                $keword = preg_replace("/\s+/", "", $keword);
                $client_id_gen2 = "MHf_tiluoCGEdfXYPAqS"; // 네이버 개발자센터에서 발급받은 CLIENT ID
							  $client_secret_gen2 = "uQjq8Nzxbg";// 네이버 개발자센터에서 발급받은 CLIENT SECRET
							  $url = "https://openapi.naver.com/v1/datalab/search";
							  date_default_timezone_set('Asia/Seoul');
							  $timestamp = strtotime("-1 days");
							  $today_ago = date("Y-m-d", $timestamp);
							  $body = "{\"startDate\":\"2016-01-01\",\"endDate\":\"$today_ago\",\"timeUnit\":\"month\",\"keywordGroups\":[{\"groupName\":\"$keword\",\"keywords\":[\"$keword\"]}],\"gender\":\"m\"}";
							  $ch = curl_init();
							  curl_setopt($ch, CURLOPT_URL, $url);
							  curl_setopt($ch, CURLOPT_POST, true);
							  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							  $headers = array();
							  $headers[] = "X-Naver-Client-Id: ".$client_id_gen2;
							  $headers[] = "X-Naver-Client-Secret: ".$client_secret_gen2;
							  $headers[] = "Content-Type: application/json";
							  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
							  // SSL 이슈가 있을 경우, 아래 코드 주석 해제
							  // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
							  curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
							  $response = curl_exec ($ch);
							  $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
							  curl_close ($ch);
							  $yummy = json_decode($response, true);
							  $ratio_data = ($yummy['results'][0]['data']);
							  $ratio_array = [];
							  foreach($ratio_data as $value)
							  {
							    array_push($ratio_array, $value['ratio']);
							  }
								$ratio_sum_m = round(array_sum($ratio_array),-1);
              }
              if(isset($_POST['stx'])){
                $sex_rate_f = round(($ratio_sum_f/($ratio_sum_f+$ratio_sum_m))*100,1);
                $sex_rate_m = 100-$sex_rate_f;
                $sex_rate_chart = [];
                array_push($sex_rate_chart, $sex_rate_f);
                array_push($sex_rate_chart, $sex_rate_m);
                  echo '<div class="card shadow mb-4" id="chart_key_r">';
                    echo '<!-- Card Header - Dropdown -->';
                    echo '<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">';
                      echo '<h6 class="m-0 font-weight-bold text-primary">키워드 검색 성별 비율</h6>';
                    echo '</div>';
                    echo '<!-- Card Body -->';
                    echo '<div class="card-body">';
                      echo '<div class="chart-pie pt-4 pb-2">';
                        echo '<canvas id="gender"></canvas>';
                      echo '</div>';
                      echo '<div class="mt-4 text-center small">';
                        echo '<span class="mr-2">';
                          echo '<i class="fas fa-circle text-primary"></i> 남성';
                        echo '</span>';
                        echo '<span class="mr-2">';
                          echo '<i class="fas fa-circle text-success"></i> 여성';
                        echo '</span>';
                      echo '</div>';
                    echo '</div>';
                  echo '</div>';
                echo '</div>';
              }
            }
             ?>
             <script>
						 var ratio_array = <?php echo json_encode($ratio_arrays) ?>;
						 var period_array = <?php echo json_encode($period_array) ?>;
             var ratio_array_y = <?php echo json_encode($ratio_arrays_y) ?>;
						 var period_array_y = <?php echo json_encode($period_array_y) ?>;
             var pc_mobile_array = <?php echo json_encode($pc_mobile_chart) ?>;
             var f_m_array = <?php echo json_encode($sex_rate_chart) ?>;
						 </script>
          <!-- Content Row -->
          <div class="row">
            <!-- Area Chart -->
            <!-- Pie Chart -->
          </div>
        </div>
        <!-- /.container-fluid -->

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>

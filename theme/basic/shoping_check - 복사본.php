<?php
session_start();
echo $_SESSION["id"];
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/shoping_check.php');
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
// if(empty($_POST['stx'])){
//   echo "";
// }else{
// }if(isset($_POST['stx'])){
//   echo '<section class="section section--menu" id="Antonio">';
//     echo '<nav class="menu menu--antonio">';
//       echo '<ul class="menu__list">';
//         echo '<li class="menu__item menu__item--current"><a href="#main_key" class="menu__link">키워드 기본정보</a></li>';
//         echo '<li class="menu__item"><a href="#" class="menu__link">트렌드 리포트</a></li>';
//         echo '<li class="menu__item"><a href="#relation_keys" class="menu__link">연관 키워드</a></li>';
//         echo '<li class="menu__item"><a href="#" class="menu__link">키워드 섹션 분석</a></li>';
//         // echo '<li class="menu__item"><a href="#" class="menu__link">Contact</a></li>';
//       echo '</ul>';
//     echo '</nav>';
//   echo '</section>';
// }
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
  <div id='containers'>
    <div class="container">
			<section class="content_bgcolor-4" id="main_key">
				<span class="input input--madoka">
          <form method="post" action="<?php echo G5_URL; ?>/shoping_check.php" id="next">
            <table>
              <td style="width:100%; padding: 0;"><input class="input__field input__field--madoka" type="text" name="stx" id="input-31" />
    					<label class="input__label input__label--madoka" for="input-31">
    						<svg class="graphic graphic--madoka" width="100%" height="100%" viewBox="0 0 404 77" preserveAspectRatio="none">
    							<path d="m0,0l404,0l0,77l-404,0l0,-77z"/>
    						</svg>
    						<span class="input__label-content input__label-content--madoka">상품 키워드를 입력해 주세요.</span>
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
              if(isset($_POST['stx'])){
                if ($member[mb_point] < 20){
                  alert("포인트가 부족합니다..");
                }else{
                  if ($member['mb_level'] <= 5){
                    echo "";
                  }else{
                    insert_point($member[mb_id], -20, "$board[bo_subject] $wr_id 포스팅 분석", $bo_table, $wr_id, $g5['time_ymdhis']);
                  }
                }
                $keword = $_POST['stx'];
                $keword = preg_replace("/\s+/", "", $keword);
                include_once 'simple_html_dom.php';
                function shoping_check($url) {
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
                $sell_names = [];
                $sell_counts = [];
                $sell_searchs = [];
                  $kewords = URLEncode($keword);
                  $urls = ((string)'https://search.shopping.naver.com/search/all?query='.$kewords.'&cat_id=&frm=NVSHATC');
                  $str = shoping_check($urls);
                  $enc = mb_detect_encoding($str, array('EUC-KR', 'UTF-8', 'shift_jis', 'CN-GB'));
                  if ($enc != 'UTF-8') {
                      $str = iconv($enc, 'UTF-8', $str);
                  }
                  // Create a DOM object
                  $html = new simple_html_dom();
                  // Load HTML from a string
                  $html->load($str);
                  array_push($sell_names,$keword);
                  $all_sell = $html->find('a[class=subFilter_filter__3Y-uy] span');
                  $sell_counte = $all_sell[0]->plaintext;
                  array_push($sell_counts,$sell_counte);
                  function sell_kewords($keword){
                    while(1){
                      $search_list = [];
   									  ini_set("default_socket_timeout", 30);
   									  require_once('restapi.php');

   									  $config = parse_ini_file("sample.ini");
   									  // print_r($config);

   									  $DEBUG = false;
   									  $api = new RestApi($config['BASE_URL'], $config['API_KEY'], $config['SECRET_KEY'], $config['CUSTOMER_ID']);
   									  $data = array(
   									    "hintKeywords" => $keword,
   									    "showDetail" => "1"
   									  );
						          $keywordList = $api->GET('/keywordstool',$data);
					             $monthlypc = ($keywordList["keywordList"][0]["monthlyPcQcCnt"]);
                       if((string)$monthlypc == '0'){
                        echo "";
                      }else{
                        if(strpos($monthlypc,'<') !== false){
  												$monthlypc = '10';
  											}
  									    $monthlymobile = ($keywordList["keywordList"][0]["monthlyMobileQcCnt"]);
 												if(strpos($monthlymobile,'<') !== false){
 													$monthlymobile = '10';
 												}
                        array_push($search_list,$monthlypc);
                        array_push($search_list,$monthlymobile);
                        $main_arr = (int)$monthlypc+(int)$monthlymobile;
                        array_push($search_list,$main_arr);
                        break;
                      }
                    }
   									  return $search_list;
   									}
                  $sell_search_counte = sell_kewords($keword);
                  array_push($sell_searchs,$sell_search_counte);
                  $arr_result = $html->find('div[class=relatedTags_relation_srh__1CleC] ul li');
                  if(count($arr_result) > 0){
                    foreach($arr_result as $e){
                      $relations_keyword = $e->plaintext;
                      array_push($sell_names,$relations_keyword);
                      $relations_keywords = URLEncode($relations_keyword);
                      $relations_urls = ((string)'https://search.shopping.naver.com/search/all?query='.$relations_keywords.'&cat_id=&frm=NVSHATC');
                      $str = shoping_check($relations_urls);
                      $enc = mb_detect_encoding($str, array('EUC-KR', 'UTF-8', 'shift_jis', 'CN-GB'));
                      if ($enc != 'UTF-8') {
                          $str = iconv($enc, 'UTF-8', $str);
                      }
                      // Create a DOM object
                      $html = new simple_html_dom();
                      // Load HTML from a string
                      $html->load($str);
                      $all_sell = $html->find('a[class=subFilter_filter__3Y-uy] span');
                      $sell_count = $all_sell[0]->plaintext;
                      array_push($sell_counts,$sell_count);
                      while(1){
                        $relations_search_count = sell_kewords($relations_keyword);
                        if($relations_search_count == 0){
                          echo "";
                        }else{
                          break;
                        }
                      }
                      array_push($sell_searchs,$relations_search_count);
                    }
                  } else { echo ""; }
                  echo '<div class="col-xl-3 col-md-6 mb-4">';
                    echo '<div class="card border-left-successf shadow h-100 py-2">';
                    echo '<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">';
                    echo '<h6 class="m-0 font-weight-bold text-primary" style="color: #1cc88a !important;">연관 키워드 분석</h6>';
                  echo '</div>';
                      echo '<div class="card-body">';
                        echo '<div class="row no-gutters align-items">';
                          echo '<div class="col mr-2">';
                          echo '<table class="relation_table" id="relation_keys">';
                          echo '<thead style="background-color:lightgoldenrodyellow;">';
                          echo '<tr>';
                          echo '<th style= "border-right: solid 1px; border-left: solid 1px;"><button onclick="sortTD ( 0 )"><i class="fas fa-chevron-up"></i></button>쇼핑 키워드<button onclick="reverseTD ( 0 )"><i class="fas fa-chevron-down"></i></button></th>';
                          echo '<th style= "border-right: solid 1px; border-left: solid 1px;"><button onclick="sortTD ( 1 )"><i class="fas fa-chevron-up"></i></button>월간 검색량(PC)<button onclick="reverseTD ( 1 )"><i class="fas fa-chevron-down"></i></button></th>';
                          echo '<th style= "border-right: solid 1px; border-left: solid 1px;"><button onclick="sortTD ( 2 )"><i class="fas fa-chevron-up"></i></button>월간 검색량(Mobile)<button onclick="reverseTD ( 2 )"><i class="fas fa-chevron-down"></i></button></th>';
                          echo '<th style= "border-right: solid 1px; border-left: solid 1px;"><button onclick="sortTD ( 3 )"><i class="fas fa-chevron-up"></i></button>월간 검색량(종합)<button onclick="reverseTD ( 3 )"><i class="fas fa-chevron-down"></i></button></th>';
                          echo '<th style= "border-right: solid 1px; border-left: solid 1px;"><button onclick="sortTD ( 4 )"><i class="fas fa-chevron-up"></i></button>상품 판매량<button onclick="reverseTD ( 4 )"><i class="fas fa-chevron-down"></i></button></th>';
                          echo '<th style= "border-right: solid 1px; border-left: solid 1px;"><button onclick="sortTD ( 5 )"><i class="fas fa-chevron-up"></i></button>상품 비율<button onclick="reverseTD ( 5 )"><i class="fas fa-chevron-down"></i></button></th>';
                          echo '</tr>';
                          echo '</thead>';
                          echo '<tbody>';
                          $sell_number = 0;
                          foreach ($sell_names as $sel_val) {
                            echo "<tr>";
                            echo "<td style='border-right:solid 1px; border-left:solid 1px;'>";?> <?php echo $sel_val; ?> <?php echo "</td>";
                            echo "<td style='border-right:solid 1px; border-left:solid 1px;'>";?> <?php echo number_format((int)$sell_searchs[$sell_number][0]); ?> <?php echo "</td>";
                            echo "<td style='border-right:solid 1px; border-left:solid 1px;'>";?> <?php echo number_format((int)$sell_searchs[$sell_number][1]); ?> <?php echo "</td>";
                            echo "<td style='border-right:solid 1px; border-left:solid 1px;'>";?> <?php echo number_format((int)$sell_searchs[$sell_number][2]); ?> <?php echo "</td>";
                            echo "<td style='border-right:solid 1px; border-left:solid 1px;'>";?> <?php echo $sell_counts[$sell_number]; ?> <?php echo "</td>";
                            $sell_se = str_replace(",","",$sell_searchs[$sell_number][2]);
                            $sell_co = str_replace(",","",$sell_counts[$sell_number]);
                            echo "<td style='border-right:solid 1px; border-left:solid 1px;'>";?><?php echo number_format(round(((int)$sell_co/(int)$sell_se)*100,0)); ?><?php echo "%</td>";
                            echo "</tr>";
                            $sell_number++;
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
             ?>
           </div>
        </div>
        <!-- /.container-fluid -->

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>

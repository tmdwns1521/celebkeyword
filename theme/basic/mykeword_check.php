<?php
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/mykeword_check.php');
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
          <form method="post" action="<?php echo G5_URL; ?>/mykeword_check.php" id="next">
            <table>
              <td style="width:100%; padding: 0;"><input class="input__field input__field--madoka" type="text" name="stx" id="input-31" />
    					<label class="input__label input__label--madoka" for="input-31">
    						<svg class="graphic graphic--madoka" width="100%" height="100%" viewBox="0 0 404 77" preserveAspectRatio="none">
    							<path d="m0,0l404,0l0,77l-404,0l0,-77z"/>
    						</svg>
    						<span class="input__label-content input__label-content--madoka">키워드를 입력해 주세요.</span>
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
                if ($member[mb_point] < 20){
                  alert("포인트가 부족합니다..");
                }else{
                  insert_point($member[mb_id], -50, "$board[bo_subject] $wr_id MY 키워드 분석", $bo_table, $wr_id, $g5['time_ymdhis']);
                }
              }
              if(isset($_POST['stx'])){
                $keword = $_POST['stx'];
                $kewords = preg_replace("/\s+/", "", $keword);
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
                function visitor($ids){
                  $url = 'https://blog.naver.com/NVisitorgp4Ajax.nhn?blogId='.$ids;
                  $ch = cURL_init();
                  cURL_setopt($ch, CURLOPT_URL, $url);
                  cURL_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                  $response = cURL_exec($ch);
                  cURL_close($ch);
                  $object = simplexml_load_string($response);
                  $suggest2 = $object->visitorcnt[1]['cnt'];
                  $suggest3 = $object->visitorcnt[2]['cnt'];
                  $suggest4 = $object->visitorcnt[3]['cnt'];
                  $cnt_all = ceil(((int)$suggest2+(int)$suggest3+(int)$suggest4)/3);
                  return $cnt_all;
              }
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
                function insert_array($arr, $idx, $add){

                	$arr_front = array_slice($arr, 0, $idx); //처음부터 해당 인덱스까지 자름

                	$arr_end = array_slice($arr, $idx); //해당인덱스 부터 마지막까지 자름

                	$arr_front[] = $add;//새 값 추가

                	return array_merge($arr_front, $arr_end);

                }
                $keword = urlencode($keword);
                $save_url = ((string)"https://search.naver.com/search.naver?where=view&sm=tab_jum&query=".(string)$keword);
                $save_str = file_get_contents_curl($save_url);
                $enc = mb_detect_encoding($save_str, array('EUC-KR', 'UTF-8', 'shift_jis', 'CN-GB'));
                if ($enc != 'UTF-8') {
                    $save_str = iconv($enc, 'UTF-8', $save_str);
                }
                // Create a DOM object
                $html = new simple_html_dom();
                // Load HTML from a string
                $html->load($save_str);
                $blog_url = [];
                $title_list = [];
                $img_list = [];
                $video_list = [];
                $writer_num = [];
                $kewors_count = [];
                $kewords_date = [];
                $arr_date = $html->find('span.sub_time');
                if(count($arr_date) > 0){
                  foreach ($arr_date as $et) {
                    $section_date = $et->plaintext;
                    array_push($kewords_date,$section_date);
                  }
                }
                $arr_result = $html->find('a.api_txt_lines.total_tit');
                if(count($arr_result) > 0){ //위의 이미지에서 a 태그에 포함되는 html dom 객체를 가져옴
                  $ke_date = 0;
                  foreach($arr_result as $e){
                    $section_name = $e->href;
                    $section_title = $e->plaintext;
                    array_push($title_list,$section_title);
                    $section_name = str_replace("?Redirect=Log&logNo=","/",$section_name);
                    if (strpos($section_name, 'cafe.naver.com') !== false){
                      array_push($blog_url,'cafe');
                      array_push($img_list,'카페');
                      array_push($video_list,'카페');
                      array_push($writer_num,'카페');
                      array_push($kewors_count,'카페');
                    }elseif(strpos($section_name, 'post.naver.com') !== false){
                      array_push($blog_url,'post');
                      array_push($img_list,'포스트');
                      array_push($video_list,'포스트');
                      array_push($writer_num,'포스트');
                      array_push($kewors_count,'포스트');
                    }elseif(strpos($section_name, 'blog.daum.net') !== false){
                      array_push($blog_url,'daum');
                      array_push($img_list,'다음');
                      array_push($video_list,'다음');
                      array_push($writer_num,'다음');
                      array_push($kewors_count,'다음');
                    }elseif(strpos($section_name, 'adcr.naver.com') !== false){
                      array_push($blog_url,'ad');
                      array_push($img_list,'광고');
                      array_push($video_list,'광고');
                      array_push($writer_num,'광고');
                      array_push($kewors_count,'광고');
                      array_splice($kewords_date, $ke_date, 0, '광고');
                    }
                    else{
                      $blog_id = explode("/",$section_name)[3];
                      array_push($blog_url,$blog_id);
                      $m_linked = str_replace("//","//m.",$section_name);
                      $m_strs = file_get_contents_curl($m_linked);
                      $enc = mb_detect_encoding($m_strs, array('EUC-KR', 'UTF-8', 'shift_jis', 'CN-GB'));
                      if ($enc != 'UTF-8') {
                          $m_strs = iconv($enc, 'UTF-8', $m_strs);
                      }
                      // Create a DOM object
                      $htmls = new simple_html_dom();
                      // Load HTML from a string
                      $htmls->load($m_strs);
                      $arr_img = $htmls->find('img[class="se-image-resource"]');
                      if(count($arr_img) > 0){ //위의 이미지에서 a 태그에 포함되는 html dom 객체를 가져옴
                        $img_count = count($arr_img);
                        array_push($img_list,$img_count);
                      }else{
                        $arr_img = $htmls->find('span._img');
                        if(count($arr_img) > 0){ //위의 이미지에서 a 태그에 포함되는 html dom 객체를 가져옴
                          $img_count = count($arr_img);
                          array_push($img_list,$img_count);
                        }else{
                          $img_count = 0;
                          array_push($img_list,$img_count);
                        }
                      }
                      $arr_video = $htmls->find('div[class="se-module se-module-video"]');
                      if(count($arr_video) > 0){ //위의 이미지에서 a 태그에 포함되는 html dom 객체를 가져옴
                        $video_count = count($arr_video);
                        array_push($video_list,$video_count);
                      }else{
                        $arr_video = $htmls->find('span._naverVideo');
                        if(count($arr_video) > 0){ //위의 이미지에서 a 태그에 포함되는 html dom 객체를 가져옴
                          $video_count = count($arr_video);
                          array_push($video_list,$video_count);
                        }else{
                          $video_count = 0;
                          array_push($video_list,$video_count);
                        }
                      }
                      $arr_results = $htmls->find('p.se-text-paragraph');
                      $write_cou = 0;
                      $keword_counts = 0;
                      if(count($arr_results) > 0){
                        foreach($arr_results as $e){
                          $section_name = $e->plaintext;
                          $nbsp = html_entity_decode("&nbsp;");
                          $n8203 = html_entity_decode("&#8203;");
                          $section_names = str_replace($nbsp, "", $section_name);
                          $section_names = str_replace($n8203, "", $section_names);
                          $section_names = preg_replace('/\s| /','',$section_names);
                          $keword_in_count = substr_count($section_names,$kewords);
                          $keword_counts = $keword_counts + $keword_in_count;
                          $write_count = mb_strlen($section_names);
                          $write_cou = $write_cou + $write_count;
                        }
                        array_push($writer_num,$write_cou);
                        array_push($kewors_count,$keword_counts);
                      }else{
                        $arr_results = $htmls->find('div[id="viewTypeSelector"]');
                        if(count($arr_results) > 0){ //위의 이미지에서 a 태그에 포함되는 html dom 객체를 가져옴
                          $section_name = $arr_results[0]->plaintext;
                          $nbsp = html_entity_decode("&nbsp;");
                          $n8203 = html_entity_decode("&#8203;");
                          $section_names = str_replace($nbsp, "", $section_name);
                          $section_names = str_replace($n8203, "", $section_names);
                          $section_names = preg_replace('/\s| /','',$section_names);
                          $keword_in_count = substr_count($section_names,$kewords);
                          $keword_counts = $keword_counts + $keword_in_count;
                          $write_count = mb_strlen($section_names);
                          $write_cou = $write_cou + $write_count;
                          array_push($writer_num,$write_cou);
                          array_push($kewors_count,$keword_counts);
                      }else{
                        $write_count = 0;
                        array_push($writer_num,$write_count);
                      }
                    }
                    }
                    $ke_date++;
                  }
                }
                $description = $html->find('div.api_txt_lines.dsc_txt');
                $des_num = 1;
                $des_list = [];
                if(count($description) > 0){
                  foreach($description as $e){
                    $section_des = $e->plaintext;
                    array_push($des_list,$section_des);
                    if (count($blog_url) == $des_num){
                      break;
                    }
                    $des_num++;
                  }
                }
                    echo '<div class="col-xl-3 col-md-6 mb-4">';
                      echo '<div class="card border-left-successf shadow h-100 py-2">';
                      echo '<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">';
                      echo '<h6 class="m-0 font-weight-bold text-primary" style="color: black !important;">MY 키워드</h6>';
                    echo '</div>';
                        echo '<div class="card-body">';
                          echo '<div class="row no-gutters align-items">';
                            echo '<div class="col mr-2">';
                            echo '<table class="relation_table" id="relation_keys">';
                            echo '<thead style="background-color: lightgoldenrodyellow;">';
                            echo '<tr>';
                            echo '<th style= "border-right: solid 1px; border-left: solid 1px; ">순위</th>';
                            echo '<th style= "border-right: solid 1px; border-left: solid 1px; ">포스팅 제목</th>';
                            echo '<th style= "border-right: solid 1px; border-left: solid 1px; ">Description</th>';
                            echo '<th style= "border-right: solid 1px; border-left: solid 1px;  width:3%;">이미지 갯수</th>';
                            echo '<th style= "border-right: solid 1px; border-left: solid 1px; ">동영상 갯수</th>';
                            echo '<th style= "border-right: solid 1px; border-left: solid 1px; ">포스팅 글자수</th>';
                            echo '<th style= "border-right: solid 1px; border-left: solid 1px;  width:5%;">검색 키워드';?><?php echo "</br>"; ?><?php echo '포함 횟수</th>';
                            echo '<th style= "border-right: solid 1px; border-left: solid 1px;  ">포스팅 날짜';?><?php echo "</br></th>";
                            echo '<th style= "border-right: solid 1px; border-left: solid 1px;  width: 6%;">최근 3일간';?><?php echo '</br>'; ?><?php echo'평균';?><?php echo '</br>'; ?><?php echo'방문자수</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            $ranking = 0;
                            foreach ($blog_url as $key) {
                              echo '<tr>';
                              echo '<td style="border-right:solid 1px;">';?><?php echo $ranking+1; ?><?php '</td>';
                              echo '<td style="border-right:solid 1px;">';?><?php echo $title_list[$ranking]; ?><?php '</td>';
                              echo '<td style="border-right:solid 1px;">';?><?php echo $des_list[$ranking]; ?><?php '</td>';
                              echo '<td style="border-right:solid 1px;">';?><?php echo $img_list[$ranking]; ?><?php '</td>';
                              echo '<td style="border-right:solid 1px;">';?><?php echo $video_list[$ranking]; ?><?php '</td>';
                              echo '<td style="border-right:solid 1px;">';?><?php echo $writer_num[$ranking]; ?><?php '</td>';
                              echo '<td style="border-right:solid 1px;">';?><?php echo $kewors_count[$ranking]; ?><?php '</td>';
                              echo '<td style="border-right:solid 1px;">';?><?php echo $kewords_date[$ranking]; ?><?php '</td>';
                              if ('cafe' == $key){
                                echo '<td>';?><?php echo '카페'; ?><?php '</td>';
                              }elseif ('post' == $key){
                                echo '<td>';?><?php echo '포스트'; ?><?php '</td>';
                              }elseif ('daum' == $key){
                                echo '<td>';?><?php echo '다음'; ?><?php '</td>';
                              }elseif ('ad' == $key){
                                echo '<td>';?><?php echo '광고'; ?><?php '</td>';
                              }else{
                                echo '<td>';?><?php echo visitor($key); ?><?php '</td>';
                              }
                              echo '</tr>';
                              $ranking++;
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

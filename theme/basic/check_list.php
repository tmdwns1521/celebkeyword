<?php
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/check_list.php');
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
  alert("회원가입을 해주세요.", G5_BBS_URL."/login.php?url=".urlencode(G5_URL."/posting_check.php"));
}
if ($member['mb_level'] <= 3){
  alert("LV4 부터 이용이 가능합니다. 톡 상담 문의시 레벨업 가능합니다.", G5_BBS_URL."/board.php?bo_table=free");
}
  // ini_set("memory_limit" , -1);
  // error_reporting(0);
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
      $('#posting_ch').hide();
      $('#loading').show();
      return true;
    });
  });
  </script>
  <div id='containers'>
    <div class="container">
			<section class="content_bgcolor-4" id="main_key">
        <div class="posting_checklist" id="posting_ch">
          <table style="width: 45.8%; text-align: center;">
            <tr style="background-color:  white;">
              <td style="padding: 3%; border: solid 2px; font-size:small;"><a href="<?php echo G5_URL; ?>/posting_check.php">순차적 분석</a></td>
              <td style="padding: 3%; border: solid 2px; font-size:small;"><a href="<?php echo G5_URL; ?>/check_list.php">페이지 분석</a></td>
            </tr>
          </table>
        </div>
				<span class="input input--madoka">
          <form method="post" action="<?php echo G5_URL; ?>/check_list.php" id="next">
            <table>
              <td style="width:100%; padding: 0;"><input class="input__field input__field--madoka" type="text" name="stx" id="input-31" />
    					<label class="input__label input__label--madoka" for="input-31">
    						<svg class="graphic graphic--madoka" width="100%" height="100%" viewBox="0 0 404 77" preserveAspectRatio="none">
    							<path d="m0,0l404,0l0,77l-404,0l0,-77z"/>
    						</svg>
    						<span class="input__label-content input__label-content--madoka">블로그 아이디를 입력해 주세요.</span>
    					</label></td>
              <td><div class="input-group-append" style="height: 51px;">
                <button type="submit" id="sch_submit" value="검색" class="btn btn-primary"><i class="fas fa-search fa-sm"></i></button>
              </div></td>
            </table>
            <div class="page_check" style="padding-top:5%;">
              <td><input type="text" name="first_page" placeholder="첫 페이지" style="text-align:center; width:47%;"></td>
              <td>~</td>
              <td><input type="text" name="last_page" placeholder="마지막 페이지" style="text-align:center; width:47%;"></td>
            </div>
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
                $keword = $_POST['stx'];
                $fistpage = $_POST['first_page'];
                $lastpage = $_POST['last_page'];
                $keword = preg_replace("/\s+/", "", $keword);
                include_once 'simple_html_dom.php';
                function blog_file_check($url) {
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
                  echo '<div class="col-xl-3 col-md-6 mb-4">';
                    echo '<div class="card border-left-warning shadow h-100 py-2">';
                    echo '<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">';
                    echo '<h6 class="m-0 font-weight-bold text-primary" style="color:gray !important;">블로그 포스팅 분석</h6>';
                  echo '</div>';
                      echo '<div class="card-body">';
                        echo '<div id="relation_keyword" class="row no-gutters align-items-center">';
                          echo '<div class="scroll_con">';
                          echo '<table style="width:100%; height:600px; font-size: x-large;" id="products" border="1">';
                          echo '<form action="" id=""></form>';
                          echo '<thead><tr style="border-bottom: solid 1px;"><td>번호</td><td>포스팅 제목</td><td>포스팅 시간</td><td>포스팅 글자수</td><td>포스팅 노출</td><td>이미지 노출</td><td>분석 키워드</td><td>VIEW 노출</td><td>블로그 노출</td><td>#태그 분석</td></tr></thead>';
                          echo '<tbody>';
                          $lo_num = 0;
                          $log_arrays = [];
                          $t_arrays = [];
                          $t_zero_arrays = [];
                          $dt_arrays = [];
                          $blog_array = True;
                          $number = (int)$fistpage;
                          $url = ((string)'https://blog.naver.com/PostTitleListAsync.nhn?blogId='.($keword).'&viewdate=&currentPage='.(string)$number.'&categoryNo=&parentCategoryNo=&countPerPage=30');
                          $str = blog_file_check($url);
                          while (1){
                            if ($number == ((int)$lastpage+1)){
                              break;
                            }else{
                              $url = ((string)'https://blog.naver.com/PostTitleListAsync.nhn?blogId='.($keword).'&viewdate=&currentPage='.(string)$number.'&categoryNo=&parentCategoryNo=&countPerPage=30');
                              $str = blog_file_check($url);
                              $enc = mb_detect_encoding($str, array('EUC-KR', 'UTF-8', 'shift_jis', 'CN-GB'));
                              if ($enc != 'UTF-8') {
                                  $str = iconv($enc, 'UTF-8', $str);
                              }
                              if(strpos($str, '비공개') !== false) {
                                echo '<div class="posting_error">비공개 처리된 블로그 입니다.</div>';
                                break;
                              }
                              // log번호 크롤링
                              if(strpos($str, '일시적') !== false) {
                                echo '<div class="posting_error">포스팅이 존재 하지 않습니다.</div>';
                                break;
                              }
                              $blog_json = explode('&logNo=',$str);
                              array_shift($blog_json);
                              foreach($blog_json as $value){
                                $values = str_replace('"}','',$value);
                                if(in_array($values,$log_arrays)){
                                  $blog_array = False;
                                  break;
                                }else{
                                  $values = str_replace(" ","",$values);
                                  array_push($log_arrays,$values);
                                }
                              }
                              if($blog_array == False){
                                break;
                              }else{
                                $title_json = explode('"title":',$str);
                                array_shift($title_json);
                                foreach($title_json as $t_va){
                                  $t_va = explode(',',$t_va);
                                  $ti_va = str_replace('"','',$t_va[0]);
                                  array_push($t_zero_arrays,$ti_va);
                                  $ti_vas =  urldecode($ti_va);
                                  array_push($t_arrays,$ti_vas);
                                }
                                $date_json = explode('"addDate":',$str);
                                array_shift($date_json);
                                foreach($date_json as $dt_va){
                                  $dt_va = explode(',',$dt_va);
                                  $dt_va = str_replace('"','',$dt_va[0]);
                                  $dt_vas =  urldecode($dt_va);
                                  array_push($dt_arrays,$dt_vas);
                                }
                              }
                            }
                            $number++;
                          }
                            foreach($log_arrays as $logs){
                                $logs = str_replace(" ","",$logs);
                                echo '<tr>';
                                echo '<td>'; ?> <?php echo $lo_num+1; ?> <?php echo '</td>';
                                $linked = ((string)'https://blog.naver.com/'.(string)$keword.'/'.(string)$logs);
                                $m_linked = ((string)'https://m.blog.naver.com/'.(string)$keword.'/'.(string)$logs);
                                $m_strs = file_get_contents_curl($m_linked);
                                $enc = mb_detect_encoding($m_strs, array('EUC-KR', 'UTF-8', 'shift_jis', 'CN-GB'));
                                if ($enc != 'UTF-8') {
                                    $m_strs = iconv($enc, 'UTF-8', $m_strs);
                                }
                                // Create a DOM object
                                $html = new simple_html_dom();
                                // Load HTML from a string
                                $html->load($m_strs);
                                $tag_post = $html->find('div[class="post_tag"]');
                                if(count($tag_post) > 0){
                                  foreach($tag_post as $f){
                                    $tag_name = $f->plaintext;
                                  }
                                }else{
                                  $tag_name = '';
                                }
                                $arr_results = $html->find('div[id="viewTypeSelector"]');
                                if(count($arr_results) > 0){ //위의 이미지에서 a 태그에 포함되는 html dom 객체를 가져옴
                                  foreach($arr_results as $e){
                                    $section_name = $e->plaintext;
                                    $section_names = preg_replace("/\s+/", "", $section_name);
                                    $write_num = mb_strlen($section_names);
                                  }
                                }else{
                                  $arr_results = $html->find('div[class="se-main-container"]');
                                  if(count($arr_results) > 0){
                                    foreach($arr_results as $e){
                                      $section_name = $e->plaintext;
                                      $section_names = preg_replace("/\s+/", "", $section_name);
                                      $write_num = mb_strlen($section_names);
                                    }
                                  }else{
                                    $write_num = 0;
                                  }
                                }
                                $arr_img = $html->find('img[class="se-image-resource"]');
                                if(count($arr_img) > 0){ //위의 이미지에서 a 태그에 포함되는 html dom 객체를 가져옴
                                  $img_count = count($arr_img);
                                }else{
                                  $arr_img = $html->find('span._img');
                                  if(count($arr_img) > 0){ //위의 이미지에서 a 태그에 포함되는 html dom 객체를 가져옴
                                    $img_count = count($arr_img);
                                  }else{
                                    $img_count = 0;
                                  }
                                }
                                // 제목 등수 검색
                                $titles = $t_zero_arrays[$lo_num];
                                $titles = str_replace("%26lt%3B","<",$titles);
                                $titles = str_replace("%26gt%3B",">",$titles);
                                $titles = str_replace('%26quot%3B','"',$titles);
                                $save_url = ((string)"https://search.naver.com/search.naver?query=".(string)$titles."&nso=&where=blog&sm=tab_viw.all");
                                $save_str = file_get_contents_curl($save_url);
                                $enc = mb_detect_encoding($save_str, array('EUC-KR', 'UTF-8', 'shift_jis', 'CN-GB'));
                                if ($enc != 'UTF-8') {
                                  $save_str = iconv($enc, 'UTF-8', $save_str);
                                }
                                // Create a DOM object
                                $html = new simple_html_dom();
                                // Load HTML from a string
                                $html->load($save_str);
                                $arr_result = $html->find('a.api_txt_lines');
                                $blog_url = [];
                                if(count($arr_result) > 0){ //위의 이미지에서 a 태그에 포함되는 html dom 객체를 가져옴
                                  foreach($arr_result as $e){
                                    $section_name=$e->href;
                                    $section_name = str_replace("?Redirect=Log&logNo=","/",$section_name);
                                    array_push($blog_url,$section_name);
                                    // echo '';
                                    }
                                  }
                                  if(in_array($linked,$blog_url)){
                                    $title_rank = array_search($linked,$blog_url)+1;
                                  }else{
                                    $title_rank = 'X';
                                  }
                                $title = $t_arrays[$lo_num];
                                if(mb_strlen($title) > 25){
                                  $my_titles = mb_substr($title,0,25,"utf-8")."...";
                                }else{
                                  $my_titles = $title;
                                }
                                $kewordsd = URLEncode($title);
                                $urle = ('https://s.search.naver.com/p/c/image/search.naver?where=image&rev=43&section=blog&query=%22'.$kewordsd.'%22&ac=0&aq=0&spq=0&nx_search_query='.$kewordsd.'&nx_and_query=%22'.$kewordsd.'%22&nx_sub_query=&nx_search_hlquery=%22'.$kewordsd.'%22&nx_search_fasquery=&res_fr=0&res_to=0&color=&datetype=0&startdate=0&enddate=0&nso=so%3Ar%2Ca%3Aall%2Cp%3Aall&json_type=6&nlu_query=&nqx_theme=&gif=0&optStr=&ccl=0&nq=&dq=&tq=&x_image=&display=100&start=1&_callback=jQuery1124018276932879859342_1613368164631&_=1613368164632');
                                $str = blog_file_check($urle);
                                $enc = mb_detect_encoding($str, array('EUC-KR', 'UTF-8', 'shift_jis', 'CN-GB'));
                                if ($enc != 'UTF-8') {
                                    $str = iconv($enc, 'UTF-8', $str);
                                }
                                $imgs_str = urldecode($str);
                                $imgs_lists = explode('"saslink":"',$imgs_str);
                                array_shift($imgs_lists);
                                $img_real_count = 0;
                                foreach($imgs_lists as $imgs_co){
                                  if(strpos($imgs_co, $keword) !== false){
                                    $img_real_count += 1;
                                  }
                                  else{
                                    break;
                                  }
                                }
                                if ($img_real_count == 0){
                                  $img_rates = 0;
                                }else{
                                  if($img_count == 0){
                                    $img_rates = 0;
                                  }else{
                                    $img_rates = round(($img_real_count/$img_count)*100);
                                    if($img_rates > 100){
                                      $img_rates = 100;
                                    }
                                  }
                                }
                                echo '<td>'; ?><?php echo $my_titles; ?><?php echo '</td>';
                                echo '<td>'; ?><?php echo $dt_arrays[$lo_num]; ?> <?php echo '</td>';
                                echo '<td>'; ?><?php echo $write_num; ?> <?php echo '</td>';
                                echo '<td><a href="';?> <?php echo $save_url; ?><?php echo '" target="_blank">'; ?><?php echo trim($title_rank); ?><?php echo '</a></td>';
                                echo '<td>';?><?php echo $img_rates; ?><?php echo '%</td>';
                                echo '<td>';?> <?php echo '<form id=';?><?php echo $lo_num; ?><?php echo ' onsubmit="return false"><input type="hidden" name="se_url" value="';?><?php echo $linked; ?><?php echo '"><input type="text" name="se_key" style="width: 70%;"> <input type="button" onclick="add(';?><?php echo trim($lo_num); ?><?php echo ')" value="검색"></button> </form>'; ?><?php echo '</td>';
                                echo '<td><div class="';?><?php echo $lo_num; ?><?php echo '"></div></td>';
                                echo '<td><div id="';?><?php echo $lo_num; ?><?php echo "_"; ?><?php echo $lo_num; ?><?php echo '"></div></td>';
                                if($tag_name == ''){
                                  echo '<td><div></div></td>';
                                }else{
                                  echo "<td><form action='popup.php' method='post' target='popup'"; ?><?php echo 'onsubmit="window.open(';?><?php echo "'popup.php', 'popup', 'width=1690, height=600'";?><?php echo ');">';?> <?php echo "<input type='hidden' name='var' value='";?><?php echo $tag_name; ?><?php echo "'>
                                  <input type='hidden' name='var2' value='";?><?php echo $linked; ?><?php echo "'>
                                  <input type='submit' value='분석'>
                                  </form>"; ?><?php echo '</td>';
                                  echo '</tr>';
                                }
                                $lo_num++;
                            }
                            echo '</tbody>';
                          echo '</table>';
                        echo '</div>';
                      echo '</div>';
                    echo '</div>';
                  echo '</div>';
              }
            }
             ?>
             <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
             <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
             <script>
             	function add(count) {
             		var ken = '#'+count;
                var kens = '.'+count;
                var kenss = '#'+count+'_'+count;
             		$.ajax({
             			url: "http://celebkeyword.com/theme/basic/ra.php",
             			type: "post",
                  dataType:'json',
             			data: $(ken).serialize(),
             			error : function(){
                     alert('통신실패!!');
                   },
             			success : function(data){
                    var tc = data;
                   $(kens).html(tc[0]);
                   $(kenss).html(tc[1]);
                         }
             		});
             	}
              </script>
          <!-- Content Row -->
        </div>
      </div>
      </div>
      <?php
      include_once(G5_THEME_PATH.'/tail.php');
      ?>
      </div>
        <!-- /.container-fluid -->

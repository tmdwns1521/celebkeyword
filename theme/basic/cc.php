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
    <div class="container">
			<section class="content_bgcolor-4" id="main_key">
				<span class="input input--madoka">
          <form method="post" action="<?php echo G5_URL; ?>/keyword_check.php">
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
                $url = "https://search.naver.com/search.naver?query=%EC%B2%9C%EC%95%88%ED%95%98%EC%88%98%EA%B5%AC%20%EB%B3%80%EA%B8%B0%EA%B0%80%20%EC%8B%9C%EC%9B%90%ED%95%98%EA%B2%8C%20%EC%95%88%20%EB%82%B4%EB%A0%A4%EA%B0%80&nso=&where=blog&sm=tab_viw.all";
                $str = file_get_contents_curl($url);
                $enc = mb_detect_encoding($str, array('EUC-KR', 'UTF-8', 'shift_jis', 'CN-GB'));
                if ($enc != 'UTF-8') {
                    $str = iconv($enc, 'UTF-8', $str);
                }
                // Create a DOM object
                $html = new simple_html_dom();
                echo $html;
                // Load HTML from a string
                // $html->load($str);
                // $arr_result = $html->find('div.main_pack>div,section');
                // $section_tap = True;
                // $already_section = [];
                // $section_lists = [];
                // if(count($arr_result) > 0){ //위의 이미지에서 a 태그에 포함되는 html dom 객체를 가져옴
                //   foreach($arr_result as $e){
                //     if($section_tap==False){
                //       break;
                //     }
                //     $section_name =  $e->plaintext;
                //     $se_name = explode(' ', $section_name );
                //   }
                // } else { echo ""; }
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

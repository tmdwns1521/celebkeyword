<?php
ini_set("memory_limit" , -1);
error_reporting(0);
?>
<?php
  $number = $_POST['data1'];
  $keword = $_POST['data2'];
  $lo_nums = (int)$_POST['data3'];
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
    $lo_num = 0;
      $log_arrays = [];
      $t_arrays = [];
      $t_zero_arrays = [];
      $dt_arrays = [];
      $blog_array = True;
      $url = ((string)'https://blog.naver.com/PostTitleListAsync.nhn?blogId='.($keword).'&viewdate=&currentPage='.(string)$number.'&categoryNo=&parentCategoryNo=&countPerPage=30');
      $str = blog_file_check($url);
      while (1){
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
        // $number++;
        break;
      }
      $all_list = [];
        foreach($log_arrays as $logs){
            $logs = str_replace(" ","",$logs);
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
            $kewordsd = URLEncode($my_titles);
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
              $img_rates = round(($img_real_count/$img_count)*100);
              if($img_rates > 100){
                $img_rates = 100;
              }
            }
            $key_li = [];
            array_push($key_li,$lo_nums+1);
            array_push($key_li,$my_titles);
            array_push($key_li,$dt_arrays[$lo_num]);
            array_push($key_li,$write_num);
            $posting_nochul = (string)'<a href='.$save_url.'target="_balnk">'.trim($title_rank).'</a>';
            array_push($key_li,$posting_nochul);
            array_push($key_li,$img_rates.'%');
            $search_key = '<form id="'.$lo_nums.'" onsubmit="return false"><input type="hidden" name="se_url" value="'.$linked.'"><input type="text" name="se_key" style="width: 70%;"><input type="button" onclick="add('.$lo_nums.')" value="검색"></button></form>';
            array_push($key_li,$search_key);
            $pc_search_box = '<div class="'.$lo_nums.'_'.$lo_nums.'"></div>';
            array_push($key_li,$pc_search_box);
            $mobile_search_box = '<div class="'.$lo_nums.'_'.$lo_nums.'_'.$lo_nums.'"></div>';
            array_push($key_li,$mobile_search_box);
            $search_box = '<div class="'.$lo_nums.'"></div>';
            array_push($key_li,$search_box);
            $search_box2 = '<div id="'.$lo_nums.'_'.$lo_nums.'"></div>';
            array_push($key_li,$search_box2);
            if($tag_name == ''){
              $tag_search = '<div></div>';
              array_push($key_li,$tag_search);
            }else{
              $tag_sarch2 = '<form action="popup.php" method="post" target="popup" onsubmit="window.open('."'popup.php','popup','width=1690, height=600'".');"><input type="hidden" name="var" value="'.$tag_name.'"><input type="hidden" name="var2" value="'.$linked.'"><input type="submit" value="분석"></form>';
              array_push($key_li,$tag_sarch2);
            }
            array_push($all_list,$key_li);
            $lo_num++;
            $lo_nums++;
  }
  echo json_encode($all_list, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
?>

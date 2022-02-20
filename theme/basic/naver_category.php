
<?
// $connect = mysql_connect("db.tmdwns1155.gabia.io","tmdwns1155","tmdwns5458@");
//
// mysql_select_db("dbtmdwns1155",$connect); // 연결할 db선택
//
// if(!$connect){
// 	die("연결에 실패했습니다.".mysql_error());//실패하면 연결중지
// }


header("Content-Type:text/html;charset=utf-8");
?>

<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<div class="container">
	<section class="content_bgcolor-4" id="main_key">
		<span class="input input--madoka">
      <form method="post" action="" id="next">
        <table style="padding-left: 30%;">
          <td style="padding: 0;"><input class="input__field input__field--madoka" Placeholder = '키워드' type="text" name="stx" id="input1" / style="font-size: xx-large;"></td>
          <td style="padding: 0;"><input class="input__field input__field--madoka" Placeholder = '지도번호' type="text2" name="stx2" id="input2" / style="font-size: xx-large;"></td>
          <td>
            <button style="height: 45px;" type="button" id="sch_submit" value='행추가' onclick='addRow()' class="btn btn-primary">검색</button>
        </td>
        </table>
      </form>
		</span>
	</section>
</div><!-- /container -->
<table id='fruits' border="1" style="width: 100%; text-align: center; font-size: xx-large;">
  <tr><td>키워드</td><td>지도링크</td><td>지도등수</td></tr>
</table>
<script type="text/javascript">
  function addRow() {
    var keyword = document.getElementById('input1').value;
    var code = document.getElementById('input2').value;

		$.ajax({
      url: "https://gboard.zmffls.site/theme/basic/naver_map_search.php",
      type: "post",
      dataType:'json',
      data: {data1:keyword,data2:code},
			beforeSend: function() {
				//마우스 커서를 로딩 중 커서로 변경
				$('html').css("cursor", "wait");
			},
			complete: function() {
				//마우스 커서를 원래대로 돌린다
				$('html').css("cursor", "auto");
			},
      error:function(request, status, error){
         alert("status : " + request.status + ", message : " + request.responseText + ", error : " + error);
       },
      success : function(data){
				// table element 찾기
		    const table = document.getElementById('fruits');

		    // 새 행(Row) 추가
		    const newRow = table.insertRow();

		    // 새 행(Row)에 Cell 추가
		    const newCell1 = newRow.insertCell(0);
		    const newCell2 = newRow.insertCell(1);
		    const newCell3 = newRow.insertCell(2);

		    // Cell에 텍스트 추가
		    newCell1.innerText = keyword;
		    newCell2.innerText = code;
		    newCell3.innerText = data;
      }
    });

  }
</script>

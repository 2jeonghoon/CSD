<?php
    header('Content_Type: text/html; charset=UTF-8');
    include 'WriteLog.php';
    $message = "";
    log_write("메인 화면 접속");
?>
<html>
	<head>
		<script type="text/javascript">
			function showMessage( message )
			{
				if ( ( message != null ) && ( message != "" ) && ( message.substring( 0, 3 ) == " * " )  ) 
				{
					alert( message );
				}
			}     
			// 지정한 url로 이동하는 함수 
			function move( url )	
			{
				document.formm.action = url;
				document.formm.submit();
			}
		</script>
                <style>
                   
                </style>
		<meta charset="utf-8"/>
		<title>Epula v0.1 - 식당 리스트</title>
                <link rel="stylesheet" href="style.css">
	</head>
<body onLoad="showMessage( '<?php echo $_POST['message'];?>' );">
	<!--메뉴바--!>
        <nav class="menubar">
	   <ul class="menu">
	     <li><a href="MapMain.php"><h1 class="logo">Epula</h1></a></li>
           </ul>
           <ul class="mydata">
	     <li>내정보(로그인 기능 구현예정)</li>
           </ul>
        </nav> 

        <!--검색창--!>
	<section>
          <div id="searchbox">
	    <h2>오늘 뭐 먹지?</h2>
	    <form name="formm" method="post">
	      <input type="text" id="search" name="query" placeholder="검색어를 입력해주세요">
              <input type="image" id="searchicon" onClick="javascript:move('./add.php')"; src="image/search_icon.png" alt="검색버튼">
	    </form>               
	  </div>
	</section>

        <!--맛집 나열창--!>
        <section>
         <div id="storebox">
          <input type="button" value="식당 제거하기" onClick="javascript:move( './delete.php' );">
          <br>
           <?php
	   // MySQL 드라이버 연결
	   include './SQLconstants.php';
	   $conn = mysqli_connect($mySQL_host, $mySQL_id, $mySQL_password, $mySQL_database) or die ("Cannot access DB");
	   
	   // 전달 받은 메시지 확인
	   $message = $_POST['message'];
	   $message = ( ( ( $message == null) || ( $message == "" ) ) ? "_%" : $message );
	   
	   // MySQL 검색 실행 및 결과 출력
	   $query = "select * from Restaurants";
	   $result = mysqli_query($conn, $query);
	   $cnt = 0;
	   while($row = mysqli_fetch_array($result)){
	       if($cnt>=2)
	       {
	      	   echo "<br>";
		   $cnt =0;
	       }
               echo "<div id='store' style ='display: inline-block'><BR><BR>";
	       echo "<BR><img src = '".$row['picture']."' height='280' width='180'>";
	       echo "<BR> ID : ".$row['restaurant_id'];
	       echo "<BR> 식당 이름 : ".$row['name'];
	       echo "<BR> 메뉴 : ".$row['menu'];
	       echo "<BR> 주소 : ".$row['address'];
	       echo "<BR> 전화번호 : ".$row['phone'];
	       echo "<BR> 영업 시간 : ".$row['opening_hour'];
	       echo "<BR> 배달 : ".$row['delivery'];
	       echo "<BR> 포장 : ".$row['take_out'];
	       echo "<BR> 태그 : ".$row['tag'];
	       echo "<BR><BR></div>";
	       $cnt++;

	   }
	   
	   // MySQL 드라이버 연결 해제
	   mysqli_free_result( $result );
	   mysqli_close( $conn );
?>
       </div>
       </section>  
</body>

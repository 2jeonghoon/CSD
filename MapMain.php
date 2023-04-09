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
		<meta charset="utf-8"/>
		<title>Epula v0.1 - 식당 리스트</title>
	</head>
<body onLoad="showMessage( '<?php echo $_POST['message'];?>' );">
	<form name="formm" method="post">
	</form>
	<input type="button" value="식당 추가하기" onClick="javascript:move( './add.php' );">
	<input type="button" value="식당 제거하기" onClick="javascript:move( './delete.php' );">
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
	   while($row = mysqli_fetch_array($result)){
	       echo "<BR><BR>";
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
	       echo "<BR><BR>";
	   }
	   
	   // MySQL 드라이버 연결 해제
	   mysqli_free_result( $result );
	   mysqli_close( $conn );
	?>
</body>

<?php
    header('Content_Type: text/html; charset=UTF-8');
    include 'WriteLog.php';
    log_write("제거 화면 접속");
?>
<html>
	<head>
		<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=fb0a0c82d5ee027226705463fd6c4ed6&libraries=services"></script>
		<style>
			.search {
				position: relative;
				width: 300px;
			}

			input {
				width: 100%;
				border: 1px solid #bbb;
				border-radius: 8px;
				padding: 10px 12px;
				font-size: 14px;
			}

			img #searchicon {
				position: absolute;
				width: 17px;
				top: 10px;
				right: 12px;
				margin: 0;
			}
		</style>
		<title>Epula v0.1 - 식당삭제</title>
                <link rel="stylesheet" href="style.css">
	</head>
	<body>
	<!--메뉴바--!>
        <nav class="menubar">
	   <ul class="menu">
	     <li><a href="MapMain.php"><h1 class="logo">Epula</h1></a></li>
           </ul>
           <ul class="mydata">
	     <li>내정보(로그인 기능 구현예정)</li>
           </ul>
	</nav>

        <section>
          <div id="searchbox" style="height: auto;">
		<div id="map" style="width:400px;height:300px;"></div>
		<div class="search">
		<input style="display: inline-block;"type="text" id="val" placeholder="장소 입력" onkeypress="Enter()">
		<img id="searchicon" src="https://s3.ap-northeast-2.amazonaws.com/cdn.wecode.co.kr/icon/search.png" onmousedown="printPlace()">
		<br>
		<!-- 화면 구성 -->
		<form name = "formm" method = "post" action = "./deleteSQL.php">

			&nbsp; &nbsp; &nbsp;
			삭제할 식당 ID : <INPUT TYPE = "text" id = "id" NAME = "id" SIZE="60">
		</form>
		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

		<INPUT TYPE = "button" value = "삭제" onClick="javascript:document.formm.submit();"> &nbsp;
		<BR><BR>
	
		</div>
	   </div>
         </section>
		<script>	
			var mapContainer = document.getElementById("map");
			var options = {
				center: new kakao.maps.LatLng(37.602322, 126.955350),
				level: 3
                        };

			var map = new kakao.maps.Map(mapContainer, options);
			var markers = [];

			marker = new kakao.maps.Marker({
    			map: map,
    	    	position: new kakao.maps.LatLng(37.6023222243288, 126.955350026719)
    		});
    		marker.setMap(map);
    		markers.push(marker);
			
			var callback = function(result, status) {
				if(status === kakao.maps.services.Status.OK) {
					hideMarkers();
					marker = new kakao.maps.Marker({
				   		map: map,
				   		position: new kakao.maps.LatLng(result[0].y, result[0].x)
				   	});
				   	map.setCenter(new kakao.maps.LatLng(result[0].y, result[0].x));
					marker.setMap(map);
					markers.push(marker);
					document.getElementById('id').value = result[0]['id'];
					document.getElementById('name').value = result[0]['place_name'];
					document.getElementById('address').value = result[0]['address_name'];
					document.getElementById('pn').value = result[0]['phone'];
				}
			};
				
			function setMarkers(map) {
				   for (var i = 0; i < markers.length; i++) {
				   	markers[i].setMap(map);
				   }
			}

			function hideMarkers() {
				   setMarkers(null);
			}

			var places = new kakao.maps.services.Places(map);

			function printPlace() {
				   places.keywordSearch(document.getElementById('val').value, callback, 'FD6');
			}

			function Enter() {
				   if(event.keyCode == 13) {
				   	printPlace();
				   }
			}
		</script>

              <section>
               <div id="storebox">
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
	     </div>
            </section>
	</body>
</html>

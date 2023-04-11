<?php
    header('Content_Type: text/html; charset=UTF-8');
    include 'WriteLog.php';
    log_write("추가 화면 접속");
    
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

			img {
  				position : absolute;
  				width: 17px;
  				top: 10px;
  				right: 12px;
  				margin: 0;
			}
		</style>
		<title>Epula v0.1 - 식당추가</title>
	        <link rel="stylesheet" href="style.css">
        </head>
	<body onload="printPlace()">
           <!--메뉴바--!>
           <nav class="menubar">
	     <ul class="menu">
	       <li><a href="MapMain.php"><h1 class="logo">Epula</h1></a></li>
             </ul>
             <ul class="mydata">
	       <li>내정보(로그인 기능 구현예정)</li>
             </ul>
          </nav> 
		<div id="map" style="width:400px;height:300px;"></div>
		<div class="search">
		<input type="text" id="val" placeholder="장소 입력" value="<?php if($_POST['query']) echo $_POST['query'];?>" onkeypress="Enter()">
		<img src="https://s3.ap-northeast-2.amazonaws.com/cdn.wecode.co.kr/icon/search.png" onmousedown="printPlace()">
		<form name = "formm" method = "post" action = "./addSQL.php">
			<br> I &nbsp; &nbsp; D &nbsp;:  <INPUT TYPE = "text" id = "id" NAME = "id" >
			<br> 이 &nbsp; 름 : <INPUT TYPE = "text" id = "name" NAME = "name" >
			<br> 메 &nbsp; 뉴 : <INPUT TYPE = "text" id = "menu" NAME = "menu" >
			<br> 주 &nbsp; 소 : <INPUT TYPE = "text" id = "address" NAME = "address" >
			<br> 전화번호 : <INPUT TYPE = "text" id = "pn" NAME = "pn" >
			<br> 영업시간 : <INPUT TYPE = "text" id = "time" NAME = "time" >
			<br> 배 &nbsp; 달 : <INPUT TYPE = "checkbox" id = "deliver" value="가능" NAME = "deliver" >
			<br> 포 &nbsp; 장 : <INPUT TYPE = "checkbox" id = "takeout" value="가능" NAME = "takeout" >
			<br> 이미지 : <INPUT TYPE = "text" id = "image" NAME = "image" >
			<br> 태 &nbsp; 그 : <INPUT TYPE = "text" id = "tag" NAME = "tag" >
		</form>
		<INPUT TYPE="button" value="등록" onClick="javascript:document.formm.submit();">
		<script>
			var map;
			var markers = [];
			
			kakao.maps.load(function() {
	    		var mapContainer = document.getElementById("map");
	    		
	    		var options = {
	        		center: new kakao.maps.LatLng(37.6023222243288, 126.955350026719),
					level: 3
	    		};
				
	    		kakao.maps.load(function() {
	        		map = new kakao.maps.Map(mapContainer, options);
	    		});	

	    		marker = new kakao.maps.Marker({
	    			map: map,
	    	    	position: new kakao.maps.LatLng(37.6023222243288, 126.955350026719)
	    		});
	    		marker.setMap(map);
	    		markers.push(marker);
			});
		
			var callback = function(result, status) {
		    	if (status === kakao.maps.services.Status.OK) {
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

			map.setDraggable(false);
		
			function setMarkers(map) {
		    	for (var i = 0; i < markers.length; i++) {
		        	markers[i].setMap(map);
		    	}            
			}
			
			function hideMarkers(){
				setMarkers(null);
			}
		
			var places = new kakao.maps.services.Places(map);
		
			function printPlace(){
				places.keywordSearch(document.getElementById('val').value, callback, 'FD6');
			}
		
			function Enter(){
				if(event.keyCode==13){
					printPlace();
				}
			}
		</script>
	</div>
	</body>
</html>

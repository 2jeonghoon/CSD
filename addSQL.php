<?php 
    header('Content-Type: text/html; charset=UTF-8');
    include("./SQLconstants.php");
    include("./WriteLog.php");
    
    $id = $_POST['id'];
    $name = $_POST['name'];
    $menu = $_POST['menu'];
    $address = $_POST['address'];
    $pn = $_POST['pn'];
    $time = $_POST['time'];
    $deliver = $_POST['deliver'];
    $takeout = $_POST['takeout'];
    $image = $_POST['id'];
    $tag = $_POST['tag'];
    $message = "";
    
    // MySQL 드라이버 연결
    $conn = mysqli_connect( $mySQL_host, $mySQL_id, $mySQL_password, $mySQL_database ) or die( "Can't access DB" );
    
    // MySQL 식당 추가 실행
    $query = "INSERT INTO Restaurants( restaurant_id, name, menu, address, phone, opening_hour, delivery, take_out, picture, tag ) VALUES ( '" .$id. "', '" .$name. "', '" .$menu. "', '" .$address. "', '" .$pn. "', '" .$time. "', '" .$deliver. "', '" .$takeout. "', '" .$image. "', '" .$tag. "');";
    $result = mysqli_query( $conn, $query );
    if(!$result){
        $message = "식당 (".$name.")을 등록했습니다.";
    }
    else{
        $message = "식당 (".$name.")을 등록하지 못했습니다.";
    }
    
    // MySQL 드라이버 연결 해제
    mysqli_free_result( $result );
    mysqli_close( $conn );
    log_write($message);
?>
<form name = "frm" method = "post" action = "./MapMain.php" >
	<input type = 'hidden' name = 'message' value = ' * <?php echo $message;?>' >
</form>
<script language="javascript">
	document.frm.submit();
</script>

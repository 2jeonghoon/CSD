<?php	// 참고 사이트 :  https://www.codingfactory.net/12195
header('Content-Type: text/html; charset=UTF-8');
include("./SQLconstants.php");
$username = $_POST[ 'username' ];
$password = $_POST[ 'password' ];
if ( !is_null( $username ) ) {
	$conn = mysqli_connect( $mySQL_host, $mySQL_id, $mySQL_password, $mySQL_database ) or die("Can't access DB");
	$stm = $conn->stmt_init();
	$stmt = $conn->prepare("SELECT passwd FROM Users WHERE user_id = ?");
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$result = $stmt->get_result();
	$db_password = null;
	if($row = $result->fetch_assoc()) {
		$db_password = $row['passwd'];
	}
	if(is_null($db_password)) {
		$wu = 1;
	} else {
		if($password == $db_password) {
			// login-ok.php로 이
			header('Location: MapMain.php');	
		} else {
			$wp = 1;
		}
	}
//	$query = "SELECT password FROM Users WHERE username = '" . $username . "';";
//	$result = mysqli_query( $conn, $query );
/*	while ( $jb_row = mysqli_fetch_array( $jb_result ) ) {
		$encrypted_password = $jb_row[ 'password' ];
	}
	if ( is_null( $encrypted_password ) ) {
		$wu = 1;
	} else {
		if ( password_verify( $password, $encrypted_password ) ) {
			header( 'Location: login-ok.php' );
		} else {
			$wp = 1;
		}
	}*/
}
?>
<!doctype html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <title>로그인</title>
    <style>
      body { font-family: sans-serif; font-size: 14px; }
      input, button { font-family: inherit; font-size: inherit; }
    </style>
  </head>
  <body>
    <h1>로그인</h1>
    <form action="login.php" method="POST">
      <p><input type="text" name="username" placeholder="사용자이름" required></p>
      <p><input type="password" name="password" placeholder="비밀번호" required></p>
      <p><input type="submit" value="로그인"></p>
<?php
if ( $wu == 1 ) {
	echo "<p>사용자이름이 존재하지 않습니다.</p>";
}
if ( $wp == 1 ) {
	echo "<p>비밀번호가 틀렸습니다.</p>";
}
?>
    </form>
	</body>
</html>

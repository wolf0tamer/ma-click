<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="styles.css">
		<title>Ma-click - just click!</title>
	</head>
	<body>
		<?php
			global $conn;
			echo "<div class=\"event_space\">";
			$login_question_button = $_POST['login_question_button'];
		 	if ($login_question_button == '')
		 	{
				echo "
						<form action=\"index.php\" method=\"post\">
							<div class='auth_question'>Are you here for the first time?</div>
						    <button type=\"submit\" name=\"login_question_button\" class=\"first_time_button\" value=\"YES\">YES</button>
						    <button type=\"submit\" name=\"login_question_button\" class=\"go_to_login_button\" value=\"NO\">NO</button>
					    </form>
				    ";
		 	}
		 	else if ($login_question_button == 'NEW USER') {
		 		# code... validate and creating a user
		 		$user_nickname = $_POST['nickname']; #CHECK FOR SQL-injections
		 		$conn = new PDO("pgsql:host=localhost;port=4321;dbname=other", "postgres");
		 		do
		 		{
		 			$permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
					$code =  substr(str_shuffle($permitted_chars), 0, 12);
					$check_credentials_query = "SELECT * FROM other.public.v_dim_user_account WHERE name='".$user_nickname."' AND code='".$code."';";
					$statement = $conn->prepare($check_credentials_query);
					$statement->execute();
					$row_count = $statement->rowCount();
				}
				while($row_count <> 0);
		 		$create_user_query = "INSERT INTO other.public.dim_user_account VALUES('".$user_nickname."', '".$code."', CURRENT_DATE, 0);";
		 		$statement = $conn->prepare($create_user_query);
				$statement->execute();
				if( $curl = curl_init() ) {
				    curl_setopt($curl, CURLOPT_URL, 'http://ma-click/index.php');
				    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
				    curl_setopt($curl, CURLOPT_POST, true);
				    curl_setopt($curl, CURLOPT_POSTFIELDS, "nickname=".$user_nickname."&code=".$code."&login_question_button=READY");
				    $out = curl_exec($curl);
				    echo $out;
				    curl_close($curl);
				}
		 	}
		 	else if ($login_question_button == 'READY') {
		 		$user_nickname = $_POST['nickname'];
		 		$user_code = $_POST['code'];
		 		echo "<h1>Your account actually created.<p>Nickname: ".$user_nickname."<p>Code: ".$user_code."</h1><p>Save this code for next authentication.<br>";
		 		echo "
						    <button type=\"submit\" name=\"login_question_button\" class=\"go_to_login_button\" value=\"LOGGED\">Enjoy</button>
				    ";
		 	}
		 	else if ($login_question_button == 'YES')
		 	{
		 		echo "<h1>Then come up with a Nickname</h1>
		 				<form action=\"index.php\" method=\"post\">
							<p>Nickname: <input type=\"text\" name=\"nickname\" /></p>
							<p><button type=\"submit\" name=\"login_question_button\" value=\"NEW USER\"/>I want to be called...</button></p>
						</form>";

		 	}
		 	else if ($login_question_button == 'NO')
		 	{
		 		$user_nickname = $_POST['nickname'];
				$user_code = $_POST['code'];
				if ($user_nickname == '' AND $user_code == '') 
				{
				    echo "
					    <form action=\"index.php\" method=\"post\">
							<p>Nickname: <input type=\"text\" name=\"nickname\" /></p>
							<p>Code: <input type=\"text\" name=\"code\" /></p>
							<p><button type=\"submit\" />Approve</button></p>
						</form>
				    ";
				} 
				else 
				{
				    echo "name:".$user_nickname."\ncode:".$user_code;
				}
		 	}
		 	echo "</div>";
		 ?>
			<!--<script type="text/javascript" file='/main/simple-game.js'></script>-->
	</body>
</html>
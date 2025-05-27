<?php
	if ( !isset($_GET['sucess']) && !isset($_GET['secret']) ){
		header('Location: /admin/index.php?page=clients');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Восстановление пароля</title>
	<style type="text/css">
		html, body {
			margin: 0;
			padding: 0;	
			height: 100%;		
		}
		p {
			margin: 0;
			padding: 10px 0;
		}
		body {
			display: flex;
			justify-content: center;
			align-items: center;
			color:#fff;
			background: #0f161e;
			height: 100%;
		}
		input, button {
			width: 100%;
			background: #1b2430;
			color: #fff;
			height: 70px;
			border: 1px solid #262f3a;
			border-radius: 6px;
			font:18px Arial, sans-serif;
			padding: 0 15px;
			box-sizing: border-box;
		}
		button {
			background: #2fa2fa;
			cursor: pointer;
			border: 0;
		}
		button:hover {
			background: #2b94e4;
		}
		.window {
			text-align: center;
			width: 100%;
			max-width: 500px;
			font-size: 24px;
			font-weight: 700;
			font-family: Arial, sans-serif;
			padding: 15px;
		}
	</style>
</head>
<body>
	<div class="window">
		<?php
	if ( isset($_GET['sucess']) ){
	    			echo 'Пароль изменен';
	} else if (!empty( $_GET['secret'] )){
		require_once($_SERVER['DOCUMENT_ROOT'].'/api/godfather.php'); 
		$godfather = new Godfather();
		$ztime = time()-60*30;
		$secret = $godfather->prepare_var($_GET['secret']);
		$query = "SELECT * FROM `categories` WHERE pass_change='$secret' AND pass_time>$ztime LIMIT 1 ";
    	$cont = $godfather->db->result($query);

    	if ( !empty($_POST['email']) && !empty($_POST['pass']) && !empty($_POST['change']) && !empty($cont) ){
    		$user_email = $godfather->prepare_var($_POST['email']);
    		$user_pass = $godfather->prepare_var($_POST['pass']);
    		if ($user_email==$cont[0]->user_email){
    			
    				$user_pass = password_hash($user_pass, PASSWORD_BCRYPT);
    				$page_arr = array(	
						'user_pass' => $user_pass,
						'pass_change' => '',
						'pass_time' => '0',
					);					
				
				$godfather->categories->update_category($cont[0]->id,$page_arr);
				header('Location: password_recovery.php?sucess');
    		}
    	} else {
	    	if (empty($cont)){
	    			echo 'Ссылка не работает!';		
	    	} else {
	    		?>
			<form action="" method="post">
				<p>Восстановление пароля</p>
				<p><input type="email" name="email" placeholder="введите email" required="введите email"></p>
				<p><input type="password" name="pass" placeholder="введите новый пароль" required="введите пароль"></p>
				<p><button type="submit" name="change" value="1">Изменить</button></p>
			</form>
	<?php
	    	}
    	}

	}
?>
	</div>
</body>
</html>


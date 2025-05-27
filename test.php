<?php
	//$host = 'http://noble.gensol.ru';
	$host = '';
?>
<style type="text/css">
	div {
		margin-right: 20px;
	}
	input, select, textarea {
		min-width: 155px;
	}
</style>




<div style="display: flex;">
	<div>
<h3>Клуб -> получение списка</h3>
<form action="<?=$host?>/query/clients.php" method="post"  target="_blank" enctype="multipart/form-data">
	<table border="1">
		<tr>
			<td>user_email</td>
			<td><input type="text" value="vov4ik.san@gmail.com" name="user_email" ></td>
		</tr>
		<tr>
			<td>user_pass</td>
			<td><input type="text" value="2222" name="user_pass" ></td>
		</tr>
		<tr>
			<td>api_key</td>
			<td><input type="text" value="1111" name="api_key" ></td>
		</tr>
		<tr>
			<td>api_event</td>
			<td><input type="text" value="club_get" name="api_event"  > 
	</td>
		</tr>
		<tr>
			<td>device_id</td>
			<td><input type="text" value="1a2b3c" name="device_id"  > 
	</td>
		</tr>
	</table>
	 <button type="submit">ok</button>
</form>
</div>
<div>
<h3>Клуб -> логаут</h3>
<form action="<?=$host?>/query/clients.php" method="post"  target="_blank" enctype="multipart/form-data">
	<table border="1">
		<tr>
			<td>user_email</td>
			<td><input type="text" value="vov4ik.san@gmail.com" name="user_email" ></td>
		</tr>
		<tr>
			<td>user_pass</td>
			<td><input type="text" value="2222" name="user_pass" ></td>
		</tr>
		<tr>
			<td>api_key</td>
			<td><input type="text" value="1111" name="api_key" ></td>
		</tr>
		<tr>
			<td>api_event</td>
			<td><input type="text" value="club_exit" name="api_event"  > 
	</td>
		</tr>
		
		</tr>
	</table>
	 <button type="submit">ok</button>
</form>
</div>
<div>
<h3>Клуб -> восстановление пароля </h3>
<form action="<?=$host?>/query/clients.php" method="post"  target="_blank" enctype="multipart/form-data">
	<table border="1">
		<tr>
			<td>user_email</td>
			<td><input type="text" value="vov4ik.san@gmail.com" name="user_email" ></td>
		</tr>
		
		<tr>
			<td>api_key</td>
			<td><input type="text" value="1111" name="api_key" ></td>
		</tr>
		<tr>
			<td>api_event</td>
			<td><input type="text" value="club_password_recovery" name="api_event"  > 
	</td>
		</tr>
	</table>
	 <button type="submit">ok</button>
</form>
</div>
</div>

<h1>Клиент</h1>

<div style="display: flex;">
	<div>
<h3>Клиент -> добавление</h3>

<form action="<?=$host?>/query/clients.php" method="post"  target="_blank" enctype="multipart/form-data">
	<table border="1">
		<tr>
			<td>user_email</td>
			<td><input type="text" value="vov4ik.san@gmail.com" name="user_email" ></td>
		</tr>
		<tr>
			<td>user_pass</td>
			<td><input type="text" value="2222" name="user_pass" ></td>
		</tr>
		<tr>
			<td>api_key</td>
			<td><input type="text" value="1111" name="api_key" ></td>
		</tr>
		<tr>
			<td>api_event</td>
			<td><input type="text" value="client_add" name="api_event"  > 
	</td>
		</tr>
		<tr>
			<td>client_name</td>
			<td><input type="text" value="Павел " name="client_name"  > </td>
		</tr>
		<tr>
			<td>client_sirname</td>
			<td><input type="text" value=" Дуров" name="client_sirname"  > </td>
		</tr>
		<tr>
			<td>client_patronymic</td>
			<td><input type="text" value="Сергеевич" name="client_patronymic"  > </td>
		</tr>
		<tr>
			<td>client_height</td>
			<td><input type="text" value="197" name="client_height"  > </td>
		</tr>
		<tr>
			<td>client_weight</td>
			<td><input type="text" value="90" name="client_weight"  > </td>
		</tr>

		<tr>
			<td>client_sex</td>
			<td><input type="text" value="man" name="client_sex" > </td>
		</tr>
		<tr>
			<td>client_age</td>
			<td> <input type="text" value="1585840484" name="client_age"  > </td>
		</tr>

		<tr>
			<td>client_visit</td>
			<td>  <input type="text" value="88" name="client_visit" ></td>
		</tr>

		<tr>
			<td>client_phone</td>
			<td>  <input type="text" value="+7845956549" name="client_phone" ></td>
		</tr>
		<tr>
			<td>client_measurements</td>
			<td>  <textarea   name="client_measurements" >array</textarea></td>
		</tr>
		<tr>
			<td>client_trainings</td>
			<td>  <textarea   name="client_trainings" >array</textarea></td>
		</tr>
		<tr>
			<td>client_foto</td>
			<td>  <input type="file"  name="client_foto" ></td>
		</tr>

		<tr>
			<td>club_id</td>
			<td>   <input type="text" value="95" name="club_id"  ></td>
		</tr>

	</table>
 <button type="submit">ok</button>
 
</form>
</div>

<div>

<h3>Клиент -> редактирование</h3>
<form action="<?=$host?>/query/clients.php" method="post"  target="_blank" enctype="multipart/form-data">
	<table border="1">
		<tr>
			<td>user_email</td>
			<td><input type="text" value="vov4ik.san@gmail.com" name="user_email" ></td>
		</tr>
		<tr>
			<td>user_pass</td>
			<td><input type="text" value="2222" name="user_pass" ></td>
		</tr>
		<tr>
			<td>api_key</td>
			<td> <input type="text" value="1111" name="api_key" ></td>
		</tr>
		<tr>
			<td>api_event</td>
			<td><input type="text" value="client_redact" name="api_event"  > </td>
		</tr>
		
		<tr>
			<td>client_name</td>
			<td><input type="text" value="Павел " name="client_name"  > </td>
		</tr>
		<tr>
			<td>client_sirname</td>
			<td><input type="text" value=" Дуров" name="client_sirname"  > </td>
		</tr>
		<tr>
			<td>client_patronymic</td>
			<td><input type="text" value="Сергеевич" name="client_patronymic"  > </td>
		</tr>
		<tr>
			<td>client_height</td>
			<td><input type="text" value="197" name="client_height"  > </td>
		</tr>
		<tr>
			<td>client_weight</td>
			<td><input type="text" value="90" name="client_weight"  > </td>
		</tr>

		<tr>
			<td>client_sex</td>
			<td><input type="text" value="man" name="client_sex" > </td>
		</tr>
		<tr>
			<td>client_age</td>
			<td> <input type="text" value="1585840484" name="client_age"  > </td>
		</tr>

		<tr>
			<td>client_visit</td>
			<td>  <input type="text" value="88" name="client_visit" ></td>
		</tr>

		<tr>
			<td>client_phone</td>
			<td>  <input type="text" value="+7845956549" name="client_phone" ></td>
		</tr>
		<tr>
			<td>client_measurements</td>
			<td>  <textarea   name="client_measurements" >array</textarea></td>
		</tr>
		<tr>
			<td>client_trainings</td>
			<td>  <textarea   name="client_trainings" >array</textarea></td>
		</tr>
		<tr>
			<td>client_foto</td>
			<td>  <input type="file"  name="client_foto" ></td>
		</tr>

		<tr>
			<td>club_id</td>
			<td>   <input type="text" value="95" name="club_id"  ></td>
		</tr>
		<tr>
			<td>client_id</td>
			<td><input type="text" value="20" name="client_id"  ></td>
		</tr>
	</table>

 <span>
 <button type="submit">ok</button>
</span>
</form>
</div>

<div>
<h3>Клиент -> удаление</h3>
<form action="<?=$host?>/query/clients.php" method="post"  target="_blank">
	<table border="1">
		<tr>
			<td>user_email</td>
			<td><input type="text" value="vov4ik.san@gmail.com" name="user_email" ></td>
		</tr>
		<tr>
			<td>user_pass</td>
			<td> <input type="text" value="2222" name="user_pass" ></td>
		</tr>
		<tr>
			<td>api_key</td>
			<td> <input type="text" value="1111" name="api_key"></td>
		</tr>
		<tr>
			<td>api_event</td>
			<td> <input type="text" value="client_delete" name="api_event" > </td>
		</tr>
		<tr>
			<td>client_id</td>
			<td><input type="text" value="999" name="client_id"  ></td>
		</tr>
	</table>
   <span>
 <button type="submit">ok</button>
</span>
</form>
</div>

<div>
<h3>Клиент -> получение списка клиентов</h3>

<form action="<?=$host?>/query/clients.php" method="post"  target="_blank" enctype="multipart/form-data">
	<table border="1">
		<tr>
			<td>user_email</td>
			<td><input type="text" value="vov4ik.san@gmail.com" name="user_email" ></td>
		</tr>
		<tr>
			<td>user_pass</td>
			<td><input type="text" value="2222" name="user_pass" ></td>
		</tr>
		<tr>
			<td>api_key</td>
			<td><input type="text" value="1111" name="api_key" ></td>
		</tr>
		<tr>
			<td>api_event</td>
			<td><input type="text" value="client_get" name="api_event"  > 
	</td>
	</tr>
	<tr>
			<td>api_filter_ids[]</td>
			<td>
				<input type="text" value="20" name="api_filter_ids[]"  ><br>
				<input type="text" value="21" name="api_filter_ids[]"  ><br>
				<input type="text" value="22" name="api_filter_ids[]"  >
			</td> 
	</tr>
	<tr>
			<td>api_filter_names[]</td>
			<td>
				<input type="text" value="Владимир" name="api_filter_names[]"  ><br>
				<input type="text" value="Павел" name="api_filter_names[]"  ><br>

				<input type="text" value="Бунин" name="api_filter_names[]"  ><br>
				<input type="text" value="Путин" name="api_filter_names[]"  ><br>

				<input type="text" value="Сергеевич" name="api_filter_names[]"  ><br>
				<input type="text" value="Дмитриевич" name="api_filter_names[]"  >
			</td> 
	</tr>
	<!--
		<tr>
			<td>api_filter_sirnames[]</td>
			<td>
				<input type="text" value="Бунин" name="api_filter_sirnames[]"  ><br>
				<input type="text" value="Путин" name="api_filter_sirnames[]"  >
			</td> 
	</tr>
	<tr>
			<td>api_filter_patronymics[]</td>
			<td>
				<input type="text" value="Сергеевич" name="api_filter_patronymics[]"  ><br>
				<input type="text" value="Дмитриевич" name="api_filter_patronymics[]"  >
			</td> 
	</tr>
-->
	<tr>
			<td>api_sort</td>
			<td><select name="api_sort" >
					<option value="sirname">sirname</option>
					<option value="dateS">dateS</option>
				</select> 
	</td>
	</tr>
	<tr>
			<td>club_id</td>
			<td>   <input type="text" value="95" name="club_id"  ></td>
		</tr>

</table>
 <button type="submit">ok</button>
</form>
</div>

</div>



<h1>Тренировки</h1>

<div style="display: flex;">
	<div>

<h3>Тренировки -> добавление</h3>
<form action="<?=$host?>/query/training.php" method="post" target="_blank">
	<table border="1">
		<tr>
			<td>user_email</td>
			<td><input type="text" value="vov4ik.san@gmail.com" name="user_email" ></td>
		</tr>
		<tr>
			<td>user_pass</td>
			<td><input type="text" value="2222" name="user_pass" ></td>
		</tr>
		<tr>
			<td>api_key</td>
			<td><input type="text" value="1111" name="api_key"></td>
		</tr>
		<tr>
			<td>api_event</td>
			<td><input type="text" value="training_add" name="api_event" > </td>
		</tr>
		<tr>
			<td>training_name</td>
			<td><input type="text" value="ММА" name="training_name" > </td>
		</tr>
		<tr>
			<td>training_status</td>
			<td><input type="text" value="1" name="training_status" > </td>
		</tr>
		<tr>
			<td>training_duration</td>
			<td><input type="text" value="60" name="training_duration" > </td>
		</tr>
		<tr>
			<td>training_info</td>
			<td> <textarea   name="training_info" >array</textarea> </td>
		</tr>
		<tr>
			<td>club_id</td>
			<td> <input type="text" value="95" name="club_id" ></td>
		</tr>
	</table>

 <span>
 <button type="submit">ok</button>
</span>
</form>
</div>

<div>

<h3>Тренировки -> редактирование</h3>
<form action="<?=$host?>/query/training.php" method="post"  target="_blank">
	<table border="1">
		<tr>
			<td>user_email</td>
			<td> <input type="text" value="vov4ik.san@gmail.com" name="user_email" ></td>
		</tr>
		<tr>
			<td>user_pass</td>
			<td><input type="text" value="2222" name="user_pass" ></td>
		</tr>
		<tr>
			<td>api_key</td>
			<td> <input type="text" value="1111" name="api_key" ></td>
		</tr>
		<tr>
			<td>api_event</td>
			<td><input type="text" value="training_redact" name="api_event"  > </td>
		</tr>
		
		<tr>
			<td>training_name</td>
			<td><input type="text" value="Stretching" name="training_name"  > </td>
		</tr>
		<tr>
			<td>training_status</td>
			<td> <input type="text" value="0" name="training_status"  > </td>
		</tr>
		<tr>
			<td>training_duration</td>
			<td><input type="text" value="40" name="training_duration" > </td>
		</tr>
		<tr>
			<td>training_info</td>
			<td> <textarea   name="training_info" >array</textarea> </td>
		</tr>
		<tr>
			<td>club_id</td>
			<td> <input type="text" value="95" name="club_id"   ></td>
		</tr>
		<tr>
			<td>training_id</td>
			<td><input type="text" value="137" name="training_id" ></td>
		</tr>
	</table>

 <span>
 <button type="submit">ok</button>
</span>
</form>

</div>

<div>

<h3>Тренировки -> удаление</h3>
<form action="<?=$host?>/query/training.php" method="post"  target="_blank">
	<table border="1">
		<tr>
			<td>user_email</td>
			<td> <input type="text" value="vov4ik.san@gmail.com" name="user_email" ></td>
		</tr>
		<tr>
			<td>user_pass</td>
			<td><input type="text" value="2222" name="user_pass" ></td>
		</tr>
		<tr>
			<td>api_key</td>
			<td><input type="text" value="1111" name="api_key" ></td>
		</tr>
		<tr>
			<td>api_event</td>
			<td><input type="text" value="training_delete" name="api_event"  > </td>
		</tr>
		<tr>
			<td>training_id</td>
			<td><input type="text" value="137" name="training_id"  ></td>
		</tr>
	</table>

   <span>

 <button type="submit">ok</button>
</span>
</form>

</div>

<div>
<h3>Тренировки -> получение списка </h3>

<form action="<?=$host?>/query/training.php" method="post"  target="_blank" enctype="multipart/form-data">
	<table border="1">
		<tr>
			<td>user_email</td>
			<td><input type="text" value="vov4ik.san@gmail.com" name="user_email" ></td>
		</tr>
		<tr>
			<td>user_pass</td>
			<td><input type="text" value="2222" name="user_pass" ></td>
		</tr>
		<tr>
			<td>api_key</td>
			<td><input type="text" value="1111" name="api_key" ></td>
		</tr>
		<tr>
			<td>api_event</td>
			<td><input type="text" value="training_get" name="api_event"  > 
	</td>
	</tr>
	<tr>
			<td>api_filter_ids[]</td>
			<td>
				<input type="text" value="130" name="api_filter_ids[]"  ><br>
				<input type="text" value="131" name="api_filter_ids[]"  ><br>
				<input type="text" value="132" name="api_filter_ids[]"  >
			</td> 
	</tr>
	<tr>
			<td>api_filter_names[]</td>
			<td>
				<input type="text" value="Zumba" name="api_filter_names[]"  ><br>
				<input type="text" value="Stretching" name="api_filter_names[]"  >
			</td> 
	</tr>
		
	
	<tr>
			<td>club_id</td>
			<td>   <input type="text" value="95" name="club_id"  ></td>
		</tr>

</table>
 <button type="submit">ok</button>
</form>
</div>

</div>

<h1>Устройства</h1>

<div style="display: flex;">

	<div>
<h3>Устройства -> добавление</h3>
<form action="<?=$host?>/query/device.php" method="post" target="_blank">
	<table border="1">
		<tr>
			<td>user_email</td>
			<td><input type="text" value="vov4ik.san@gmail.com" name="user_email" ></td>
		</tr>
		<tr>
			<td>user_pass</td>
			<td><input type="text" value="2222" name="user_pass" ></td>
		</tr>
		<tr>
			<td>api_key</td>
			<td> <input type="text" value="1111" name="api_key" ></td>
		</tr>
		<tr>
			<td>api_event</td>
			<td><input type="text" value="device_add" name="api_event"  > </td>
		</tr>
		<tr>
			<td>device_name</td>
			<td> <input type="text" value="Штанга 2" name="device_name"  > </td>
		</tr>
		<tr>
			<td>device_info</td>
			<td> <textarea name="device_info">array</textarea> </td>
		</tr>
		<tr>
			<td>club_id</td>
			<td> <input type="text" value="95" name="club_id" ></td>
		</tr>
	</table>

 <span>
 <button type="submit">ok</button>
</span>
</form>
</div>

<div>
<h3>Устройства -> редактирование</h3>
<form action="<?=$host?>/query/device.php" method="post" target="_blank">
	<table border="1">
		<tr>
			<td>user_email</td>
			<td><input type="text" value="vov4ik.san@gmail.com" name="user_email" ></td>
		</tr>
		<tr>
			<td>user_pass</td>
			<td><input type="text" value="2222" name="user_pass" ></td>
		</tr>
		<tr>
			<td>api_key</td>
			<td><input type="text" value="1111" name="api_key" ></td>
		</tr>
		<tr>
			<td>api_event</td>
			<td><input type="text" value="device_redact" name="api_event"  > </td>
		</tr>
		
		<tr>
			<td>device_name</td>
			<td><input type="text" value="Штанга 1" name="device_name"  > </td>
		</tr>
		<tr>
			<td>device_info</td>
			<td> <textarea name="device_info">array</textarea> </td>
		</tr>
		<tr>
			<td>club_id</td>
			<td> <input type="text" value="95" name="club_id"   ></td>
		</tr>
		<tr>
			<td>device_id</td>
			<td><input type="text" value="51" name="device_id" ></td>
		</tr>
	</table>

 <span>
 <button type="submit">ok</button>
</span>
</form>
</div>

<div>
<h3>Устройства -> удаление</h3>
<form action="<?=$host?>/query/device.php" method="post"  target="_blank">
	<table border="1">
		<tr>
			<td>user_email</td>
			<td> <input type="text" value="vov4ik.san@gmail.com" name="user_email" ></td>
		</tr>
		<tr>
			<td>user_pass</td>
			<td> <input type="text" value="2222" name="user_pass" ></td>
		</tr>
		<tr>
			<td>api_key</td>
			<td> <input type="text" value="1111" name="api_key" ></td>
		</tr>
		<tr>
			<td>api_event</td>
			<td> <input type="text" value="device_delete" name="api_event"  > </td>
		</tr>
		<tr>
			<td>device_id</td>
			<td> <input type="text" value="51" name="device_id"  ></td>
		</tr>
	</table>

   <span>
 <button type="submit">ok</button>
</span>

</form>
</div>

<div>
<h3>Устройства -> получение списка </h3>

<form action="<?=$host?>/query/device.php" method="post"  target="_blank" enctype="multipart/form-data">
	<table border="1">
		<tr>
			<td>user_email</td>
			<td><input type="text" value="vov4ik.san@gmail.com" name="user_email" ></td>
		</tr>
		<tr>
			<td>user_pass</td>
			<td><input type="text" value="2222" name="user_pass" ></td>
		</tr>
		<tr>
			<td>api_key</td>
			<td><input type="text" value="1111" name="api_key" ></td>
		</tr>
		<tr>
			<td>api_event</td>
			<td><input type="text" value="device_get" name="api_event"  > 
	</td>
	</tr>
	<tr>
			<td>api_filter_ids[]</td>
			<td>
				<input type="text" value="48" name="api_filter_ids[]"  ><br>
				<input type="text" value="49" name="api_filter_ids[]"  ><br>
				<input type="text" value="50" name="api_filter_ids[]"  >
			</td> 
	</tr>
	<tr>
			<td>api_filter_names[]</td>
			<td>
				<input type="text" value="Тренажер #4" name="api_filter_names[]"  ><br>
				<input type="text" value="Тренажер #5" name="api_filter_names[]"  >
			</td> 
	</tr>
		
	
	<tr>
			<td>club_id</td>
			<td>   <input type="text" value="95" name="club_id"  ></td>
		</tr>

</table>
 <button type="submit">ok</button>
</form>
</div>



</div>




<h1>Языки</h1>

<div style="display: flex;">


<div>
<h3>Языки -> получение списка языков</h3>

<form action="<?=$host?>/query/lang.php" method="post"  target="_blank" enctype="multipart/form-data">
	<table border="1">
	
		<tr>
			<td>api_key</td>
			<td><input type="text" value="1111" name="api_key" ></td>
		</tr>
	
<tr>
			<td>api_event</td>
			<td><input type="text" value="all_langs" name="api_event"  > 
	</td>
	</tr>
	
</table>
 <button type="submit">ok</button>
</form>
</div>



<div>
<h3>Языки -> получение языка по переменной</h3>

<form action="<?=$host?>/query/lang.php" method="post"  target="_blank" enctype="multipart/form-data">
	<table border="1">

		<tr>
			<td>api_key</td>
			<td><input type="text" value="1111" name="api_key" ></td>
		</tr>
	
<tr>
			<td>api_event</td>
			<td><input type="text" value="langs_gets" name="api_event"  > 
	</td>
	</tr>
	<tr>
			<td>variable</td>
			<td><input type="text" value="russ" name="variable"  > 
	</td>
	</tr>
</table>
 <button type="submit">ok</button>
</form>
</div>




</div>
<?php
//клиенты

if (!empty($_POST['api_key'])){
	require_once($_SERVER['DOCUMENT_ROOT'].'/api/godfather.php'); 
	$godfather = new Godfather();
	$settings = $godfather->settings();
	$api_key = $godfather->prepare_var($_POST['api_key']);



	//проверка пароля

	if (password_verify($api_key, $settings->pdf_file)  ) {
		

		//получение списка языков
		if (!empty($_POST['api_event']) && $_POST['api_event']=='all_langs'  ){
			$filter = array();
			$langs1 = $godfather->series->get_series();	
			$langs = array();
			foreach ($langs1 as $key => $value) {
						$langs[$value->zagolovok] = $value->page_name;
					}		
			$langs = json_encode($langs);
			echo $langs;
		}


		//получение языка по переменной
		if (!empty($_POST['api_event']) && $_POST['api_event']=='langs_gets' && !empty($_POST['variable']) ){
			$filter = array();
			
				$filter['zagolovok'] = $_POST['variable'];
			
			$langs = $godfather->series->get_series($filter);			
			$langs = $langs[0]->text;
			echo $langs;
		}
	



	} else {
		echo 'пароль не верный';
	}
}




?>


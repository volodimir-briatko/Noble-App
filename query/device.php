<?php
//клиенты

if (!empty($_POST['api_key'])){
	require_once($_SERVER['DOCUMENT_ROOT'].'/api/godfather.php'); 
	$godfather = new Godfather();
	$settings = $godfather->settings();
	$api_key = $godfather->prepare_var($_POST['api_key']);

	//авторизация клуба 
	$user_email = $godfather->prepare_var($_POST['user_email']);
	$user_pass = $godfather->prepare_var($_POST['user_pass']);
	$club_id  = intval($godfather->prepare_var($_POST['club_id']) );
	$club_autorize = $godfather->categories->avtorise_category($club_id);

	if (empty($_POST['club_id']) && !isset($_POST['club_id'])){
		$clubs = $godfather->categories->get_categories(array('user_email'=>$user_email));
			$club = array();
			foreach ($clubs as $key => $value) {
				if ( password_verify($user_pass, $value->user_pass)  ) {
					//убираем из массива лоин и пароль
					unset($value->user_email);
					unset($value->user_pass);
					$club = $value;
					$club_id = $club->id;
					break;
				}		
			}
		//авторизация
		$club_autorize = $godfather->categories->avtorise_category($club_id);
	}


	//проверка пароля

	if (password_verify($api_key, $settings->pdf_file) && password_verify($user_pass, $club_autorize->user_pass) && $user_email==$club_autorize->user_email ) {
		
		//добавление устройства
		if ( !empty($_POST['api_event']) && $_POST['api_event']=='device_add' ){
			$club_id  = intval($godfather->prepare_var($_POST['club_id']) );
			$client_arr = array(
				'page_name' => $godfather->prepare_var($_POST['device_name']), //имя
				'club_id' => $club_id,
				'vis' => 1,
				'info' => $godfather->prepare_var($_POST['device_info']),
				'dateS' => time(),
			);
			$club = $godfather->categories->get_category($club_id);
				if (!empty($club)){
					$client_arr['club'] = $club->page_name;
				}
			$filter = array();
			$filter['filter_page_names'][] = $godfather->prepare_var($_POST['device_name']);
			$is_device = $godfather->characteristics->get_characteristics($filter);
			if (empty($is_device) ){
				
				$res_id = $godfather->characteristics->insert_page($client_arr);
				echo $res_id;
			} else {
				$is_device = $is_device[0];
				if ($is_device->club_id!=$club_id){
					$res_id = $godfather->characteristics->update_page($is_device->id,$client_arr);
					echo 1;
				}
			}
			/*
			
			*/
		}

		//редактирование устройства
		if (!empty($_POST['api_event']) && $_POST['api_event']=='device_redact' && !empty($_POST['device_id']) ){
			$device_id  = intval($godfather->prepare_var($_POST['device_id']) );
			$club_id = intval($godfather->prepare_var($_POST['club_id']) );
			if (isset($_POST['device_name']) ){
				$client_arr['page_name'] = $godfather->prepare_var($_POST['device_name']);
			}			
			if (isset( $_POST['club_id']) ){
				$client_arr['club_id'] = $club_id;
			}
			if (isset($_POST['device_info']) ){
				$client_arr['info'] = $godfather->prepare_var($_POST['device_info']);
			}
			
			$club = $godfather->categories->get_category($club_id);
			if (!empty($club) ){
				$client_arr['club'] = $club->page_name;
			}
			$res_id = $godfather->characteristics->update_page($device_id,$client_arr);
			echo 1;
		}

		//удаление устройства
		if (!empty($_POST['api_event']) && $_POST['api_event']=='device_delete' && !empty($_POST['device_id']) ){
			$device_id = intval($godfather->prepare_var($_POST['device_id']) );
			$godfather->db->delete_items(array($device_id),'characteristics');
			echo 1;
		}

			//получение списка
		if (!empty($_POST['api_event']) && $_POST['api_event']=='device_get' && !empty($_POST['club_id']) ){
			$club_id = intval($godfather->prepare_var($_POST['club_id']) );

			$filter = array('club_id'=>$club_id);
			
			$api_filter_ids = array();
			if (!empty($_POST['api_filter_ids'])){
				foreach ($_POST['api_filter_ids'] as $p) {
					$p = $godfather->prepare_var($p);
					if (!empty($p)){
						$api_filter_ids[] = $p;
					}
				}
				$filter['product_ids'] = $api_filter_ids;		
			} 
	
			
			$api_filter_names = array();
			if (!empty($_POST['api_filter_names'])){
				foreach ($_POST['api_filter_names'] as $p) {
					$p = $godfather->prepare_var($p);
					if (!empty($p) ){
						$api_filter_names[] = $p;
					}
				}
				$filter['filter_page_names'] = $api_filter_names;
			}	

			$trainings = $godfather->characteristics->get_characteristics($filter);
			
			$trainings = json_encode($trainings);
			echo $trainings;
		}


	} else {
		echo 'пароль не верный';
	}
}




?>


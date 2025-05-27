<?php
//тренировки

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
		
		//добавление тренинга
		if ( !empty($_POST['api_event']) && $_POST['api_event']=='training_add' ){
			$client_arr = array(
				'page_name' => $godfather->prepare_var($_POST['training_name']), //имя
				'vis' => intval($godfather->prepare_var($_POST['training_status']) ), //имя
				'dateS' => time(),
				'duration' => $godfather->prepare_var($_POST['training_duration']),
				'info' => $godfather->prepare_var($_POST['training_info']),
				'category' => intval($godfather->prepare_var($_POST['club_id']) )
			);

			$res_id = $godfather->groups->insert_page($client_arr);
			echo $res_id;
		}

		//редактирование тренинга
		if (!empty($_POST['api_event']) && $_POST['api_event']=='training_redact' && !empty($_POST['training_id']) ){
			$training_id = intval($godfather->prepare_var($_POST['training_id']) );
	
			if (isset($_POST['training_name']) ){
				$client_arr['page_name'] = $godfather->prepare_var($_POST['training_name']);
			}
			if (isset( $_POST['training_status']) ){
				$client_arr['vis'] = $godfather->prepare_var($_POST['training_status']);
			}
			if (isset( $_POST['training_duration']) ){
				$client_arr['duration'] = $godfather->prepare_var($_POST['training_duration']);
			}
			if (isset( $_POST['training_info']) ){
				$client_arr['info'] = $godfather->prepare_var($_POST['training_info']);
			}
	
			if (isset( $_POST['club_id']) ){
				$client_arr['category'] = intval($godfather->prepare_var($_POST['club_id']) );
			}

			$res_id = $godfather->groups->update_page($training_id,$client_arr);
			 echo 1;
		}

		//удаление тренинга
		if (!empty($_POST['api_event']) && $_POST['api_event']=='training_delete' && !empty($_POST['training_id']) ){
			$training_id = intval($godfather->prepare_var($_POST['training_id']) );
			$godfather->db->delete_items(array($training_id),'groups');
			echo 1;
		}

		//получение списка
		if (!empty($_POST['api_event']) && $_POST['api_event']=='training_get' && !empty($_POST['club_id']) ){
			$club_id = intval($godfather->prepare_var($_POST['club_id']) );

			$filter = array('category_id'=>$club_id);
			
			$api_filter_ids = array();
			if (!empty($_POST['api_filter_ids'])){
				foreach ($_POST['api_filter_ids'] as $p) {
					$p = $godfather->prepare_var($p);
					if (!empty($p)){
						$api_filter_ids[] = $p;
					}
				}
				$filter['ids'] = $api_filter_ids;		
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

			$trainings = $godfather->groups->get_pages($filter);

			$trainings = json_encode($trainings);
			echo $trainings;
		}


	} else {
		echo 'пароль не верный';
	}
}




?>


<?php
//клиенты
if (!empty($_POST['api_key']))
{
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/api/godfather.php');
    $godfather = new Godfather();
    $settings = $godfather->settings();
    $api_key = $godfather->prepare_var($_POST['api_key']);

    //авторизация клуба
    $user_email = $godfather->prepare_var($_POST['user_email']);
    if (isset($_POST['user_pass']))
    {
        $user_pass = $godfather->prepare_var($_POST['user_pass']);
    }

    if (!empty($_POST['club_id']))
    {
        $club_id = intval($godfather->prepare_var($_POST['club_id']));

    }

    if (empty($_POST['club_id']) && !isset($_POST['club_id']))
    {
        $clubs = $godfather
            ->categories
            ->get_categories(array(
            'user_email' => $user_email
        ));
        $club = array();
        foreach ($clubs as $key => $value)
        {
            if (password_verify($user_pass, $value->user_pass))
            {
                //убираем из массива лоин и пароль
                unset($value->user_email);
                unset($value->user_pass);
                $club = $value;
                $club_id = $club->id;
                break;
            }
        }
        //авторизация
        $club_autorize = $godfather
            ->categories
            ->avtorise_category($club_id);
    }

    //восстановление пароля клуба
    /*
    if ($_POST['api_event']=='club_get'){
    $post = json_encode($_POST);
    $post2 = file_get_contents('log.txt');
    file_put_contents('log.txt', $post2.$post."\n");
    }
    */
    if (!empty($_POST['api_event']) && $_POST['api_event'] == 'club_password_recovery' && password_verify($api_key, $settings->pdf_file))
    {
        $clubs = $godfather
            ->categories
            ->get_categories(array(
            'user_email' => $user_email
        ));
        if (!empty($clubs))
        {
            $club = $clubs[0];
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ' . $club->id;
            $rand_name = substr(str_shuffle($permitted_chars) , 0, 16);
            $link = 'http://noble.gensol.ru/password_recovery.php?secret=' . $rand_name;

            $html = '<p><strong>Здравствуйте, ' . $club->title . '!</strong></p>';
            $html .= '<p>От вас поступила заявка на восстановление пароля.</p>';
            $html .= '<p>Для восстановления пароля перейдите по ссылке <a href="' . $link . '">' . $link . '</a></p>';
            $html .= '<p>Ссылка будет доступна в течение 30 минут</p>';

            $godfather
                ->categories
                ->update_category($club->id, array(
                'pass_change' => $rand_name,
                'pass_time' => time()
            ));

            $godfather->send_letter($html, 'Восстановление пароля NOBLE', $settings->admin_email, $club->user_email);
            echo 1;
            return;
        }

    }

    //получение инфы о клубе
    /*
    if ($_POST['api_event']=='club_get'){
    $post = json_encode($_POST);
    $post2 = file_get_contents('log.txt');
    file_put_contents('log.txt', $post2.$post."\n");
    }
    */
    if (!empty($_POST['api_event']) && $_POST['api_event'] == 'club_get' && password_verify($api_key, $settings->pdf_file))
    {
        $clubs = $godfather
            ->categories
            ->get_categories(array(
            'user_email' => $user_email
        ));
        $club = array();
        foreach ($clubs as $key => $value)
        {
            if (password_verify($user_pass, $value->user_pass))
            {
                //убираем из массива лоин и пароль
                unset($value->user_email);
                unset($value->user_pass);
                $club = $value;
                $club_id = $club->id;
                break;
            }
        }
        if ($club->parent_id == 0)
        {
            $club->parent_id = 1;
            $device_id = $godfather->prepare_var($_POST['device_id']);
            $club->url = $device_id;
            $godfather
                ->categories
                ->update_category($club->id, array(
                'parent_id' => 1,
                'url' => $device_id
            ));
        }
        else if ($club->parent_id == 1 && $club->url != $godfather->prepare_var($_POST['device_id']))
        {
            $club->parent_id = 0;
        }

        $club->device_id = $club->url;

        $club = json_encode($club);
        echo $club;
    }

    //деактивизация
    if (!empty($_POST['api_event']) && $_POST['api_event'] == 'club_exit' && password_verify($api_key, $settings->pdf_file))
    {
        $clubs = $godfather
            ->categories
            ->get_categories(array(
            'user_email' => $user_email
        ));
        $club = array();
        foreach ($clubs as $key => $value)
        {
            if (password_verify($user_pass, $value->user_pass))
            {
                //убираем из массива лоин и пароль
                unset($value->user_email);
                unset($value->user_pass);
                $club = $value;
                $club_id = $club->id;
                break;
            }
        }
        $godfather
            ->categories
            ->update_category($club->id, array(
            'parent_id' => 0,
            'url' => ''
        ));
        echo 'success logout';
    }

    //авторизация
    $club_autorize = $godfather
        ->categories
        ->avtorise_category($club_id);

    //проверка пароля
    if (password_verify($api_key, $settings->pdf_file) && password_verify($user_pass, $club_autorize->user_pass) && $user_email == $club_autorize->user_email)
    {

        //добавление клиента
        if (!empty($_POST['api_event']) && $_POST['api_event'] == 'client_add')
        {
            $club_id = intval($godfather->prepare_var($_POST['club_id']));

            $client_arr = array(
                'page_name' => $godfather->prepare_var($_POST['client_name']) , //имя
                'sex' => $godfather->prepare_var($_POST['client_sex']) , //пол
                'age' => ($godfather->prepare_var($_POST['client_age'])) , //возраст
                'pos5' => intval($godfather->prepare_var($_POST['client_visit'])) , //кол-во посещений
                'sirname' => ($godfather->prepare_var($_POST['client_sirname'])) ,
                'patronymic' => ($godfather->prepare_var($_POST['client_patronymic'])) ,
                'height' => ($godfather->prepare_var($_POST['client_height'])) ,
                'weight' => ($godfather->prepare_var($_POST['client_weight'])) ,
                'phone' => ($godfather->prepare_var($_POST['client_phone'])) ,
                'measurements' => ($_POST['client_measurements']) ,
                'trainings' => ($_POST['client_trainings']) ,
                'vis' => 1,
                'dateS' => time() ,
                'hit' => 0,
                'citate' => '',
                'foto' => '',
                'url' => ''
            );

            if (($_FILES['client_foto']['name']) == true)
            {
                $image1 = $godfather
                    ->images
                    ->upload_image($_FILES['client_foto'], 360);
                if (!empty($image1))
                {
                    $client_arr['foto'] = $image1;
                }
            }

            $club = $godfather
                ->categories
                ->get_category($club_id);
            if (!empty($club))
            {
                $client_arr['club'] = $club->page_name;
            }
            $res_id = $godfather
                ->products
                ->insert_product($client_arr);
            if (!empty($club))
            {
                $godfather
                    ->categories
                    ->insert_categories_features(array(
                    $club->id
                ) , $res_id);
            }
            echo $res_id;
        }

        //редактирование клиента
        if (!empty($_POST['api_event']) && $_POST['api_event'] == 'client_redact' && !empty($_POST['client_id']))
        {
            $club_id = intval($godfather->prepare_var($_POST['club_id']));
            $client_id = intval($godfather->prepare_var($_POST['client_id']));

            if (isset($_POST['client_name']))
            {
                $client_arr['page_name'] = $godfather->prepare_var($_POST['client_name']);
            }
            if (isset($_POST['client_sex']))
            {
                $client_arr['sex'] = $godfather->prepare_var($_POST['client_sex']);
            }
            if (isset($_POST['client_age']))
            {
                $client_arr['age'] = ($godfather->prepare_var($_POST['client_age']));
            }
            if (isset($_POST['client_visit']))
            {
                $client_arr['pos5'] = intval($godfather->prepare_var($_POST['client_visit']));
            }
            if (isset($_POST['client_sirname']))
            {
                $client_arr['sirname'] = ($godfather->prepare_var($_POST['client_sirname']));
            }
            if (isset($_POST['client_patronymic']))
            {
                $client_arr['patronymic'] = ($godfather->prepare_var($_POST['client_patronymic']));
            }
            if (isset($_POST['client_height']))
            {
                $client_arr['height'] = ($godfather->prepare_var($_POST['client_height']));
            }
            if (isset($_POST['client_weight']))
            {
                $client_arr['weight'] = ($godfather->prepare_var($_POST['client_weight']));
            }
            if (isset($_POST['client_phone']))
            {
                $client_arr['phone'] = ($godfather->prepare_var($_POST['client_phone']));
            }
            if (isset($_POST['client_phone']))
            {
                $client_arr['phone'] = ($godfather->prepare_var($_POST['client_phone']));
            }
            if (isset($_POST['client_phone']))
            {
                $client_arr['phone'] = intval($godfather->prepare_var($_POST['client_phone']));
            }
            if (isset($_POST['client_measurements']))
            {
                $client_arr['measurements'] = (($_POST['client_measurements']));
            }
            if (isset($_POST['client_trainings']))
            {
                $client_arr['trainings'] = (($_POST['client_trainings']));
            }

            if (($_FILES['client_foto']['name']) == true)
            {
                $image1 = $godfather
                    ->images
                    ->upload_image($_FILES['client_foto'], 360);
                if (!empty($image1))
                {
                    $client_arr['foto'] = $image1;
                }
            }

            $club = $godfather
                ->categories
                ->get_category($club_id);
            if (!empty($club))
            {
                $client_arr['club'] = $club->page_name;
            }
            $res_id = $godfather
                ->products
                ->update_product($client_id, $client_arr);
            if (!empty($club) && $res_id)
            {
                $godfather
                    ->categories
                    ->delete_category_product($client_id);
                $godfather
                    ->categories
                    ->insert_categories_features(array(
                    $club->id
                ) , $client_id);
            }
            if ($res_id) echo 1;
        }

        //удаление клиента
        if (!empty($_POST['api_event']) && $_POST['api_event'] == 'client_delete' && !empty($_POST['client_id']))
        {
            $client_id = intval($godfather->prepare_var($_POST['client_id']));
            $godfather
                ->db
                ->delete_items(array(
                $client_id
            ) , 'products');
            echo 1;
        }

        //получение списка
        if (!empty($_POST['api_event']) && $_POST['api_event'] == 'client_get' && !empty($_POST['club_id']))
        {
            $club_id = intval($godfather->prepare_var($_POST['club_id']));
            $categories_products = $godfather
                ->categories
                ->get_categories_products($club_id);
            $filter = array();
            $api_filter_ids = array();
            if (!empty($_POST['api_filter_ids']))
            {
                foreach ($_POST['api_filter_ids'] as $p)
                {
                    $p = $godfather->prepare_var($p);

                    if (!empty($p) && in_array($p, $categories_products))
                    {
                        $api_filter_ids[] = $p;
                    }
                }
            }
            if (empty($api_filter_ids))
            {
                $api_filter_ids = $categories_products;
            }
            $filter['product_ids'] = $api_filter_ids;
            $api_filter_names = array();
            if (!empty($_POST['api_filter_names']))
            {
                foreach ($_POST['api_filter_names'] as $p)
                {
                    $p = $godfather->prepare_var($p);
                    if (!empty($p))
                    {
                        $api_filter_names[] = $p;
                    }
                }
                $filter['filter_page_names'] = $api_filter_names;
            }
            /*
            
            if (!empty($_POST['api_filter_sirnames'])){
            foreach ($_POST['api_filter_sirnames'] as $p) {
            $p = $godfather->prepare_var($p);
            if (!empty($p) ){
            $api_filter_sirnames[] = $p;
            }
            }
            
            }
            
            if (!empty($_POST['api_filter_patronymics'])){
            foreach ($_POST['api_filter_patronymics'] as $p) {
            $p = $godfather->prepare_var($p);
            if (!empty($p) ){
            $api_filter_patronymics[] = $p;
            }
            }
            
            }
            */
            $api_sort = $godfather->prepare_var($_POST['api_sort']);
            if (in_array($api_sort, array(
                'dateS',
                'sirname'
            )))
            {
                $filter['order'] = $api_sort;
                $filter['order_pos'] = 'asc';
            }
            $products = $godfather
                ->products
                ->get_products($filter);

            $products = json_encode($products);

            echo $products;

        }

    }
    else
    {
        echo 'пароль не верный';
    }
}

?>

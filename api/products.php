<?
class Products extends godfather {

public function get_product($id,$filter = array())	{
$vis_filter = '';
if(isset($filter['vis']))
			$vis_filter = sprintf(" AND vis='%s'",  $this->db->real_escape($filter['vis']));

if(gettype($id) == 'string')
			$where = sprintf("AND url='%s'", $this->db->real_escape($id) );
		else
			$where = sprintf("AND id='%s'", $this->db->real_escape($id) );

	$query = "SELECT * FROM `products` WHERE 1 ".$vis_filter ." ".$where." LIMIT 1";

$cont = $this->db->result($query);
return $cont[0];
	}

public function get_products($filter = array())	{
	$vis_filter = '';
	$type_filter = '';
	$product_ids_filter = '';
	$limit_filter = '';
	$page_name_filter = '';
	$club_filter = '';
	$top3_filter = '';
	$date_from_filter = '';
	$date_to_filter = '';
	$group_present_filter = '';
	$group_color_filter = '';
	$shkaf_group_filter = '';
	$ids_not_filter = '';
	$page_names_filter = '';
	$sirnames_filter = '';
	$patronymics_filter = '';

		if(isset($filter['vis']))
			$vis_filter = sprintf(" AND vis='%s'",  $this->db->real_escape($filter['vis']));
		if(isset($filter['type']))
			$type_filter = sprintf(" AND type='%s'",  $this->db->real_escape($filter['type']));	
	
		if(isset($filter['sirname'])) {
			$page_name_filter =  sprintf("%s",  $this->db->real_escape($filter['sirname']));

			$page_name_filter = " AND ((sirname LIKE '$page_name_filter%' ) OR (page_name LIKE '$page_name_filter%' ) OR (patronymic LIKE '$page_name_filter%' ) )";	
		}
			
			if(isset($filter['date_from']))
			$date_from_filter = sprintf(" AND dateS>=%s",  $this->db->real_escape($filter['date_from']));	
			if(isset($filter['date_to']))
			$date_to_filter = sprintf(" AND dateS<=%s",  $this->db->real_escape($filter['date_to']));	
			
		if(isset($filter['club'])) {
			$club_filter =  sprintf("%s",  $this->db->real_escape($filter['club']));
			$club_filter = " AND club LIKE '$club_filter%' ";	
		}
	
		if(isset($filter['product_ids'])){
		if(empty($filter['product_ids'])){$filter['product_ids'] = array(0); }
			$product_ids_filter = implode(",", $filter['product_ids']);
			$product_ids_filter = sprintf(" AND id IN (%s)",  $this->db->real_escape($product_ids_filter));			
		}

		if(!empty($filter['filter_page_names'])){
			$page_names_filter = " AND (page_name IN ('".implode("','", $filter['filter_page_names'])."')";
			$patronymics_filter = " OR patronymic IN ('".implode("','", $filter['filter_page_names'])."')";
			$sirnames_filter = " OR sirname IN ('".implode("','", $filter['filter_page_names'])."') )";
		}
	
		
			
		
		if(isset($filter['ids_not'])){
		if(empty($filter['ids_not'])){$filter['ids_not'] = array(0); }
			$ids_not_filter = " AND id NOT IN (".implode(",", $filter['ids_not']).")";
			}	
		
		if(isset($filter['group_present'])){
		if(empty($filter['group_present'])){$filter['group_present'] = array(0); }
			$group_present_filter = " AND stol_group IN (".implode(",", $filter['group_present']).")";
			}	
		
		if(isset($filter['group_color'])){
		if(empty($filter['group_color'])){$filter['group_color'] = array(0); }
			$group_color_filter = " AND color_group IN (".implode(",", $filter['group_color']).")";
			}	
		if(isset($filter['shkaf_group'])){
		if(empty($filter['shkaf_group'])){$filter['shkaf_group'] = array(0); }
			$shkaf_group_filter = " AND shkaf_group IN (".implode(",", $filter['shkaf_group']).")";
			}		
		
			
		if(isset($filter['limit']))
			$limit_filter = " LIMIT 0,".$filter['limit'];	
		 
		 if(isset($filter['limit_srart']) && isset($filter['limit']))
			$limit_filter = " LIMIT ".$filter['limit_srart'].",".$filter['limit'];
		
		if(isset($filter['order']) && !empty($filter['order'])){
			$order = $filter['order'];	
							
		}else {
			$order = 'id';	
		} 




		if(isset($filter['order_pos'])){
		
			$order_pos = $filter['order_pos'];	
		} else $order_pos = 'DESC';	


	$query = "SELECT * FROM `products` WHERE 1  $vis_filter $ids_not_filter $type_filter $page_name_filter $page_names_filter $sirnames_filter $patronymics_filter $club_filter $date_from_filter $date_to_filter $product_ids_filter $group_present_filter $group_color_filter $top3_filter ORDER BY $order $order_pos $limit_filter";

    $cont = $this->db->result($query);
return $cont;
	}

public function get_products_count($filter = array())	{
	$vis_filter = '';
	$product_ids_filter = '';
	$s_top2_filter = '';
	$s_top3_filter = '';
	$ids_not_filter = '';
	$club_filter = '';
	$page_name_filter = '';
	$date_to_filter = '';
	$date_from_filter = '';
		if(isset($filter['date_from']))
			$date_from_filter = sprintf(" AND dateS>=%s",  $this->db->real_escape($filter['date_from']));	
			if(isset($filter['date_to']))
			$date_to_filter = sprintf(" AND dateS<=%s",  $this->db->real_escape($filter['date_to']));	
		if(isset($filter['club'])) {
			$club_filter =  sprintf("%s",  $this->db->real_escape($filter['club']));
			$club_filter = " AND club LIKE '$club_filter%' ";	
		}
		if(isset($filter['page_name'])) {
			$page_name_filter =  sprintf("%s",  $this->db->real_escape($filter['page_name']));
			$page_name_filter = " AND page_name LIKE '$page_name_filter%' ";	
		}
		if(isset($filter['vis']))
			$vis_filter = sprintf(" AND vis='%s'",  $this->db->real_escape($filter['vis']) );
		if(isset($filter['s_top2']))
			$s_top2_filter = sprintf(" AND s_top2>0");	
		if(isset($filter['s_top3']))
			$s_top3_filter = sprintf(" AND s_top3>0");		
		if(isset($filter['product_ids'])){
		if(empty($filter['product_ids'])){$filter['product_ids'] = array(0); }
			$product_ids_filter = " AND id IN (".implode(",", $filter['product_ids']).")";
			}
		if(isset($filter['ids_not'])){
		if(empty($filter['ids_not'])){$filter['ids_not'] = array(0); }
			$ids_not_filter = " AND id NOT IN (".implode(",", $filter['ids_not']).")";
			}	
	
	$query = "SELECT id FROM `products` WHERE 1  $vis_filter $product_ids_filter $ids_not_filter $s_top2_filter $s_top3_filter $club_filter $page_name_filter  $date_from_filter $date_to_filter  ORDER BY `pos`";

$count = $this->db->rows_count($query);
return $count;
	}	

public function update_product($id, $arr)	{	

		$part = '';
		$i=0;
		foreach($arr as $k=>$v){
		if ($i>0){$part .= ",";}
		$part .= sprintf($k."='%s'",  $this->db->real_escape($v));
		$i++;
		}
		$query = "UPDATE `products` SET ".$part." WHERE id='$id'";

		$this->db->query($query);	
		return 1;	
	}

public function insert_product($arr)	{			
$max = $this->db->result("Select max(`pos`) as `maxid` from `products`");
$max = $max[0]->maxid;
$pos = $max+1; 
		$columns = 'pos';
		$values = "'$pos'";
		foreach($arr as $k=>$v){
		$columns .= ",".$k;
		$values .= sprintf(",'%s'", $this->db->real_escape($v));
		}
		$query = "INSERT INTO `products` (".$columns.") VALUES (".$values.") ";
	
		$this->db->query($query);	
		return $this->db->last_id();		
	}

public function delete_product_feature($product_id)	{
		$product_id = intval($product_id);
		if ($product_id>0){
		$query  = "DELETE FROM `categories_features` WHERE `product_id`='$product_id'"; 
		$this->db->query($query);
		}
	}
public function delete_product_sery($product_id)	{
	$product_id = intval($product_id);
	if ($product_id>0){
	$query  = "DELETE FROM `series_features` WHERE `product_id`='$product_id'"; 
	$this->db->query($query);
	}	
}
	
}
?>
<?
require_once('godfather.php');
class Characteristics extends godfather {

	/* âûâîä èòåìà */	
	public function get_characteristic($id,$filter = array())	{
		$vis_filter = '';
		if(isset($filter['vis']))
					$vis_filter = sprintf(" AND vis='%s'", $this->db->real_escape($filter['vis']) );

		if(gettype($id) == 'string')
					$where = sprintf("AND url='%s'", $this->db->real_escape($id) );
				else
					$where = sprintf("AND id='%s'",$this->db->real_escape($id) );

			$query = "SELECT * FROM `characteristics` WHERE 1 ".$vis_filter ." ".$where." LIMIT 1";
		$cont = $this->db->result($query);
		return $cont[0];
	}

	/* âûâîä èòåìîâ */	
	public function get_characteristics($filter = array())	{
		
		$groupa_filter = '';
		$vis_filter = '';
		$category_filter = '';
		$products_filter = '';
		$club_filter = '';
		$club_id_filter = '';
		$page_names_filter = '';
		$limit_filter = '';
	
		if(isset($filter['club'])) {
			$club_filter =  sprintf("%s",  $this->db->real_escape($filter['club']));
			$club_filter = " AND club LIKE '$club_filter%' ";	
		}
		if(isset($filter['club_id'])) {
			$club_id_filter =  sprintf(" AND club_id='%s'", $this->db->real_escape($filter['club_id']) );
		}
		if(isset($filter['groups'])){
			if(empty($filter['groups'])){$filter['groups'] = array(0); }
				$groupa_filter = " AND groupa IN (".implode(",", $filter['groups']).")";
				}
				
		if(isset($filter['cat_ids'])){
			if(empty($filter['cat_ids'])){$filter['cat_ids'] = array(0); }
			$category_filter = " AND category IN (".implode(",", $filter['cat_ids']).")";
		}

		if(!empty($filter['product_ids'])){
			$products_filter = " AND id IN (".implode(",", $filter['product_ids']).")";
			}	
		if(!empty($filter['filter_page_names'])){
			$page_names_filter = " AND page_name IN ('".implode("','", $filter['filter_page_names'])."')";
		}				

		if(isset($filter['vis']))
				$vis_filter = sprintf(" AND vis='%s'", $this->db->real_escape($filter['vis']) );

	
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

		$query = "SELECT * FROM `characteristics` WHERE 1 $groupa_filter $page_names_filter $vis_filter $category_filter $products_filter $club_filter $club_id_filter ORDER BY $order $order_pos $limit_filter";
		$cont = $this->db->result($query);
		return $cont;
	}


	public function get_characteristics_count($filter = array())	{
	$vis_filter = '';
	$product_ids_filter = '';
	$ids_not_filter = '';
	$club_filter = '';
	$club_id_filter = '';

	if(isset($filter['club_id'])) {
			$club_id_filter =  sprintf(" AND club_id='%s'", $this->db->real_escape($filter['club_id']) );
		}
		if(isset($filter['club'])) {
			$club_filter =  sprintf("%s",  $this->db->real_escape($filter['club']));
			$club_filter = " AND club LIKE '$club_filter%' ";	
		}
		
		if(isset($filter['vis']))
			$vis_filter = sprintf(" AND vis='%s'",  $this->db->real_escape($filter['vis']) );
			
		if(isset($filter['product_ids'])){
		if(empty($filter['product_ids'])){$filter['product_ids'] = array(0); }
			$product_ids_filter = " AND id IN (".implode(",", $filter['product_ids']).")";
			}
		if(isset($filter['ids_not'])){
		if(empty($filter['ids_not'])){$filter['ids_not'] = array(0); }
			$ids_not_filter = " AND id NOT IN (".implode(",", $filter['ids_not']).")";
			}	
	
	$query = "SELECT * FROM `characteristics` WHERE 1  $vis_filter $product_ids_filter $ids_not_filter $club_filter $club_id_filter ";
	
$count = $this->db->rows_count($query);
return $count;
	}	

	/* îáíîâëåíèå */	
	public function update_page($id, $arr)	{	
		$part = '';
		$i=0;
		foreach($arr as $k=>$v){
		if ($i>0){$part .= ",";}
		$part .= sprintf("`$k`"."='%s'", $this->db->real_escape($v));
		$i++;
		}
		$query = "UPDATE `characteristics` SET ".$part." WHERE `id`='$id'";
		$this->db->query($query);		
	}

	/* äîáàâëåíèå */
	public function insert_page($arr)	{			
	$max = $this->db->result("Select max(`pos`) as `maxid` from `characteristics`");
	$max = $max[0]->maxid;
	$pos = $max+1; 
		$columns = 'pos';
		$values = "'$pos'";
		foreach($arr as $k=>$v){
		$columns .= ",`$k`";
		$values .= sprintf(",'%s'", $this->db->real_escape($v) );
		}
		$query = "INSERT INTO `characteristics` (".$columns.") VALUES (".$values.") ";
		$this->db->query($query);	
		return $this->db->last_id();
	}
	
	public function delete_product_characteristics($product_id)	{	
		$product_id = intval($product_id);
		if ($product_id>0){
		$query  = "DELETE FROM `characteristics_values` WHERE `product_id`='$product_id'"; 
		$this->db->query($query);
		}	
	}	

	public function insert_product_characteristics($characteristic,$product_id)	{
			if (!empty($characteristic)){
			foreach($characteristic as $v=>$p){
			if ($p){
			$c_id = sprintf("'%s'",  $this->db->real_escape($p));
			$query = "INSERT INTO `characteristics_values` (characteristic_id,product_id) VALUES ($c_id,'$product_id') ";
			$this->db->query($query);
			}
			}
			}
			return true;		
	}

	public function get_product_characteristics($filter)	{
		$product_id_filter = '';
			if(isset($filter['product_id']))
					$product_id_filter = sprintf(" AND product_id='%s'", $this->db->real_escape($filter['product_id']) );

		$query = "SELECT characteristic_id FROM `characteristics_values` WHERE 1 $product_id_filter";
		$cont = array();
		foreach($this->db->result($query) as $p){
			$cont[] = $p->characteristic_id;
		}
		return $cont;
	}
	public function get_characteristic_products($filter)	{
		$char_id_filter = '';
			if(isset($filter['char_id']))
					$char_id_filter = sprintf(" AND characteristic_id='%s'", $this->db->real_escape($filter['char_id']) );

		$query = "SELECT product_id FROM `characteristics_values` WHERE 1 $char_id_filter";
		$cont = array();
		foreach($this->db->result($query) as $p){
			$cont[] = $p->product_id;
		}
		return $cont;
	}
	
}
?>
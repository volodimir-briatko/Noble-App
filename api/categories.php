<?
class Categories extends godfather {


public function avtorise_category($id)	{
	$where_user_id = sprintf("AND id='%s'",  $this->db->real_escape($id));
	$query = "SELECT id,user_email,user_pass FROM `categories` WHERE vis='1' $where_user_id LIMIT 1";
	$cont = $this->db->result($query);
	return $cont[0];
}

public function get_category($id,$filter = array())	{
$parent_id_filter = '';
$vis_filter = '';
if(isset($filter['vis']))
			$vis_filter = sprintf(" AND vis='%s'", $this->db->real_escape($filter['vis']));
if(isset($filter['parent_id']))
			$parent_id_filter = sprintf(" AND parent_id='%s'", $this->db->real_escape($filter['parent_id']));			

if(gettype($id) == 'string')
			$where = sprintf("AND url='%s'",  $this->db->real_escape($id));
		else
			$where = sprintf("AND id='%s'",  $this->db->real_escape($id));

	$query = "SELECT * FROM `categories` WHERE 1 $vis_filter $parent_id_filter $where LIMIT 1";
$cont = $this->db->result($query);
return $cont[0];
	}

public function get_categories($filter = array())	{
	$vis_filter = '';
	$parent_filter = '';
	$parent_id_filter = '';
	$calc_filter = '';
	$ids_filter = '';
	$page_name_filter ='';
	$user_email_filter ='';

	if(isset($filter['page_name'])) {
			$page_name_filter =  sprintf("%s",  $this->db->real_escape($filter['page_name']));
			$page_name_filter = " AND page_name LIKE '%".$page_name_filter."%' ";	
		}
		if(!empty($filter['vis']))
			$vis_filter = sprintf(" AND vis='%s'",  $this->db->real_escape($filter['vis']));
		
		if(!empty($filter['calc']))
			$calc_filter = sprintf(" AND calc='%s'",  $this->db->real_escape($filter['calc']));	

		if(!empty($filter['user_email']))
			$user_email_filter = sprintf(" AND user_email='%s'",  $this->db->real_escape($filter['user_email']));	
		

		if(isset($filter['ids'])){
		if(empty($filter['ids'])){$filter['ids'] = array(0); }
			$ids_filter = " AND id IN (".implode(",", $filter['ids']).")";
			}
		
		
		if(!empty($filter['parent_id']))
			$parent_id_filter = sprintf(" AND parent_id='%s'",  $this->db->real_escape($filter['parent_id']));	

			$limit_filter = '';
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

	$query = "SELECT * FROM `categories` WHERE 1 $vis_filter $parent_filter $parent_id_filter $calc_filter $ids_filter $page_name_filter $user_email_filter ORDER BY $order $order_pos $limit_filter";

    $cont = $this->db->result($query);
return $cont;
	}
public function get_categories_count($filter = array())	{
	$vis_filter = '';
	$parent_filter = '';
	$parent_id_filter = '';
	$calc_filter = '';
	$ids_filter = '';
	$page_name_filter = '';	

	if(isset($filter['page_name'])) {
			$page_name_filter =  sprintf("%s",  $this->db->real_escape($filter['page_name']));
			$page_name_filter = " AND page_name LIKE '%".$page_name_filter."%' ";	
		}

		if(!empty($filter['vis']))
			$vis_filter = sprintf(" AND vis='%s'",  $this->db->real_escape($filter['vis']));
		
		if(!empty($filter['calc']))
			$calc_filter = sprintf(" AND calc='%s'",  $this->db->real_escape($filter['calc']));	
		
		if(isset($filter['ids'])){
		if(empty($filter['ids'])){$filter['ids'] = array(0); }
			$ids_filter = " AND id IN (".implode(",", $filter['ids']).")";
			}
		
		
		if(!empty($filter['parent_id']))
			$parent_id_filter = sprintf(" AND parent_id='%s'",  $this->db->real_escape($filter['parent_id']));	

	$query = "SELECT * FROM `categories` WHERE 1 $vis_filter $parent_filter $parent_id_filter $calc_filter $ids_filter $page_name_filter ";
 


$count = $this->db->rows_count($query);
return $count;
	}

	
	public function update_category($id, $arr)	{	
		$part = '';
		$i=0;
		foreach($arr as $k=>$v){
		if ($i>0){$part .= ",";}
		$part .= sprintf($k."='%s'", $this->db->real_escape($v));
		$i++;
		}
		$query = "UPDATE `categories` SET ".$part." WHERE id='$id'";
		$this->db->query($query);			
	}

public function insert_category($arr)	{			
$max = $this->db->result("Select max(`pos`) as `maxid` from `categories`");
$max = $max[0]->maxid;
$pos = $max+1; 

		$columns = 'pos';
		$values = "'$pos'";
		foreach($arr as $k=>$v){
		$columns .= ",".$k;
		$values .= sprintf(",'%s'",  $this->db->real_escape($v));
		}
		$query = "INSERT INTO `categories` (".$columns.") VALUES (".$values.") ";
		$this->db->query($query);	
		return $this->db->last_id();		
	}


public function get_categories_features($product_ids = array())	{

	$query = "SELECT * FROM `categories_features` WHERE product_id IN (".implode(",", $product_ids).")";
$cont = array();
foreach($this->db->result($query) as $p){
	$cont[] = $p->category_id;
}
return $cont;
	}

public function get_categories_products($id)	{	
	$where = sprintf("category_id='%s'",  $this->db->real_escape($id));
	$query = "SELECT product_id FROM `categories_features` WHERE $where";
$cont = array();
foreach($this->db->result($query) as $p){
	$cont[] = $p->product_id;
}

return $cont;
	}

public function delete_category_product($product_id)	{
	$category_id = intval($product_id);
	if ($product_id>0){

	$query  = sprintf("DELETE FROM `categories_features` WHERE product_id='%s'",  $this->db->real_escape($product_id));
	$this->db->query($query);
	}
}	
	
public function delete_category_feature($category_id)	{
	$category_id = intval($category_id);
	if ($category_id>0){
	$query  = "DELETE FROM `categories_features` WHERE category_id='$category_id'"; 
	$this->db->query($query);
	}
}

public function insert_categories_features($categories,$product_id)	{			
		if (!empty($categories)){
			foreach($categories as $v){
				$value = sprintf("'%s'",  $this->db->real_escape($v));
				$query  = sprintf("INSERT INTO `categories_features` (category_id,product_id) VALUES ($value,'%s') ",  $this->db->real_escape($product_id));
				$this->db->query($query);
			}
		}
		return true;		
	}	
public function del_page_file($id){
$arr = $this->get_category($id);
if ($arr){
	$pdf = $_SERVER['DOCUMENT_ROOT'].$this->projects_dir.'/'.$arr->pdf;
	if (file_exists($pdf)) {
		unlink($pdf);
	}
	$query = "UPDATE `categories` SET `pdf`='' WHERE id='$id'";
	$this->db->query($query);	
}
	
}	
}
?>
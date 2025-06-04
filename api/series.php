<?php
class series extends godfather
{

    public function get_sery($id, $filter = array())
    {

        $vis_filter = '';
        if (isset($filter['vis'])) $vis_filter = sprintf(" AND vis='%s'", $this
            ->db
            ->real_escape($filter['vis']));

        if (gettype($id) == 'string') $where = sprintf("AND url='%s'", $this
            ->db
            ->real_escape($id));
        else $where = sprintf("AND id='%s'", $this
            ->db
            ->real_escape($id));

        $query = "SELECT * FROM `series` WHERE 1 $vis_filter $where LIMIT 1";
        $cont = $this
            ->db
            ->result($query);
        return $cont[0];
    }

    public function get_series($filter = array())
    {
        $vis_filter = '';
        $group_filter = '';
        $id_filter = '';
        $zagolovok_filter = '';

        if (isset($filter['ids']))
        {
            if (empty($filter['ids']))
            {
                $filter['ids'] = array(
                    99999999
                );
            }
            $id_filter = " AND id IN (" . implode(",", $filter['ids']) . ")";
        }

        if (!empty($filter['group_id'])) $group_filter = sprintf(" AND groupa='%s'", $this
            ->db
            ->real_escape($filter['group_id']));

        if (!empty($filter['vis'])) $vis_filter = sprintf(" AND vis='%s'", $this
            ->db
            ->real_escape($filter['vis']));

        if (!empty($filter['zagolovok'])) $zagolovok_filter = sprintf(" AND zagolovok='%s'", $this
            ->db
            ->real_escape($filter['zagolovok']));

        $query = "SELECT * FROM `series` WHERE 1 $vis_filter $zagolovok_filter $group_filter $id_filter ORDER BY `pos` DESC";
        $cont = $this
            ->db
            ->result($query);
        return $cont;
    }

    public function update_sery($id, $arr)
    {
        $part = '';
        $i = 0;
        foreach ($arr as $k => $v)
        {
            if ($i > 0)
            {
                $part .= ",";
            }
            $part .= sprintf($k . "='%s'", $this
                ->db
                ->real_escape($v));
            $i++;
        }
        $query = "UPDATE `series` SET " . $part . " WHERE id='$id'";
        $this
            ->db
            ->query($query);
    }

    public function insert_sery($arr)
    {
        $max = $this
            ->db
            ->result("Select max(`pos`) as `maxid` from `series`");
        $max = $max[0]->maxid;
        $pos = $max + 1;

        $columns = 'pos';
        $values = "'$pos'";
        foreach ($arr as $k => $v)
        {
            $columns .= "," . $k;
            $values .= sprintf(",'%s'", $this
                ->db
                ->real_escape($v));
        }
        $query = "INSERT INTO `series` (" . $columns . ") VALUES (" . $values . ") ";
        $this
            ->db
            ->query($query);
        return $this
            ->db
            ->last_id();
    }

    public function get_series_features($product_ids = array())
    {

        $query = "SELECT * FROM `series_features` WHERE product_id IN (" . implode(",", $product_ids) . ")";
        $cont = array();
        foreach ($this
            ->db
            ->result($query) as $p)
        {
            $cont[] = $p->category_id;
        }
        return $cont;
    }

    public function get_series_products($id)
    {
        $query = "SELECT * FROM `series_features` WHERE category_id='$id'";
        $cont = array();
        foreach ($this
            ->db
            ->result($query) as $p)
        {
            $cont[] = $p->product_id;
        }

        return $cont;
    }

    public function delete_sery_feature($category_id)
    {
        $category_id = intval($category_id);
        if ($category_id > 0)
        {
            $query = "DELETE FROM `series_features` WHERE category_id='$category_id'";
            $this
                ->db
                ->query($query);
        }
    }

    public function insert_series_features($series, $product_id)
    {

        if (!empty($series))
        {
            foreach ($series as $v)
            {
                $value = sprintf("'%s'", $this
                    ->db
                    ->real_escape($v));
                $query = "INSERT INTO `series_features` (category_id,product_id) VALUES ($value,'$product_id') ";
                $this
                    ->db
                    ->query($query);
            }
        }
        return true;
    }
    public function del_page_file($id)
    {
        $arr = $this->get_category($id);
        if ($arr)
        {
            $pdf = $_SERVER['DOCUMENT_ROOT'] . $this->projects_dir . '/' . $arr->pdf;
            if (file_exists($pdf))
            {
                unlink($pdf);
            }
            $query = "UPDATE `series` SET `pdf`='' WHERE id='$id'";
            $this
                ->db
                ->query($query);
        }

    }
}
?>

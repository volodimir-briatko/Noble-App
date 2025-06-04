<?php
require_once ('godfather.php');
class Groups extends godfather
{

    /* âûâîä èòåìà */
    public function get_page($id, $filter = array())
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

        $query = "SELECT * FROM `groups` WHERE 1 " . $vis_filter . " " . $where . " LIMIT 1";
        $cont = $this
            ->db
            ->result($query);
        return $cont[0];
    }

    /* âûâîä èòåìîâ */
    public function get_pages($filter = array())
    {

        $inmenu_filter = '';
        $vis_filter = '';
        $category_filter = '';
        $date_from_filter = '';
        $date_to_filter = '';
        $ids_filter = '';
        $page_names_filter = '';

        if (!empty($filter['ids']))
        {
            $ids_filter = implode(",", $filter['ids']);
            $ids_filter = sprintf(" AND id IN (%s)", $this
                ->db
                ->real_escape($ids_filter));
        }
        if (!empty($filter['filter_page_names']))
        {
            $page_names_filter = " AND page_name IN ('" . implode("','", $filter['filter_page_names']) . "')";
        }

        if (isset($filter['date_from'])) $date_from_filter = sprintf(" AND dateS>='%s'", $this
            ->db
            ->real_escape($filter['date_from']));

        if (isset($filter['date_to'])) $date_to_filter = sprintf(" AND dateS<='%s'", $this
            ->db
            ->real_escape($filter['date_to']));

        if (isset($filter['inmenu'])) $inmenu_filter = sprintf(" AND inmenu='%s'", $this
            ->db
            ->real_escape($filter['inmenu']));

        if (isset($filter['category_id'])) $category_filter = sprintf(" AND category='%s'", $this
            ->db
            ->real_escape($filter['category_id']));

        if (isset($filter['vis'])) $vis_filter = sprintf(" AND vis='%s'", $this
            ->db
            ->real_escape($filter['vis']));

        if (isset($filter['order']) && !empty($filter['order']))
        {
            $order = $filter['order'];

        }
        else
        {
            $order = 'id';
        }

        if (isset($filter['order_pos']))
        {

            $order_pos = $filter['order_pos'];
        }
        else $order_pos = 'DESC';

        $query = "SELECT * FROM `groups` WHERE 1 $ids_filter $page_names_filter $inmenu_filter $vis_filter $category_filter $date_from_filter $date_to_filter ORDER BY $order $order_pos";

        $cont = $this
            ->db
            ->result($query);
        return $cont;
    }

    public function get_pages_count($filter = array())
    {

        $inmenu_filter = '';
        $vis_filter = '';
        $category_filter = '';
        $date_from_filter = '';
        $date_to_filter = '';

        if (isset($filter['date_from'])) $date_from_filter = sprintf(" AND dateS>='%s'", $this
            ->db
            ->real_escape($filter['date_from']));

        if (isset($filter['date_to'])) $date_to_filter = sprintf(" AND dateS<='%s'", $this
            ->db
            ->real_escape($filter['date_to']));

        if (isset($filter['inmenu'])) $inmenu_filter = sprintf(" AND inmenu='%s'", $this
            ->db
            ->real_escape($filter['inmenu']));

        if (isset($filter['category_id'])) $category_filter = sprintf(" AND category='%s'", $this
            ->db
            ->real_escape($filter['category_id']));

        if (isset($filter['vis'])) $vis_filter = sprintf(" AND vis='%s'", $this
            ->db
            ->real_escape($filter['vis']));

        $query = "SELECT * FROM `groups` WHERE 1 $inmenu_filter $vis_filter $category_filter $date_from_filter $date_to_filter ";

        $count = $this
            ->db
            ->rows_count($query);
        return $count;
    }

    /* îáíîâëåíèå */
    public function update_page($id, $arr)
    {
        $part = '';
        $i = 0;
        foreach ($arr as $k => $v)
        {
            if ($i > 0)
            {
                $part .= ",";
            }
            $part .= sprintf("`$k`" . "='%s'", $this
                ->db
                ->real_escape($v));
            $i++;
        }
        $query = "UPDATE `groups` SET " . $part . " WHERE `id`='$id'";
        $this
            ->db
            ->query($query);
    }

    /* äîáàâëåíèå */
    public function insert_page($arr)
    {
        $max = $this
            ->db
            ->result("Select max(`pos`) as `maxid` from `groups`");
        $max = $max[0]->maxid;
        $pos = $max + 1;
        $columns = 'pos';
        $values = "'$pos'";
        foreach ($arr as $k => $v)
        {
            $columns .= ",`$k`";
            $values .= sprintf(",'%s'", $this
                ->db
                ->real_escape($v));
        }
        $query = "INSERT INTO `groups` (" . $columns . ") VALUES (" . $values . ") ";
        $this
            ->db
            ->query($query);
        return $this
            ->db
            ->last_id();
    }

}
?>

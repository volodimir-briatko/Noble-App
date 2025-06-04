<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/api/godfather.php');

class Images extends godfather
{

    public function get_image($id, $filter = array())
    {
        $vis_filter = '';
        if (isset($filter['vis'])) $vis_filter = sprintf(" AND vis='%s'", $this
            ->db
            ->real_escape($filter['vis']));

        $where = sprintf("AND id='%s'", $this
            ->db
            ->real_escape($id));

        $query = "SELECT * FROM `images` WHERE 1 " . $vis_filter . " " . $where . " LIMIT 1";

        $cont = $this
            ->db
            ->result($query);
        return $cont[0];
    }

    public function get_images($filter = array())
    {
        $vis_filter = '';
        $product_ids_filter = '';
        $limit_filter = '';

        if (isset($filter['vis'])) $vis_filter = sprintf(" AND vis='%s'", $this
            ->db
            ->real_escape($filter['vis']));

        if (isset($filter['limit'])) $limit_filter = " LIMIT 0," . $filter['limit'];

        if (isset($filter['limit_srart']) && isset($filter['limit'])) $limit_filter = " LIMIT " . $filter['limit_srart'] . "," . $filter['limit'];

        $query = "SELECT * FROM `images` WHERE 1  $vis_filter ORDER BY pos DESC $limit_filter";
        $cont = $this
            ->db
            ->result($query);
        return $cont;
    }

    public function update_image($id, $arr)
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
        $query = "UPDATE `images` SET " . $part . " WHERE id='$id'";
        $this
            ->db
            ->query($query);
    }

    public function insert_image($arr)
    {
        $max = $this
            ->db
            ->result("Select max(`pos`) as `maxid` from `images`");
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
        $query = "INSERT INTO `images` (" . $columns . ") VALUES (" . $values . ") ";
        $this
            ->db
            ->query($query);
        return $this
            ->db
            ->last_id();
    }

    public function delete_images($id)
    {

        $image = $this->get_image($id);

        $dir = $_SERVER['DOCUMENT_ROOT'] . $this->fotos_dir;
        /*
        $filename3 = $dir.$image->image3;
        
        if (file_exists($filename3)) {
        unlink($filename3);
        }
        
        $filename2 = $dir.$image->image2;
        if (file_exists($filename2)) {
        unlink($filename2);
        }
        */
        $filename1 = $dir . $image->image1;
        if (file_exists($filename1))
        {
            unlink($filename1);
        }
    }

    public function upload_image($file, $width = 2500)
    {
        $dir = $_SERVER['DOCUMENT_ROOT'] . $this->fotos_dir;
        $valid_types = array(
            "gif",
            "jpg",
            "png",
            "jpeg",
            "JPEG",
            "GIF",
            "JPG",
            "PNG",
            "swf",
            "SWF"
        );
        $ext = substr($file['name'], 1 + strrpos($file['name'], "."));
        if (!in_array($ext, $valid_types))
        {
            echo '<script type="text/javascript">
			alert("eror file format!");
location.replace(window.location.href);
</script>';
            exit;
        }
        $name_of = $file["name"];
        $name_of = strrchr($name_of, ".");
        $string = str_replace($name_of, '', $file['name']);
        $string = $this->rus2translit($string);
        if (file_exists($dir . $string . $name_of))
        {
            for ($counter = 1;$counter < 10000;$counter++)
            {
                $filename = $dir . $string . '-' . $counter . $name_of;
                if (!file_exists($filename))
                {
                    $fname = $string . '-' . $counter . $name_of;
                    break;
                }
            }
        }
        else
        {
            $filename = $dir . $string . $name_of;
            $fname = $string . $name_of;
        }

        if (copy($file["tmp_name"], $filename))
        {
            $source = $filename;

            $sizeArr = GetImageSize($source);

            $iw = $sizeArr[0];
            $ih = $sizeArr[1];

            if ($iw <= $width)
            {
                $newWidth = $iw;
                $new_h = $ih;
            }
            else
            {
                $newWidth = $width;
                $new_h = $ih * $newWidth / $iw;
                $type = $sizeArr[2];
                if ($type == 1)
                {
                    $src = imagecreatefromgif($source);
                }
                else if ($type == 2)
                {
                    $src = imagecreatefromjpeg($source);
                }
                else if ($type == 3)
                {
                    $src = imagecreatefrompng($source);
                }
                else return;
                $dst = imagecreatetruecolor($newWidth, $new_h);
                imagesavealpha($dst, true);
                imagefill($dst, 0, 0, imagecolorallocatealpha($dst, 0, 0, 0, 127));
                ImageCopyResampled($dst, $src, 0, 0, 0, 0, $newWidth, $new_h, ImageSX($src) , ImageSY($src));
                if ($type == 1)
                {
                    imagegif($dst, $source);
                }
                else if ($type == 2)
                {
                    imagejpeg($dst, $source, 90);
                }
                else if ($type == 3)
                {
                    imagepng($dst, $source, 0);
                }
                else return;
            }
            $fname = str_replace('---', '-', $fname);
            $fname = str_replace('--', '-', $fname);
            return $fname;

        }
        else
        {
            echo ("Error!");
        }
    }

    public function upload_file($file)
    {
        $dir = $_SERVER['DOCUMENT_ROOT'] . $this->projects_dir;

        $name_of = $file["name"];
        $name_of = strrchr($name_of, ".");
        $string = str_replace($name_of, '', $file['name']);
        $string = $this->rus2translit($string);
        if (file_exists($dir . $string . $name_of))
        {
            for ($counter = 1;$counter < 10000;$counter++)
            {
                $filename = $dir . $string . '-' . $counter . $name_of;
                if (!file_exists($filename))
                {
                    $fname = $string . '-' . $counter . $name_of;
                    break;
                }
            }
        }
        else
        {
            $filename = $dir . $string . $name_of;
            $fname = $string . $name_of;
        }
        if (copy($file["tmp_name"], $filename))
        {
            $fname = str_replace('---', '-', $fname);
            $fname = str_replace('--', '-', $fname);
            return $fname;
        }
        else
        {
            echo ("Error!");
        }
    }

    public function rus2translit($string)
    {
        $converter = array(
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'e',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'y',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'ц' => 'c',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'shch',
            'ь' => '',
            'ы' => 'y',
            'ъ' => '',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
            'А' => 'A',
            'Б' => 'B',
            'В' => 'V',
            'Г' => 'G',
            'Д' => 'D',
            'Е' => 'E',
            'Ё' => 'E',
            'Ж' => 'Zh',
            'З' => 'Z',
            'И' => 'I',
            'Й' => 'Y',
            'К' => 'K',
            'Л' => 'L',
            'М' => 'M',
            'Н' => 'N',
            'О' => 'O',
            'П' => 'P',
            'Р' => 'R',
            'С' => 'S',
            'Т' => 'T',
            'У' => 'U',
            'Ф' => 'F',
            'Х' => 'H',
            'Ц' => 'C',
            'Ч' => 'Ch',
            'Ш' => 'Sh',
            'Щ' => 'Shch',
            'Ь' => '',
            'Ы' => 'Y',
            'Ъ' => '',
            'Э' => 'E',
            'Ю' => 'Yu',
            'Я' => 'Ya',
        );
        $url = strtr($string, $converter);
        $url = preg_replace("|[^\d\w ]+|i", "-", $url);
        $url = strtolower($url);
        $url = str_replace(" ", "-", $url);
        return $url;
    }

}
?>

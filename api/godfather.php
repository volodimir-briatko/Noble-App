<?
class Godfather
{

	// Классы API
	private $classes = array(
		'db' => 'db',
		'products'   => 'products',
		'categories' => 'categories',
		'characteristics' => 'characteristics',
		'groups' => 'groups',
		'series' => 'series',
		'images' => 'images'
	);
	
	// Созданные объекты
	private static $objects = array();
	
	/**
	 * Конструктор 
	 */
	public function __construct()
	{	}

	/**
	 * Магический метод, создает нужный объект API
	 */
	public function __get($name)
	{
		// Если такой объект уже существует, возвращаем его
		if(isset(self::$objects[$name]))
		{
			return(self::$objects[$name]);
		}
		
		// Если запрошенного API не существует - ошибка
		if(!array_key_exists($name, $this->classes))
		{
			return null;
		}
		
		// Определяем имя нужного класса
		$class = $this->classes[$name];
		
		// Подключаем его
		include_once($_SERVER['DOCUMENT_ROOT'].'/api/'.$class.'.php');
		
		// Сохраняем для будущих обращений к нему
		if ($name=='sendmailsmtpclass'){
		self::$objects[$name] = new $class('xxx@yandex.ru', 'xxx', 'ssl://smtp.yandex.ru', 'noble', 465);
		}
		else {
		self::$objects[$name] = new $class();
		}
		
		// Возвращаем созданный объект
		return self::$objects[$name];
	}

var $fotos_dir = "/files/";
var $big_foto_dir = "/files/";
var $projects_dir = "/admin/langs/";


//очистить переменную
public function prepare_var($p)	{
	$p = strip_tags ($p);
	$p = trim($p);
	$p = htmlspecialchars($p, ENT_QUOTES);
	return $p;
}

//вывод настроек
public function settings()	{
	$query = "SELECT * FROM `settings` WHERE id='1' LIMIT 1";
	$cont = $this->db->result($query);
	return $cont[0];
}

//обновить настройки
public function update_settings($id, $arr)	{	
		$part = '';
		$i=0;
		foreach($arr as $k=>$v){
		if ($i>0){$part .= ",";}
		$part .= sprintf($k."='%s'", $this->db->real_escape($v));
		$i++;
		}
		$query = "UPDATE `settings` SET ".$part." WHERE id='$id'";
		$this->db->query($query);		
}

//отправка письма
public function send_letter($html,$subject,$from='',$to='')	{
	$settings = $this->settings();
	if ($to==''){
		$to = $settings->admin_email;
	}
	if ($from==''){
		$from = $to;
	}
	$headers  = "Content-type: text/html; charset=utf-8 \r\n";
	$headers .= "From: <$from>\r\n";
	$sucess=mail($to, $subject, $html, $headers);
	}

	//отправка письма
public function send_letter_smtp($message,  $subject, $to)	{
	$settings = $this->settings();
	$admin_email = 'xxx@yandex.ru' ;

	$headers= "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\r\n"; // кодировка письма
	$headers .= "From: units.bz <$admin_email>\r\n"; // от кого письмо !!! тут e-mail, через который происходит авторизация
	$headers .= "To: <$to>\r\n"; //
	
 		$contentMail = "Date: " . date("D, d M Y H:i:s") . " UT\r\n";
        $contentMail .= 'Subject: =?' . $this->sendmailsmtpclass->smtp_charset . '?B?'  . base64_encode($subject) . "=?=\r\n";
        $contentMail .= $headers . "\r\n";
        $contentMail .= $message . "\r\n";	
		$result =  $this->sendmailsmtpclass->send($to, $subject, $contentMail); // отправляем письмо
		
		//echo $result;
	return 1;
	}
	
//clean danger artefacts from url
public function clean_url($url){	
$url = strip_tags ($url);
$url = htmlspecialchars($url, ENT_QUOTES);
$url = str_replace('"','',$url);
$url = str_replace("'",'',$url);
$url = str_replace("/",'',$url);
return $url;
}	

//word depending on the number
public function getInclinationByNumber($number, $arr = Array()) {
    $number = (string) $number;
    $numberEnd = substr($number, -2);
    $numberEnd2 = 0;
    if(strlen($numberEnd) == 2){
        $numberEnd2 = $numberEnd[0];
        $numberEnd = $numberEnd[1];
    }
    if ($numberEnd2 == 1) return $arr[2];
    else if ($numberEnd == 1) return $arr[0];
    else if ($numberEnd > 1 && $numberEnd < 5)return $arr[1];
    else return $arr[2];
}
	
//пейджинг
public function paging($page_number,$items_count){
	$products_on_page = $this->settings()->products_on_page;
	$page_length = ceil($items_count/$products_on_page);
$paging_list = array();

if($page_number<4){
for ($i=1; $i<5; $i++){
	if ($page_length>=$i){
		$paging_list[] = array('text'=>$i,'link'=>$i);
	}
}
	if ($page_length>5){
	$paging_list[] = array('text'=>'...','link'=>5);
	}
	if ($page_length>4){
	$paging_list[] = array('text'=>$page_length,'link'=>$page_length);
	}
}
else if ($page_number>$page_length-3){
if ($page_length>4){
	$paging_list[] = array('text'=>1,'link'=>1);
}
if ($page_length>5){
	$paging_list[] = array('text'=>'...','link'=>($page_length-4));
	}
for ($i=($page_length-3); $i<($page_length+1); $i++){
	$paging_list[] = array('text'=>$i,'link'=>$i);
}
}
else {
$paging_list[] = array('text'=>1,'link'=>1);
$paging_list[] = array('text'=>'...','link'=>($page_number-2));
$paging_list[] = array('text'=>($page_number-1),'link'=>($page_number-1));
$paging_list[] = array('text'=>$page_number,'link'=>$page_number);
$paging_list[] = array('text'=>($page_number+1),'link'=>($page_number+1));
$paging_list[] = array('text'=>'...','link'=>($page_number+2));
$paging_list[] = array('text'=>$page_length,'link'=>$page_length);
		}


if (!empty($_GET['str'])){
	$current_str = intval($_GET['str']);
	$prev_str = intval($_GET['str'])-1;
	if ($prev_str<1) $prev_str = 1;
	$next_str = intval($_GET['str'])+1;
} else {
	$current_str = 1;
	$prev_str = 1;
	$next_str = 2;
}
if ($page_length<$next_str) $next_str = $page_length;

$pagination = array(
	'list' => $paging_list,
	'prev_str' => $prev_str,
	'next_str' => $next_str,
	'current_str' => $current_str
);

		return $pagination;
}
//пейджинг END
	public function rus_monthes($num){	
		$monthes = array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря' );
		return $monthes[$num];
		}

	//хешировать пароль
	public	function crypt_apr1_md5($plainpasswd) {
	    $salt = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8);
	    $len = strlen($plainpasswd);
	    $text = $plainpasswd.'$apr1$'.$salt;
	    $bin = pack("H32", md5($plainpasswd.$salt.$plainpasswd));
	    for($i = $len; $i > 0; $i -= 16) { $text .= substr($bin, 0, min(16, $i)); }
	    for($i = $len; $i > 0; $i >>= 1) { $text .= ($i & 1) ? chr(0) : $plainpasswd{0}; }
	    $bin = pack("H32", md5($text));
	    for($i = 0; $i < 1000; $i++) {
	        $new = ($i & 1) ? $plainpasswd : $bin;
	        if ($i % 3) $new .= $salt;
	        if ($i % 7) $new .= $plainpasswd;
	        $new .= ($i & 1) ? $bin : $plainpasswd;
	        $bin = pack("H32", md5($new));
	    }
	    for ($i = 0; $i < 5; $i++) {
	        $k = $i + 6;
	        $j = $i + 12;
	        if ($j == 16) $j = 5;
	        $tmp = $bin[$i].$bin[$k].$bin[$j].$tmp;
	    }
	    $tmp = chr(0).chr(0).$bin[11].$tmp;
	    $tmp = strtr(strrev(substr(base64_encode($tmp), 2)),
	    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",
	    "./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz");
	    return "$"."apr1"."$".$salt."$".$tmp;
	}

}
?>
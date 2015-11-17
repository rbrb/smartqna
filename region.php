<?

require 'rb-p533.php';
/*
| 강원   |
| 경기   |
| 경남   |
| 경북   |
| 광주   |
| 대구   |
| 대전   |
| 부산   |
| 서울   |
| 세종   |
| 울산   |
| 인천   |
| 전남   |
| 전북   |
| 제주   |
| 충남   |
| 충북   |
*/
R::setup( 'mysql:host=localhost;dbname=smartqna',
					'root', 'denters0318' ); 

$region= R::dispense('region');

$region->lv0='string';
$region->lv1='string';

setUnique($region, array('lv0', 'lv1'));
safeStore($region);

function safeStore($obj)
{
	try {
		$id	= R::store($obj);
		echo "saved id [$id]";
	} catch (RedBeanPHP\RedException\SQL $e) {
		echo "failed: $e<br><br>";
	}
}

function setUnique($bean, $arr)
{
	$bean->setMeta("buildcommand.unique" , array($arr));
}
?>

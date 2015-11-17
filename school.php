<?

require 'rb-p533.php';

R::setup( 'mysql:host=localhost;dbname=smartqna',
					'root', 'denters0318' ); 

$school= R::dispense('school');

$school->year='string';
$school->sch_grade='string';
$school->sch_type='string';
$school->lv0='string';
$school->edu_dept='string';
$school->lv1='string';
$school->name='string';
$school->origin='string';
$school->status='string';
$school->establish='string';
$school->postal='string';
$school->address='string';
$school->phone='string';
$school->fax='string';
$school->homepage	='string';

safeStore($school);

function safeStore($obj)
{
	try {
		$id	= R::store($obj);
		echo "saved id [$id]";
	} catch (RedBeanPHP\RedException\SQL $e) {
		echo "failed: $e<br><br>";
	}
}

?>

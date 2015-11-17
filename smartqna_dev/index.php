<?php 
require 'Slim/Slim.php';
require 'rb-p533.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, X-Titanium-Id, Content-Type, Accept");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Credentials: true");

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

R::setup( 'mysql:host=localhost;dbname=smartqna',
					'root', 'denters0318' ); 

$app->options('/mentors/:id',function() use ($app){ });
$app->options('/book/:id',function() use($app){ });
$app->options('/school',function() use($app){ });

$app->get('/init', function() use ($app){

	//user
	$user = R::dispense('user');

	$user->uid 				= 'test';
	$user->pass				= '0318';

	$user->name 			= 'name';
	$user->orgname 		= 'org';

	$user->regtime 		= 0;

	$user->expdate 		= 0;
	$user->democnt 		= 5;

	$user->usertype		= 0; //0: demo, 1:paid=>expired, 2:paid=>not expired, 10: publisher, 20: master

	setUnique($user, array('uid'));
	safeStore($user);

	//book
	$book = R::dispense('book');

	$book->name				= 'EBS수1적분과통계';
	$book->publisher	= 'EBS';

	setUnique($book, array('name'));
	safeStore($book);

	$book->name				= 'EBS수2미분과적분';
	$book->publisher	= 'EBS';
	
	//setUnique($book, array('name'));
	safeStore($book);

	//mentor
	$mentor = R::dispense('mentor');

	$mentor->name				= '곽동녘';
	$mentor->dept				= '연세대';
	$mentor->imgurl			= 'http://venusproject.co.kr/smartqna/data/img/mentor/001.jpg';
	$mentor->motto			= 'be the best';
	$mentor->msg				= 'fighting!';

	safeStore($mentor);

	$map = R::dispense('mentor2book');
	$map->mentorid = 1;
	$map->bookid = 4;

	setUnique($map, array('mentorId','bookId'));
	safeStore($map);

});

$app->post('/login', function() use ($app){
	$body = $app->request->getBody();
	$json = json_decode($body);
	$uid 	= $json->{'uid'};
	$pass	= $json->{'pass'};

	$user = R::findOne( 'user', "uid = '$uid' AND pass = PASSWORD('$pass')" );
	if(isset($user)){
		success(R::exportAll($user));
	} else {
		fail("id/pass mismatch, body:$body");
	}
});

$app->post('/signup', function() use ($app){
	$body = $app->request->getBody();
	$json = json_decode($body);
	$uid = $json->{'uid'};
	$pass = $json->{'pass'};
	$name = $json->{'name'};
	$orgname = $json->{'orgname'};
	try{
		$existUser = R::findOne('user',"uid = '$uid'");
	}catch(RedBeanPHP\RedException\SQL $e){
		fail($e);
	}
	if($existUser){
		fail("exist id, body : $body");	
	}
	$user = R::dispense('user');
	$user->uid = $uid;
	$user->name = $name;
	$user->orgname = $orgname;
	$user->regtime = date('Y-m-d');
	$user->democnt = 5;
	safeStore($user);
	try{
		R::exec("UPDATE user SET pass = PASSWORD('$pass') WHERE uid ='$uid'");
	}catch(RedBeanPHP\RedException\SQL $e){
		fail($e);
	}
});
$app->get('/user',function() use ($app){
	$user = R::findAll('user');
	success(R::exportAll($user));
});
$app->put('/user/:id',function() use ($app){
	$json = $app->request->getBody();
	$obj  = json_decode($json);
	$updateSet = "";
	foreach($obj as $key =>$value){
		$updateSet .= "$key = '$value', ";
	}
	$updateSet = substr_replace($updateSet,"",-2);
	try{
		R::exec("UPDATE user SET $updateSet WHERE id = '$id'");	
	}catch(RedBeanPHP\RedException\SQL $e){
		fail($e);
	} 
});
$app->get('/book', function() use ($app){
	$books = R::findAll('book');
	success(R::exportAll($books));
});

$app->post('/book', function() use ($app){
	$name = $app->request()->post("name");	
	$publisher = $app->request()->post("publisher");
	$book_mentor = $app->request()->post("book_mentor");
	$path_part = pathinfo($_FILES['file']['name']);
	$filedir = "/mnt/data/smartqna/".$_FILES['file']['name'];
	$status = 1;
	if($path_part['extension']!='zip'){
		echo "zip 파일만가능합니다.";
		return;
	}
	if($_FILES["file"]["error"]>0){
		echo "return code : ".$_FILES["file"]["error"]."<br>";
		$status = 0;
	}
	move_uploaded_file($_FILES['file']['tmp_name'],$filedir);	
	if($status){
		$localPath =$filedir;
		$book = R::dispense('book');
		$book->name = $name;
		$book->publisher = $publisher;
		$book->localPath = $localPath;
		safeStore($book);
	}

});

$app->put('/book/:id', function($id) use ($app){
	$json = $app->request->getBody();
	$obj  = json_decode($json);
	$updateSet = "";
	foreach($obj as $key =>$value){
		$updateSet .= "$key = '$value', ";
	}
	$updateSet = substr_replace($updateSet,"",-2);
	try{
		R::exec("UPDATE book SET $updateSet WHERE id = '$id'");	
	}catch(RedBeanPHP\RedException\SQL $e){
		fail($e);
	}
});
$app->delete('/book/:id', function($id) use ($app){
	try{
		R::exec("DELETE FROM book WHERE id ='$id'");
	}catch(RedBeanPHP\RedException\SQL $e){
		fail($e);
	}
});

$app->get('/mentors',function() use ($app){
	$mentor = R::findAll('mentor');
	success(R::exportAll($mentor));
});
$app->get('/mentors:id',function() use($app){

	$mentor = R::findOne( 'mentor', "id = '$id'" );
	if(isset($mentor)){
		success(R::exportAll($mentor));
	} else {
		fail("no mentor exist, body:$body");
	}

});
$app->post('/mentors',function() use ($app){
	
	$name = $app->request()->post('name');
	$dept = $app->request()->post('dept');
	$motto = $app->request()->post('motto');
	$msg = $app->request()->post('msg');
	$path_part = pathinfo($_FILES['file']['name']);
	$filedir = "upload_image/".$_FILES['file']['name'];
	
	$status = 1;
	if($path_part['extension']!='jpg'&&$path_part['extension']!='png'){
		echo "jpg 또는 png 파일만가능합니다.";
		return;
	}
	if($_FILES["file"]["error"]>0){
		echo "return code : ".$_FILES["file"]["error"]."<br>";
		$status = 0;
	}
	move_uploaded_file($_FILES['file']['tmp_name'],$filedir);	
	if($status){
		$imgurl = "http://fccrm.co.kr/smartqna/".$filedir;
		$mentor = R::dispense('mentor');
		$mentor->name = $name;
		$mentor->dept = $dept;
		$mentor->imgurl = $imgurl;
		$mentor->motto  = $motto;
		$mentor->msg   =  $msg;

		safeStore($mentor);
	}
});
$app->put('/mentors/:id',function($id) use ($app){
	$json = $app->request->getBody();
	$obj  = json_decode($json);
	$updateSet = "";
	foreach($obj as $key =>$value){
		$updateSet .= "$key = '$value', ";
	}
	$updateSet = substr_replace($updateSet,"",-2);
	try{
		R::exec("UPDATE mentor SET $updateSet WHERE id = '$id'");	
	}catch(RedBeanPHP\RedException\SQL $e){
		fail($e);	
	}

});
$app->delete('/mentors/:id', function($id) use ($app){
	try{
		R::exec("DELETE FROM mentor WHERE id ='$id'");
	}catch(RedBeanPHP\RedException\SQL $e){
		fail($e);
	}
});


$app->get('/mentor', function() use ($app){
	$mentors = R::findAll('mentor');

	foreach($mentors as $mentor)
	{
		$mentorId = $mentor->id;
		$sql = "SELECT
			book.name, mentor.name from book, mentor, mentor2book
				where book.id = mentor2book.bookid
				and mentor2book.mentorid = $mentorId";
		$bookNames = (R::getAll($sql));
		$mentor->booknames = extArrElem($bookNames, 'name');
	}
	success(R::exportAll($mentors));
});

$app->post('/mentor',function() use ($app){
	$json = $app->request->getBody();
	$obj = json_decode($json);
	
	$mid = $obj->{'mentorid'};
	$bid = $obj->{'bookid'};
	
	$mentor2book = R::dispense('mentor2book');
	$mentor2book->mentorid = $mid;
	$mentor2book->bookid = $bid;
	safeStore($mentor2book);		
});

$app->delete('/mentor',function() use ($app){
	$mid = $app->request->get('mentorid');
	$bid = $app->request->get('bookid');
	try{
		R::exec("DELETE FROM mentor2book WHERE mentorid ='$mid' AND bookid = '$bid'");
	}catch(RedBeanPHP\RedException\SQL $e){
		fail($e);
	}
});

$app->get('/school',function() use ($app){
	$lv0 = $app->request->get('lv0');
	$lv1 = $app->request->get('lv1');

	//echo "$lv0 $lv1";

	try{
		$schools = R::find('school', "lv0='$lv0' AND lv1='$lv1'");
		success(R::exportAll($schools));
	}catch(RedBeanPHP\RedException\SQL $e){
		fail($e);
	}
});

/*
$app->get('/contract',function() use ($app){
	$contract = R::findAll('contract');
	success(R::exportAll($contract));
});
*/

$app->get('/contract/:aid',function($aid) use ($app){
	$sql 	= "select contract.*, school.name from contract join school where contract.sid = school.id";
	$rows = R::getAll($sql);
	$contract = R::convertToBeans('contract', $rows);
	success(R::exportAll($contract));
});

$app->get('/contract/:aid/:month',function($aid, $month) use ($app){
	$cond = " AND ( MONTH(date_start)<=$month OR $month<=MONTH(date_end))";
	$sql 	= "select contract.*, school.name from contract join school where contract.sid = school.id"
					.$cond;
	$rows = R::getAll($sql);
	$contract = R::convertToBeans('contract', $rows);
	success(R::exportAll($contract));
});

$app->get('/contract_sum/:aid/:month',function($aid, $month) use ($app){
/*
	$rows = R::exec( //bug?
		"select sum(price) from contract" );
//		."where aid='$aid' AND ( MONTH(date_start)=$month OR MONTH(date_end)=$month ) ");
	var_dump($rows);
	echo $rows;
*/

	$rows = R::find('contract', 
		"aid='$aid' AND ( MONTH(date_start)=$month OR MONTH(date_end)=$month ) ");

	$sum = 0;
	foreach($rows as $row){
		$sum += $row->price;
	}

	success(array('month'=>$month,'sum'=>$sum));
});

$app->post('/contract',function() use ($app){
	$id					= $app->request->post('id');
	$sid				= $app->request->post('sid');
	$aid				= $app->request->post('aid');
	$price			= $app->request->post('price');
	$date_start	= $app->request->post('date_start');
	$date_end		= $app->request->post('date_end');

	if($aid==null)
		fail("aid is null");

	try{
		$contract = R::dispense('contract');
		$contract->id					= $id;
		$contract->sid				= $sid;
		$contract->aid 				= $aid;
		$contract->price 			= $price;
		$contract->date_start = $date_start;
		$contract->date_end 	= $date_end;

		safeStore($contract);
		success('');
	}catch(RedBeanPHP\RedException\SQL $e){
		fail($e);
	}
});

$app->get('/agent',function() use ($app){
	$agent = R::findAll('agent');
	success(R::exportAll($agent));
});
$app->post('/agent',function() use ($app){
	$json = $app->request->getBody();
	$obj = json_decode($json);
	$aid = $obj->{'aid'};
	$fee = $obj->{'fee'};
	$sql = "UPDATE agent SET fee = '$fee' WHERE aid = '$aid'";
	try{
		R::exec($sql);
	}catch(RedBeanPHP\RedException\SQL $e){
		fail($e);
	}
});

$app->get('/schoolContract',function() use($app){

 $sql = "select agent.oname as oname, contract.price as price, school.* from contract".
        " join agent on agent.aid = contract.aid join school on school.id = contract.sid";
 try{
        $result = R::getAll($sql);
		$data = R::convertToBeans('contract',$result);
		success(R::exportAll($data));
 }catch(RedBeanPHP\RedException\SQL $e){
    fail($e);
 }

});
$app->get('/student/:id',function() use($app){
//  R::find('user',)

});

$app->get('/',function() use ($app){
	$center = 'style="display:block; height:100%; margin-left:auto; margin-right:auto"';
	echo "<a href='login.php'><img src=intro/toonysam.jpg $center></a>";
});


function setUnique($bean, $arr)
{
	$bean->setMeta("buildcommand.unique" , array($arr));
}


function safeStore($obj)
{
	try {
		$id	= R::store($obj);
		echo "saved id [$id]";
	} catch (RedBeanPHP\RedException\SQL $e) {
		echo "failed: $e<br><br>";
	}
}

function extArrElem($arr, $key)
{
	$retArr = Array();

	$i=0;
	foreach($arr as $elem)
		$retArr[$i++] = $elem[$key];

	return $retArr;
}

$app->run();

function success($obj){
	echo json_encode(array('success'=>'ok', 'data'=>$obj));
}

function fail($msg){
	echo json_encode(array('success'=>'fail', 'msg'=>$msg));
	exit(-1);
}

?>

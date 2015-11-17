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
/*
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
*/
});

$app->post('/login', function() use ($app){
	$body  = $app->request->getBody();
    $json = json_decode($body);
    $uid  = $json->{'uid'};
    $pass = $json->{'pass'};
		if(property_exists($json, 'hp'))
		{
			$hp 	= $json->{'hp'};
			if(strpos($hp,'+82')!==false){
				$hp = str_replace("+82","0",$hp);
			}
		}
	
//	error_log("login_error:$uid:$hp", 3, "temp_error.log");
    $user = R::findOne( 'user', "uid = '$uid' AND pass = PASSWORD('$pass')" );
    if(isset($user)){
		$sid = $user->sid;
		$sql = "select date_end from contract where"
                ." sid = '$sid'";
       // $expDate = R::getCell($sql);
        //$sql = "update user set expdate ='$expDate' where uid = '$uid'";
		///echo $sql;
       // R::exec($sql);
		$usertype = $user->usertype;
		if($usertype == 1){
			
		}else if($usertype == 3){
			if(!isset($hp))
		      failLogin("hp not exists for school user, body:$body",4);

			$schooluser = R::findOne('school_user',"uid = '$uid' AND hp = '$hp'");
			if(isset($schooluser)){
			   success(R::exportAll($user));
			}else{
		      failLogin("no registered user, body:$body",3);
			}
		}else if($usertype ==10){
	        success(R::exportAll($user));
		}else{
			$democnt = $user->democnt;
			if($democnt ==0){
				failLogin("no more demo count",2);
			}else{
				$democnt--;
				$sql ="update user set democnt = $democnt where uid = '$uid'";
				R::exec($sql);
				success(R::exportAll($user));
			}
		}
    } else {
        failLogin("id/pass mismatch, body:$body",1);
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
$app->get('/bookNmentor',function() use($app){
		$books = R::findAll('book');
		$sql = "select book.*, mentor.id as mid, mentor.name as mname, mentor.dept, mentor.imgurl"
			." from book join mentor on book.teacher = mentor.id";
		$rows = R::getAll($sql);
	    $book = R::convertToBeans('book', $rows);
	    success(R::exportAll($book));
});
$app->post('/book', function() use ($app){
	$name = $app->request()->post("name");	
	$publisher = $app->request()->post("publisher");
	$bookNmentor = $app->request()->post("bookNmentor");

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
		$book->teacher 	 = $bookNmentor;
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
$app->get('/mentors/:id',function($id) use($app){

	$mentor = R::findOne( 'mentor', "id = '$id'" );
	if(isset($mentor)){
		echo json_encode($mentor->export());
	} else {
		fail("no mentor exist, body:$body");
	}

});

function handleImageUploaded()
{
	if(!array_key_exists('file', $_FILES))
		return 'fail';

	$path_part = pathinfo($_FILES['file']['name']);

	if(!array_key_exists('extension', $path_part))
		return 'fail';

	if($path_part['extension']!='jpg'&&$path_part['extension']!='png'){
		echo "jpg 또는 png 파일만가능합니다.";
		return 'fail';
	}

	if($_FILES["file"]["error"]>0){
		echo "return code : ".$_FILES["file"]["error"]."<br>";
		return 'fail';
	}

	$filedir = "upload_image/".$_FILES['file']['name'];
	move_uploaded_file($_FILES['file']['tmp_name'],$filedir);	

	return $filedir;
}

$app->post('/mentors',function() use ($app){
	
	$id = $app->request()->post('id');
	$name = $app->request()->post('name');
	$dept = $app->request()->post('dept');
	$motto = $app->request()->post('motto');
	$msg = $app->request()->post('msg');

	$filedir = handleImageUploaded();

	if($filedir=='fail' && isset($id))
	{
		$saved = R::findOne('mentor', "id='$id'");
		$imgurl = $saved->imgurl;
	}
	else if($filedir!='fail')
	{
		$imgurl = "http://fccrm.co.kr/smartqna/".$filedir;
	}
	else
	{
		exit('img upload fail');
	}
		
	$mentor 				= R::dispense('mentor');
	$mentor->name 	= $name;
	$mentor->dept 	= $dept;
	$mentor->imgurl = $imgurl;
	$mentor->motto  = $motto;
	$mentor->msg   	= $msg;

	if(isset($id))
		$mentor->id = $id;

	safeStore($mentor);
});

//$app->put('/mentors/:id',function($id) use ($app){
$app->post('/mentors/:id',function($id) use ($app){ //to handle file upload
	$json = $app->request->getBody();
	$obj  = json_decode($json);

	$updateSet = "";

	foreach($obj as $key =>$value){
		$updateSet .= "$key = '$value', ";
	}

	//append imgurl
	$filedir = handleImageUploaded();

	if($filedir!='fail')
		$updateSet .= "imgurl = '$filedir', ";

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
		$sql = "SELECT book.name from book where book.teacher = $mentorId";
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

$app->get('/school/:lv0',function($lv0) use ($app){
	//echo "$lv0 $lv1";

	try{
		$schools = R::find('school', "lv0='$lv0'");
		success(R::exportAll($schools));
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
	$sql 	= "select contract.*, school.name from contract join school"
					." where contract.sid = school.id and contract.aid = '$aid'";
	$rows = R::getAll($sql);
	$contract = R::convertToBeans('contract', $rows);
	success(R::exportAll($contract));
});

$app->get('/contract/:aid/:month',function($aid, $month) use ($app){
	//$cond = " AND ( MONTH(date_start)<=$month AND $month<=MONTH(date_end))";
	$cond = " AND ( MONTH(date_start)=$month )";
	$sql 	= "select contract.*, school.name from contract join school"
					." where contract.sid = school.id and aid = '$aid'"
					.$cond;
	$rows = R::getAll($sql);
	$contract = R::convertToBeans('contract', $rows);
	success(R::exportAll($contract));
});

$app->get('/contract_sum_all/:month',function($month) use ($app){
	//$cond2 = " ( MONTH(date_start)<=$month AND $month<=MONTH(date_end) )";
	$cond2 = " ( MONTH(date_start)=$month )";
	$rows = R::find('contract', "$cond2");

	$sales_sum		= 0;
	$approved_sum = 0;
	foreach($rows as $row){
		$sales_sum += $row->price;
		if($row->approved=='승인')
			$approved_sum += $row->price;
	}

	success( array('month'=>$month, 'sales_sum'=>$sales_sum, 'approved_sum'=>$approved_sum) );
});

$app->get('/contract_sum/:aid/:month',function($aid, $month) use ($app){
	if($aid=="") $cond1 = "";
	else				 $cond1 = "aid='$aid'";
	//$cond2 = " AND ( MONTH(date_start)<=$month AND $month<=MONTH(date_end) )";
	$cond2 = " AND ( MONTH(date_start)=$month )";
	$rows = R::find('contract', "$cond1 $cond2");

	$sales_sum		= 0;
	$approved_sum = 0;
	foreach($rows as $row){
		$sales_sum += $row->price;
		if($row->approved=='승인')
			$approved_sum += $row->price;
	}

	success( array('month'=>$month, 'sales_sum'=>$sales_sum, 'approved_sum'=>$approved_sum) );
});

$app->post('/contract_auth',function() use ($app){
	$json 	= $app->request->getBody();
	$obj 		= json_decode($json);
	$aid 		= $obj->{'aid'};
	$month 	= $obj->{'month'};

	$cond = "WHERE aid='$aid' AND MONTH(date_start)=$month";

	$sql = "update contract set approved='승인' $cond";

	try{
		R::exec($sql);
	}catch(RedBeanPHP\RedException\SQL $e){
	//	fail($e);
		fail(array('sql'=>$sql));
	}
	success(array('sql'=>$sql));
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
		$contract->approved		= "미승인";

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
$app->delete('/agent/:id',function($id) use ($app){
	try{
		R::exec("DELETE FROM agent WHERE id = '$id'");
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
$app->get('/student/:id',function($id) use($app){
  $sql ="select school.name as sname, user.* from school join user on user.sid='".$id."'";
 
   try{
        $result = R::getAll($sql);
		$data = R::convertToBeans('user',$result);
		success(R::exportAll($data));
   }catch(RedBeanPHP\RedException\SQL $e){
     fail($e);
   }

});

$app->get('/',function() use ($app){
	header("Location: intro.php");
	die();
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
function safeStoreFromWeb($obj){

	try{
		$id = R::store($obj);
		echo '<script language = "javascript">';
		echo 'alert("저장 성공");';
	}catch(RedBeanPHP\RedException\SQL $e){
		echo '<script language = "javascript">';
		echo 'alert("저장 실패 원인:'.$e.'");';
	}
		echo 'window.location.href = "admin.php"';
		echo '</script>';

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
function failLogin($msg,$type){
	echo json_encode(array('success'=>'fail','msg'=>$msg,'type'=>$type));
	exit(-1);
}
?>

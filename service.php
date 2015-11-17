<?php

$get	= $_SERVER["QUERY_STRING"];
//$post	= file_get_contents("php://input");

//echo "get:$get";
//echo "post:$post";

parse_str($get,  $getArr);
//parse_str($post, $postArr);

//var_dump($_POST);
//var_dump($getArr);
//var_dump($postArr);

switch($getArr['service'])
{	
   case "matchWorkbook":
		break;
	 case "setMessage":
		break;
	 case "requestImage":
		break;
	 case "uploadQuestion":
		break;

	 case "getWorkbookList":
		echo"
		<WorkBooks result='true' >
			<Workbook name='2014 EBS수1적분과통계' publisher='EBS' pk='707' >
				<mentos>
					<Mento name='mento1' />
					<Mento name='mento2' />
					<Mento name='mento3' />
				</mentos>
			</Workbook>
		</WorkBooks>
		";
		break;

	 case "addUser":
		break;

	 case "loginUser":
			$id 	= $_POST['id'];
			$pass = $_POST['password'];
			if($id=='test' && $pass=='0318')
			{
			echo "
			<login
			 result='true'
			 id='$id' 
			 name='testname'
			 registrationTime = '0'
			 expireDate = '0'
			 demoCount = '0' >
				<organizations>
					<organization 
						organizationPermitionDesc='org_permition' 
						userOrgPermitionDesc='orglink_permition'
						organizationName='orgName'
						organizationexpireDate='0' />
				</organizations>
			</login>";
			} else {
			echo "<login
			 result='false'
			 problem='user_authorization_fail' 
			/>";
			}
		break;

	 case "logoutUser":
		break;

	 case "message":
		break;
	 case "getMentoList":
echo "
<root result='true'>
		<mentor pk='0' name='name0' department='dept0' message='msg0' motto='motto0' picture='' />
		<mentor pk='1' name='name1' department='dept0' message='msg0' motto='motto0' picture='' />
		<mentor pk='2' name='name2' department='dept0' message='msg0' motto='motto0' picture='' />
</root>
";
		break;


	 case "workbook":
		break;
	 case "page":
		break;
	 case "number":
		break;
	 case "question":
		break;
	 case "name":
		break;
	 case "score":
		break;
	
	 case "id":
		break;
	 case "password":
		break;
	 case "name":
		break;
	 case "organizationName":
		break;
	 case "permition":
		break;
	 case "result":
		break;
	 case "message":
		break;
	
	 case "explanation":
		break;
	 case "result":
		break;
	 case "problem":
		break;
	 case "id":
		break;
	 case "registrationTime":
		break;
	 case "demoCount":
		break;
	 case "expireDate":
		break;
	 case "organizations":
		break;
	 case "organization":
		break;
	 case "organizationPermitionDesc":
		break;
	 case "userOrgPermitionDesc":
		break;
	 case "organizationexpireDate":
		break;
	 case "organizationName":
		break;
	 case "publisher":
		break;
	 case "pk":
		break;
	 case "title":
		break;
	 case "department":
		break;
	 case "message":
		break;
	 case "motto":
		break;
	 case "picture":
		break;
	 case "mentos":
		break;
	 case "mento":
		break;
}

?>

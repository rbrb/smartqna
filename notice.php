<?php
session_start ();
require 'rb-p533.php';
if (!isset ( $_SESSION['login_user'] )) {
	header ( "location:agent.php" );
}

R::setup ( 'mysql:host=localhost; dbname=smartqna', 'root', '' );
$allArticles = R::findAll ('board_notification', 'ORDER BY id DESC');
$allArticles = array_values($allArticles);
//$article = $allArticles[0];
?>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ToonySam</title>

    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-brand" href="basicInfo.php">ToonySam</a>
            </div>
            <!-- /.navbar-header -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="basicInfo.php"><i class="fa fa-dashboard fa-fw"></i> 기본정보</a>
                        </li>
                        <li>
                            <a href="approval.php"><i class="fa fa-bar-chart-o fa-fw"></i> 매출 및 결제 정보</a>
                           
                        </li>
                        <li>
                            <a href="EnterSales.php"><i class="fa fa-table fa-fw"></i> 매출 입력</a>
                        </li>
                        <li>
                        	<a href="notice.php"><i class="fa fa-bell fa-fw"></i> 공지사항</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
						<a href="agent.php" style="position:absolute; right:12px; top:22px;"> logout </a>
        </nav>

        <div id="page-wrapper">
        	<br>
             <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">공지사항</div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           <div class="row">
	            <div class="col-lg-8">
	                    <div class="panel panel-default">
	                        <div class="panel-body">
	                        
	                        <?php
	                        if(isset($_GET['window'])) {
	                        	$window = $_GET['window'].".php";
	                        	require_once ($window);
	                        }
	                        else
	                        	require_once ("list.php");
	                        ?>
	                        
	                        </div>
					</div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="./bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="./bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="./bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="./dist/js/sb-admin-2.js"></script>

</body>

</html>


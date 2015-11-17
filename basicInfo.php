<?php
session_start ();
require 'rb-p533.php';
if (! session_is_registered ( "aid" ) || !isset($_SESSION['login_user']) ) {
	header ( "location:agent.php" );
}

R::setup ( 'mysql:host=localhost;dbname=smartqna', 'root', 'denters0318' );
$aid	= $_SESSION['login_user'];
$agent = R::findOne('agent',"aid = '$aid'");
?>

<html lang="en">
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
	<style>
		.basicInfoLabel {
		}
	</style>

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
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">기본 정보</div>
                                    
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
								<form role="form">
								    <div class="form-group input-group">
                            	<span class="input-group-addon basicInfoLabel">&nbsp;&nbsp;&nbsp;&nbsp;아이디&nbsp;&nbsp;&nbsp;&nbsp;</span>
                             	<p class="form-control">	
						 					<? echo $_SESSION['login_user']; ?>
										</p>
                                         
                            </div>
                            <div class="form-group input-group">
                            	<span class="input-group-addon">&nbsp;&nbsp;&nbsp;회사이름&nbsp;&nbsp;</span>
                              	<p class="form-control">
					 						<?
												echo "$agent->oname";
											?>
											</p>
                            </div>
                            <div class="form-group input-group">
                            	<span class="input-group-addon">대표자 이름</span>
                              <p class="form-control">
					 						<? echo "$agent->name"; ?>
										</p>
                            </div>
								    <div class="form-group input-group">
                            	<span class="input-group-addon">&nbsp;&nbsp;&nbsp;&nbsp;연락처&nbsp;&nbsp;&nbsp;&nbsp;</span>	
                              <p class="form-control">
					 						<? echo "$agent->hp"; ?>
										</p>
                            </div>
                            <div class="form-group input-group">
                            	<span class="input-group-addon">&nbsp;&nbsp; 담당지역&nbsp;&nbsp; </span>
                              <p class="form-control">
					 						<? echo "$agent->lv0/$agent->lv1"; ?>
										</p>
                            </div>
								</form>
							</div>
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


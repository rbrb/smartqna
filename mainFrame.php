<?php
session_start ();
require 'rb-p533.php';
if (! session_is_registered ( "aid" )) {
	header ( "location:login.php" );
}

R::setup ( 'mysql:host=localhost;dbname=smartqna', 'root', 'denters0318' );
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

    <!-- Morris Charts CSS -->
    <link href="bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-brand" href="basicInfo.html">ToonySam</a>
            </div>
            <!-- /.navbar-header -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="basicInfo.html"><i class="fa fa-dashboard fa-fw"></i> 기본정보</a>
                        </li>
                        <li>
                            <a href="approval.html"><i class="fa fa-bar-chart-o fa-fw"></i> 매출 및 결제 정보</a>
                           
                        </li>
                        <li>
                            <a href="EnterSales.html"><i class="fa fa-table fa-fw"></i>매출 입력</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
        	<br>
             <div class="row">
                <div class="col-lg-3 col-md-6">
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
	            <div class="col-lg-12">
	                    <div class="panel panel-default">
	                        <div class="panel-body">
								<form role="form">
								    <div class="form-group input-group">
                            	<span class="input-group-addon">아이디</span>
                             	<p class="form-control">	
						 					<? echo $_SESSION['login_user']; ?>
										</p>
                                         
                            </div>
                            <div class="form-group input-group">
                            	<span class="input-group-addon">회사이름</span>
                              	<p class="form-control">
					 						<?
												$aid	= $_SESSION['login_user'];
												$agent = R::findOne('agent',"aid = '$aid'");
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
                            	<span class="input-group-addon">연락처</span>	
                              <p class="form-control">
					 						<? echo "$agent->hp"; ?>
										</p>
                            </div>
                            <div class="form-group input-group">
                            	<span class="input-group-addon">
											담당지역
										</span>
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
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../bower_components/raphael/raphael-min.js"></script>
    <script src="../bower_components/morrisjs/morris.min.js"></script>
    <script src="../js/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>


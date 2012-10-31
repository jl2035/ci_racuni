<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Računi</title>
	<?php 
		if(!($this->session->userdata('logged_in') == 'true'))
			$prijavljen = false;
		else
			$prijavljen = true;
	
	?>
	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
		text-decoration: none;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 0 auto;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
		width: 800px;
		/*background: rgba(0, 0, 0, 0.1);*/
	}
	
	#j_glava
	{
		margin: 0 auto;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
		width: 800px;
		float: center;
		overflow: auto;
	}
	#j_nav
	{
		float: left;
	}
	#j_nav ul
	{
		list-style-type: none;
		margin: 0;
		padding: 0;
		padding: 7px 0 7px 10px;
	}
	#j_nav ul li
	{
		display: inline;
		padding: .2em 1em;	
		margin: 2px;
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		border-radius: 4px;
		border: solid 1px #666;
		text-decoration: none;
		
		background: #C7C5D2;
		font-weight: bold;
		text-shadow: 0 -1px 0 rgba(255, 255, 255, 0.4);
		-webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2);
		-moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2);
		box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2);
		-webkit-transition-duration: 0.2s;
		-moz-transition-duration: 0.2s;
		transition-duration: 0.2s;
		-webkit-user-select:none;
		-moz-user-select:none;
		-ms-user-select:none;
		user-select:none;
	}
	#j_nav ul li:hover
	{
		background: #A9A9A9;
	    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    border: solid 1px #1E2DE4;
	font-weight: bold;
    text-shadow: 0 -1px 0 rgba(255, 255, 255, 0.5);
    -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2);
    -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2);
    -webkit-transition-duration: 0.2s;
    -moz-transition-duration: 0.2s;
    transition-duration: 0.2s;
    -webkit-user-select:none;
    -moz-user-select:none;
    -ms-user-select:none;
    user-select:none;	
	}
	$j_nav ul li a
	{
		text-decoration: none;
		color: #555555;
	}
	#j_user
	{
		float: right;
		margin-right: 10px;
		padding-top: 5px;
	}
	.formtable
	{
		
	}
	.formtable tr
	{
		border-bottom-style: solid;
	}
	#main_div
	{
		width: 600px;
	}
	#everything
	{
		width: 100%;
	}

#table-2 {
	border: 1px solid #e3e3e3;
	background-color: #f2f2f2;
        width: 100%;
	border-radius: 6px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	margin-left: 10px;
}
#table-2 td, #table-2 th {
	padding: 5px;
	color: #333;
}
#table-2 thead {
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
	padding: .2em 0 .2em .5em;
	text-align: left;
	color: #4B4B4B;
	background-color: #C8C8C8;
	background-image: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#e3e3e3), color-stop(.6,#B3B3B3));
	background-image: -moz-linear-gradient(top, #D6D6D6, #B0B0B0, #B3B3B3 90%);
	border-bottom: solid 1px #999;
}
#table-2 th {
	font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
	font-size: 17px;
	line-height: 20px;
	font-style: normal;
	font-weight: normal;
	text-align: left;
	text-shadow: white 1px 1px 1px;
}
#table-2 td {
	line-height: 20px;
	font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
	font-size: 14px;
	border-bottom: 1px solid #fff;
	border-top: 1px solid #fff;
}
#table-2 td:hover {
	background-color: #fff;
}
	
	
	</style>
</head>
<body>
	<div id="everything">
	<div id="j_glava">
		<div id="j_nav"><?php $this->load->view('layout/nav'); ?></div>
		<div id="j_user">
			
			<?php
			if($prijavljen)
				echo anchor('user/logout', 'Odjava'); 
			?>
			
		</div>
		<br>
	</div>
	
	<br>
	<div id="container">
	<?php if($prijavljen)
			echo $j_error;
		  else
			//redirect('welcome');
			$this->load->view('view_login');
			?>


		<p class="footer">Stran naložena v <strong>{elapsed_time}</strong> s</p>
		
	</div>
</div>
</body>
</html>


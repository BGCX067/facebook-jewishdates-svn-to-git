
<?		if(isset($rec)){		?>
			<h1><?=$rec->data['short']?></h1>
			<h2><?=$rec->data['full']?></h2>
<? 		}else{ 					?>
	<h1>Sorry the page you requested does not exist</h1>
<?		}						?>
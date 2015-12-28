<?
	require_once '../facebookIncludes/fbUtilInclude.php';
	$conn = dbConnect();
	$results = mysql_query("SELECT * FROM fb_messages Order By count DESC LIMIT 10", $conn);
?>
<html>
	<head>
		<meta http-equiv="refresh" content="15">
		<style>
			tr {
				border-bottom: 1px dashed #00aaff;
			}
		</style>
	</head>
	<body>
			<table>
		<?
			while($rs = mysql_fetch_assoc($results))
			{
				?>
				<tr>
					<td><?=$rs['emailTitle']?></td>
					<td><?=$rs['count']?></td>
				</tr>
				<?
			}
		?></table>		
	</body>
</html>


	<script type="text/javascript" src="../jquery-1.3.1.min.js"></script>
	<script type="text/javascript" src="../js/jqueryColor.js"></script>
	<script type="text/javascript" src="../js/jquery.json.js"></script>
    <script type="text/javascript">
		$(document).ready(function(){
			$("tr").click(function(event){
				if($(event.target).is(".editInline, .saveBtn, .cancelBtn"))
				{
					$(".showRow",this).toggle("slow");
					$(".formRowText",this).toggle("slow");
					event.preventDefault();
				}
				if($(event.target).is(".saveBtn"))
				{
					var context = this;
					$.get("./", $("form",this).serialize(),
						  function (result)
						  {
						  	resultOb = $.evalJSON(result);
						    $(".shortField .showRow", context).html(resultOb.data.short);
						    $(".fullField .showRow", context).html(resultOb.data.full);
						  }
					);
				}
			 });
			$('html,body').animate(
				{scrollTop: $(".insertedRow").offset().top},
				500
			);
			$(".insertedRow").animate({backgroundColor: "white"}, 2000);
		 })
    </script>
<style>
	#content {
		width:770px;
		border: 2px solid #331177;
		margin: auto;
	}
	th {
		font-size: 12px;
		background: #000000;
		color:#ffffff;
	}
	td { padding: 3px 3px 3px 3px; vertical-align:top;}
	.rowa {
	    background-color: #fff;
	    border: 1px solid #fff;
	    margin: 26px;
	    padding: 15px;
	}
	.rowb {
	    background-color: #ccc;
	    border: 1px solid #ccc;
	    margin: 26px;
	    padding: 15px;
	}
	.insertedRow {
		background-color: yellow;
	}
	.textInput {
		border: solid #000033 1px;
		font: 12px Verdana, Geneva, Arial, Helvetica, sans-serif;
		color: #0000ff;
		width: 100%;
	}
	.formRowText {
		display:none;
	}
	.shortField {
		width: 200px;
	}
	.fullField {
		width: 500px;
	}
</style>

<div id="content">
<br />
<a href='?action=new'>Create New</a>

		<table>
				<tr>
					<th>Id</th><th>Short</th><th>Full</th><th>Actions</th>
				</tr>
<?
	$thisWeek = floor( (strtotime("today") - strtotime("Feb 1 2009")) / 604800) % count($records);
	$i = 0;
	foreach($records as $rec)
	{
		$css_class = ($css_class == 'rowa') ? 'rowb' : 'rowa';
		?>
			<tr class="<?=$css_class?> <?=($rec->data['id']==$insertedId) ? 'insertedRow' : '' ?>">
				<form action="actions.php" method="get">
					<input type="hidden" name="action" value="update" />
					<input type="hidden" name="outputtype" value="json" />
					<input type="hidden" name="hashNameSpace" value="txt_" />
					<input type="hidden" name="txt_id" value="<?=$rec->data['id']?>" />
					<td <? if($i++ == $thisWeek){ ?>style="color:red;" <? } ?> >
						<?=$rec->data['id']?>
					</td>
					<td class="shortField">
						<div class="showRow"> <?=$rec->data['short']?> </div>
						<div class="formRowText">	<? textFieldFor($rec, 'short'); ?>	</div>
					</td>
					<td class="fullField">
						<div class="showRow"> <?=$rec->data['full']?> </div>
						<div class="formRowText">	<? textFieldFor($rec, 'full'); ?> </div>
					</td>
					<td style="text-align:right">
						<div class="showRow">
							<a href='?action=edit&id=<?=$rec->data['id']?>' class="editInline">Edit</a> |
							<a href='?action=delete&id=<?=$rec->data['id']?>'>Delete</a>
						</div>		
						<div class="formRowText" align="right">
							<input type="button" value="Save" class="saveBtn" />
							<input type="button" value="Cancel" class="cancelBtn" />
						</div>
					</td>
				</form>
			</tr>
		<?
	}
?>
		</table>
</div>
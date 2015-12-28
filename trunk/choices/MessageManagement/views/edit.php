<style>
	form {
		width: 500px;
		margin: auto;
		border: 2px solid #331177;
		padding: 3px 3px 3px 3px;
	}
	.formHead {
		color: #ffffff;
		background: #000000;
		font-weight: bold;
	}
	.formFoot {
	}
	.formRowText {
		margin: 3px 3px 3px 3px;
	}
	.formRowBG {
	}
	.textInput {
		border: solid #000033 1px;
		font: 12px Verdana, Geneva, Arial, Helvetica, sans-serif;
		color: #0000ff;
		width: 350px;
	}
	label {
		display:block;
		float:left;
		width: 100px;
		text-align: right;
	}
</style>

<ul>
<? foreach($rec->errors as $errName => $errValue) {?>
	<li><b><?=$errName?>:</b><?=$errValue?></li>
<? } ?>
</ul>

<form action="actions.php" method="get">
	<input type="hidden" name="action" value="<?=$nextAction?>" />
	<input type="hidden" name="hashNameSpace" value="txt_" />
	<input type="hidden" name="txt_id" value="<?=$rec->data['id']?>" />
	<div class="formHead">Edit Thought</div>
	<div class="formRowText">	<? textFieldFor($rec, 'short', 'Short'); ?> </div>
	<div class="formRowText">	<? textFieldFor($rec, 'full', 'Full'); ?>	</div>
	<div class="formFoot" align="right"> <input type="submit" value="Submit" /> </div>
</form>

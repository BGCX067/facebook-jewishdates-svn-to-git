<style>
	form {
		width: 500px;
		margin: auto;
	}
	.formHead {
		background:url(<?=$appcallbackurl?>images/form_head.jpg);
		height:41px;
	}
	.formFoot {
		background:url(<?=$appcallbackurl?>images/form_foot.jpg);
		height:47px;		
		padding: 0px 40px 5px 40px;		
	}
	.formRowText {
		background:url(<?=$appcallbackurl?>images/form_text.jpg);
		height:40px;
		text-align: center;
		padding: 10px 5px 5px 5px;		
	}
	.formRowBG {
		background:url(<?=$appcallbackurl?>images/form_bg.jpg);
		height:30px;
		padding: 0px 40px 5px 40px;		
	}
	#paypal, #google {
		width: 200px;
		float: left;
		border: solid lime 1px;
		text-align: center;
	}
</style>
<a href="/jewishdates/">Jewish Dates</a> >>
<a href="/jewishdates/moreDates/actions.php?uid=<?=$user?>">Your List</a> >>
<?=isset($rec->data['title']) ? $rec->data['title'] : 'New Date Entry'?>
<br />
<ul>
<? foreach($rec->errors as $errName => $errValue) {?>
	<li><b><?=$errName?>:</b><?=$errValue?></li>
<? } ?>
</ul>
		<fb:success>
			<fb:message>This is a Paid Service!</fb:message>
			<p>This means that you must pay $1 for each special date that you add.</p>
			<p>Once you have paid. You can edit, replace, and keep that date on profile as long as this application is operational. You will continue to receive reminders as long as this system is in place.</p>
			<p>I would recommend that you pay a few dollars up front so that you can add records without having to run your credit card each time. It will also help develop other Jewish applications for facebook.</p>
			<p>For the mean time. I will be working on the <b>Honor System</b>. This means that I am not keeping track of who sent money and who didn't. You can also add dates before you pay. But if people are taking advantage of it I will start deleting dates that are not paid for.</p>
			<form action="https://checkout.google.com/api/checkout/v2/checkoutForm/Merchant/474936682098366" id="BB_BuyButtonForm" method="post" name="BB_BuyButtonForm" style="margin: auto;" id="google">
			    <input name="item_name_1" type="hidden" value="Special Date"/>
			    <input name="item_description_1" type="hidden" value="Feature of Jewish Dates"/>
			    <input type="hidden" name="on0" value="Ammount">
					<p style="text-align:center;"><label for="item_quantity_1">Amount:</label>
				<input name="item_quantity_1" id="item_quantity_1" type="text" value="5" size="5"/></p>
			    <input name="item_price_1" type="hidden" value="1.0"/>
			    <input name="item_currency_1" type="hidden" value="USD"/>
			    <input name="_charset_" type="hidden" value="utf-8"/>
			    <input alt="" src="https://checkout.google.com/buttons/buy.gif?merchant_id=474936682098366&amp;w=117&amp;h=48&amp;style=white&amp;variant=text&amp;loc=en_US" type="image" align="middle"/>
			</form>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="paypal">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="1248595">
			<input type="hidden" name="on0" value="Ammount">
			<p style="text-align:center;"><label for="os0">Amount:</label>
			<select name="os0">
				<option value="$1">$1.00
				<option value="$2">$2.00
				<option value="$3">$3.00
				<option value="$4">$4.00
				<option value="$5">$5.00
				<option value="$10">$10.00
			</select> </p>
			<input type="hidden" name="currency_code" value="USD">
			<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="">
			<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
			<br clear="all" />
		</fb:success>

<form action="actions.php" method="get">
	<input type="hidden" name="action" value="<?=$nextAction?>" />
	<input type="hidden" name="hashNameSpace" value="txt_" />
	<input type="hidden" name="txt_id" value="<?=$rec->data['id']?>" />
	<div class="formHead"></div>
	<div class="formRowText">	<? textFieldFor($rec, 'title', 'Title'); ?> </div>
	<div class="formRowText">	<? textFieldFor($rec, 'originalDate', 'Original Date'); ?> </div>
	<div class="formRowBG">	
		<? checkFieldFor($rec, 'night', 'Did this happen at night?'); ?>
	</div>
	<div class="formFoot" align="right"> <input type="submit" value="Submit" /> </div>
</form>

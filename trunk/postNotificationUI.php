<?
$noframe=true;

require_once 'appinclude.php'; ?>
<style>
	body {
		font-family: Tahoma;
		font-size: small;
	}
	form {
		width: 510px;
		margin: auto;
	}
	label	{
		width: 100px;
		float: left;
		text-align: right;
		margin-right: 5px;
		display: block
	}
	.inputText {
		width:550px;
		font-family: "Courier New", Courier, monospace;
		border: blue 1px solid;
		background: #EEEEFF;
		margin: 1px 1px 1px 1px;
	}
	textarea {
		width: 550px;
		font-family: "Courier New", Courier, monospace;
		font-size: small;
		border: blue 1px solid;
		background: #EEEEFF;
		margin: 1px 1px 1px 1px;
	}
	.inputSubmit {
		background: #EEEEFF;
		float:right;
	}
	.options {
		text-align:center;
	}
	.shortInput {
		width: 60px;
	}
	#log {
		width: 75%;
		height: 200px;
		float:left;
	}
	#logReader {
		width: 20%;
		height: 200px;
		float:left;
	}
</style>
<form action="postNotificationsForUI.php" method="post" target="log" id="theForm" name="theForm">
	<label for="message">Notification:</label>
	<textarea name="message" id="message"  onkeyup="checkTextAreaRows(this)"></textarea><br />
	<label for="titleEmail">Email Title:</label>
	<textarea name="titleEmail" id="titleEmail"  onkeyup="checkTextAreaRows(this)"></textarea><br />
	<label for="messageEmailHTML">HTML Email:</label>
	<textarea name="messageEmailHTML" id="messageEmailHTML"  onkeyup="checkTextAreaRows(this)"></textarea><br />
	<label for="messageEmailText">Text Email:</label>
	<textarea name="messageEmailText" id="messageEmailText"  onkeyup="checkTextAreaRows(this)"></textarea><br />
	<div class="options">
		Start: <input type="text" name="startLimit" id="startLimit" value="22890" class="inputText shortInput" />
		Limit: <input type="text" name="endLimit" id="startLimit" value="5000" class="inputText shortInput" />
		<br />
		<input type="checkbox" name="sendNotification" value="1" id="sendNotification" checked="checked" />
		Notification
		<input type="checkbox" name="sendEmail" value="2" id="sendEmail" checked="checked" />
		Email
	</div>
	<div class="options">
		<input type="checkbox" name="oneUser" value="1" id="oneUser" />
		This is a test run 
	</div>
	<input type="submit" class="inputSubmit" value="Send" />
	<br clear="all" />
</form>
<iframe src="about:blank" name="log" id="log" ></iframe>
<iframe src="postNotificationsUILogReader.php" name="logReader" id="logReader" ></iframe>

<script>
	function checkTextAreaRows(textArea){
		if (navigator.appName.indexOf("Microsoft Internet Explorer") == 0)
		{
			textArea.style.overflow = 'visible';
			return;
		}
		while (	textArea.rows > 1 && textArea.scrollHeight < textArea.offsetHeight ){
			textArea.rows--;
		}
		while (textArea.scrollHeight > textArea.offsetHeight)
		{
			textArea.rows++;
		}
		return;
	}
	function incrementAndSubmit(i)
	{
		document.getElementById('startLimit').value = i;
		document.getElementById('theForm').submit();	
		return;
	}
</script>

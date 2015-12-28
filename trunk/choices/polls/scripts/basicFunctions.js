/**
 * @author Moshe
 */
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

<?

$result.= "<script type='text/javascript' src='".$path."/js/ckeditor/ckeditor.js'></script>
<script type='text/javascript' src='".$path."/js/ckeditor/adapters/jquery.js'></script>
<script type='text/javascript' src='".$path."/js/ckfinder/ckfinder.js'></script>
<script language='javascript'>
	$(function()
		{
		var config = {
			toolbar : 
									[
									['Source'],
									['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
									['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
									'/',
									['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
									['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
									['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
									['BidiLtr', 'BidiRtl'],
									['Link','Unlink','Anchor'],
									['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe'],
									'/',
									['Styles','Format','Font','FontSize'],
									['TextColor','BGColor'],
									['Maximize', 'ShowBlocks','-','About']
									]

			};

		
		$('.ckeditor').livequery(function ()
			{
    		$('.ckeditor').ckeditor(config);
			});

		$('.wysiwyg').click(function()
			{
			//alert('hola');
			formu = \"<a href='javascript:location.reload(true)' style='float:right; margin-bottom:10px;'><br style='clear:both'><img src='".$path."/img/btneliminar.png' /></a><form id='ingreso' name='ingreso' method='post' action='".$path."/lib/guardar-pagina.php'><textarea name='texto' class='ckeditor' id='texto' cols='45' rows='5'></textarea><input type='submit' id='guardar' value='Guardar' /></form>\";
			
			$('#'+$(this).attr('rel')).html(formu);
			
			});
		
		$('#ingreso').livequery('submit', function ()
	 		{
			alert('Guardado');
			return false;
			});

		});
</script>
";

?>


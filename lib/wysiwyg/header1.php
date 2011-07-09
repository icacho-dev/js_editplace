<?

$result.= "<script type='text/javascript' src='".$path."/js/ckeditor/ckeditor.js'></script>
<script type='text/javascript' src='".$path."/js/ckfinder/ckfinder.js'></script>
<script language='javascript'>
	$(function()
		{
		$('.wysiwyg').click(function()
			{
			//alert('hola');
			formu = \"<form id='ingreso' name='ingreso' method='post' action='".$path."/lib/guardar-pagina.php'><textarea name='texto' id='texto' cols='45' rows='5'></textarea><input name='id' id='id' type='hidden' value='1' /><input name='txt' id='txt' type='hidden' value='' /><input type='submit' id='guardar' value='' /></form>\";
			
			
			
			$('#'+$(this).attr('rel')).html(formu);
			
			});

		});
</script>
";

?>
<script type="text/javascript" src="wp-content/plugins/mycoolform/js/jquery.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		// hang an "click" event listener on each checkbox
		$('form input[type="checkbox"]').click(function() {
			// here we calculate the result
			$('#result').html(0);
			$('form input[type="checkbox"]').each(function() {
				if($(this).is(':checked'))
					$('#result').html(parseInt($('#result').html()) + parseInt($(this).next('.value').html()));
			});
		});
	});
</script>
Ergebnis: <span id="result">0</span>
<form action="" method="POST">
	<input type="checkbox" name="checkbox1" /><span class="value">10</span><br>
	<input type="checkbox" name="checkbox2" /><span class="value">20</span><br>
	<input type="checkbox" name="checkbox3" /><span class="value">50</span><br>
	<input type="submit" name="mcformsubmit" value="Senden" />
</form>
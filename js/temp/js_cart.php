<!--code dat hang-->
<script type="text/javascript">
$(document).ready(function(e) {
    $('a.add_to_basket').click(function(){
			var id = $(this).attr('value');
			var quantity =1 ;
			var input_quantity=$('input#input_quantity').val();
			if(input_quantity){
				quantity=input_quantity;
				alert(quantity);
			}
			$.ajax({
				type: "POST",
				url: "ajax/ajax_basket.php",
				data: "id="+id+"&q="+quantity,
				success: function(result){
				
					if(result)location.href="http://<?=$config_url?>/basket.html";
				}
			});
			return false;
		
	});
});
</script>
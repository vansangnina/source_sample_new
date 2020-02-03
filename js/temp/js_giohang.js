
	function del(pid){
		if(confirm('Xóa sản phẩm này ! ')){
			document.form1.pid.value=pid;
			document.form1.command.value='delete';
			document.form1.submit();
		}
	}
	function clear_cart(){
		if(confirm('Bạn Chắc Có Muốn Xóa Giỏ Hàng Hay Không ? ')){
			document.form1.command.value='clear';
			document.form1.submit();
		}
	}
	function update_cart(){
		if(confirm('Cập nhật giỏ hàng của bạn ?')){
			document.form1.command.value='update';
			document.form1.submit();
		}
	}



/*code button cong tru*/
	$(document).ready(function(){
		$('.minius_cart').click(function(){
			var id_product=$(this).attr('data-id');
			console.log(id_product);
			var number_cart=$('.quantity-'+id_product).val();
			if(number_cart>1){
				number_cart=parseInt(number_cart)-1;
				$('.quantity-'+id_product).val(number_cart);
				update_cart_ajax($(this),id_product,number_cart);
			}
			return false;
		});

		$('.plus_cart').click(function(){
			var id_product=$(this).attr('data-id');
			var number_cart=$('.quantity-'+id_product).val();
			if(number_cart<101){
				number_cart=parseInt(number_cart)+1;
				$('.quantity-'+id_product).val(number_cart);
				update_cart_ajax($(this),id_product,number_cart);
			}
			return false;
		});
		
		function update_cart_ajax(element,id_product,quantity){
			$.ajax({
				url:'ajax/ajax_update_cart.php',
				data:{id_product:id_product,quantity:quantity},
				dataType:'json',
				type:'post',
				success:function(data){
					$('.price-temp').text(data.total_all);
					$('.price-all').text(data.total_all);
				}
			});
		}
	});

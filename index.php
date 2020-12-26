<!DOCTYPE html>
<html>
	<head>
	    <title>Coalition Test</title>
	    <link rel="stylesheet" href="css/bootstrap.min.css" />
	    <link rel="stylesheet" href="css/style.css" />
	</head>
	<body class="text-center1">
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-success" id="addSuccess"></div>
				<div class="alert alert-danger" id="addError"></div>
				<form name="productForm" id="productForm" method="post">
			        <div id="name-group" class="form-group">
						<label>Product Name:</label>
						<input type="text" class="form-control required" name="product_name" id="product_name" placeholder="Enter Product name" />
					</div>
			        <div id="quantity-group" class="form-group">
						<label>Quantity in stock:</label>
						<input type="text" class="form-control required digits" name="quantity" id="quantity" placeholder="Quantity in stock" />
					</div>
					<div id="price-group" class="form-group">
						<label>Price per item:</label>
						<input type="text" class="form-control required number" name="price" id="price" placeholder="Price per item" />
					</div>
				    <input type="submit" id="addProduct" class="btn btn-success" value="Create Product" />
				</form>
			</div>
		</div>
		<div id="productList"></div>
	    <script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
	    <script type="text/javascript" src="js/bootstrap.min.js"></script>
	    <script type="text/javascript" src="js/jquery.validate.min.js"></script>
	    <script type="text/javascript">
	    	$('#addSuccess').hide();
	    	$('#addError').hide();
	    	productList();
	    	
		    $("#productForm").validate({
			   	submitHandler: function(form) {
		    		$.ajax({
		              	url:"add_product.php",
		            	type:"post",
		              	data: $('#productForm').serialize(),
		              	dataType: 'json',
		              	success: function(responseData){
		              		if ( ! responseData.success) {
					            // handle errors for product name ---------------
					            if (responseData.errors.product_name) {
					                $('#name-group').addClass('has-error');
					                $('#name-group').append('<div class="help-block">' + responseData.errors.product_name + '</div>');
					            }

					            // handle errors for quantity ---------------
					            if (responseData.errors.quantity) {
					                $('#quantity-group').addClass('has-error');
					                $('#quantity-group').append('<div class="help-block">' + responseData.errors.quantity + '</div>');
					            }

					            // handle errors for price ---------------
					            if (responseData.errors.price) {
					                $('#price-group').addClass('has-error');
					                $('#price-group').append('<div class="help-block">' + responseData.errors.price + '</div>');
					            }

					        } else {
					        	$('#addError').hide();
					          	$('#addSuccess').html(responseData.message);
					          	$('#addSuccess').show();
					          	$('#productForm').trigger("reset");
					          	productList();
					        }
		        		},
		        		error: function(){
		        			$('#addSuccess').hide();
				          	$('#addError').html('Could not reach server, please try again later.');
					        $('#addError').show();
		        		},
		      		});
				} 	
		    });

		    function productList() {
			    $.ajax({
	              	url:"list_products.php",
	            	success: function(responseData){
			          	$('#productList').html(responseData);
	        		},
	        		error: function(){
	        			$('#addSuccess').hide();
			          	$('#addError').html('Could not reach server, please try again later.');
				        $('#addError').show();
	        		},
	      		});
			}
		</script>
	</body>
</html>
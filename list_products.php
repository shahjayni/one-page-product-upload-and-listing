<?php if($xml = @simplexml_load_file('products_list.xml')) { ?>
	<h2>Products Listing</h2>
	<div class="table-responsive">
		<table class="table table-striped table-sm">
			<thead>
	            <tr>
					<th>Product name</th>
					<th>Quantity in stock</th>
					<th>Price per item</th>
					<th>Datetime submitted</th>
					<th>Total value number</th>
	            </tr>
          	</thead>
			<tbody>
			<?php 
				$list = $xml->product;
				$finalValue = 0;
				foreach ($list as $key=>$product) { 
					$totalValue = ($product->QuantityInStock * $product->PricePerItem);
					$finalValue += $totalValue;
			?>
				<tr>
				    <td><?php echo $product->Name; ?></td>
				    <td><?php echo $product->QuantityInStock; ?></td>
				    <td><?php echo $product->PricePerItem; ?></td>
					<td><?php echo date('d-m-Y h:i A', strtotime($product->CreatedAt)); ?></td>
					<td><?php echo $totalValue; ?></td>
				</tr>
			<?php } ?>
				<tr>
					<td colspan="4">Sum Total value number</td>
					<td><?php echo $finalValue; ?></td>	
				</tr>
			</tbody>
		</table>
	</div>
<?php } ?>
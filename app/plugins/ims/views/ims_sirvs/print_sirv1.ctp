<center>
    <img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" />
    <!--<h2>ABAY BANK S.C</h2>-->
    <h1><U>Stock Issue & Receiving Voucher (SIRV)</U></h1>
</center>
<table border="0" width="100%">
    <tr>
	    <td> </td>
		<td> </td>
        <td  align="center">Date: <?php echo date('d-M-Y', strtotime($sirv['ImsSirv']['created'])); ?></td>
    </tr>
    <tr>
        <td align="left" valign="top" >Management / Branch: <u><?php
			$result_branch = $this->requestAction(
							array(
								'controller' => 'ims_sirvs', 
								'action' => 'getbranch'), 
							array('branchid' => $sirv['ImsRequisition']['branch_id'])
						);					
						echo '&nbsp' . $result_branch;?></u><br/>
            Requisition N<u>o</u>: <u><?php echo '&nbsp' . $sirv['ImsRequisition']['name']; ?></u><br/>
        </td>
        <td align="left" valign="top">
            SIRV N<u>o</u>: <b><?php echo $sirv['ImsSirv']['name'];?> </b><br/>       
		
            Issued To: <b><?php $result = $this->requestAction(
							array(
								'controller' => 'ims_sirvs', 
								'action' => 'getUser'), 
							array('userid' => $sirv['ImsRequisition']['requested_by'])
						);				
					
						echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						$result['Person']['last_name'];?> </b><br/>
        </td>  
    </tr>
</table>
<hr/>

<b align="left"><font color="#045FB4"><?php echo $result_branch.' '; ?>Expense</font></b>
<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
        <th>N<u>o</u>.</th>
		<th>Code N<u>o</u>.</th>
        <th>Description</th>
        <th>Unit of Meas.</th>
        <th>Quantity</th>
        <th>Unit Price</th>
        <th>Total Price</th>
        <th>Remarks</th>
		<th>Serial</th>
    </tr>
    <?php $count = 0; $color = array(0 => 'dddddd', 1 => 'eeeeee'); $total_price = 0;
	
	$categories = $this->requestAction(
		array(
			'controller' => 'ims_sirvs', 
			'action' => 'getcategories')
	);
	for($i =0; $i< count($categories); $i++)
	{	
		$total_cost = 0;
		foreach ($categories [$i]['child'] as $child)
		{
			 foreach($sirv['ImsSirvItem'] as $sirv_item) {		
				
				$result = $this->requestAction(
								array(
									'controller' => 'ims_sirvs', 
									'action' => 'getitem'), 
								array('itemid' => $sirv_item['ims_item_id'])
							);
				
				if($child['ImsItemCategory']['id'] == $result['ims_item_category_id']){
					if($result['booked'] == 0){
					$total_price += $sirv_item['unit_price'] * $sirv_item['quantity'];
					$total_cost += $sirv_item['unit_price'] * $sirv_item['quantity'];
				?>
					<tr bgcolor="#<?php echo $color[$count % 2]; ?>">
						<td><?php echo $count++ + 1; ?></td>
						<td><?php echo '<b><i>' . $result['description'] . '</i></b>'; ?></td>
						<td><?php echo $result['name'];  ?></td>
						<td><?php echo $sirv_item['measurement']; ?></td>
						<td><?php echo $sirv_item['quantity']; ?></td>
						<td align="right"><?php echo number_format( $sirv_item['unit_price'] , 4 , '.' , ',' ); ?></td>
						<td align="right"><?php echo number_format( $sirv_item['unit_price'] * $sirv_item['quantity'] , 2 , '.' , ',' ); ?></td>
						<td><?php echo $sirv_item['remark']; ?></td>
						<td><?php echo $sirv_item['serial']; ?></td>
					</tr>
				<?php
				}
			}
		} 
	}
		if($total_cost >0){
		?>
		<tr >
			<td colspan="6" align="right"><b><?php echo $categories [$i]['ImsItemCategory']['name'].' ';?>Total Cost:</b></td>
			<td align="right" bgcolor="#A9F5E1"><?php echo number_format( $total_cost , 2 , '.' , ',' ); ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	<?php
	}
	}
	?>
    <tr bgcolor="#A9E2F3">
        <td colspan="6" align="right"><b>Over All Cost:</b></td>
        <td align="right"><b><?php echo number_format( $total_price , 2 , '.' , ',' ); ?></b></td>
        <td>&nbsp;</td>
		<td>&nbsp;</td>
    </tr>
</table>
<br/><br/>

<b align="left"><font color="#045FB4">Booked by Head Office </font></b>
<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
        <th>N<u>o</u>.</th>
		<th>Code N<u>o</u>.</th>
        <th>Description</th>
        <th>Unit of Meas.</th>
        <th>Quantity</th>
        <th>Unit Price</th>
        <th>Total Price</th>
        <th>Remarks</th>
		<th>Serial</th>
    </tr>
    <?php $count = 0; $color = array(0 => 'dddddd', 1 => 'eeeeee'); $total_price = 0;
	
	$categories = $this->requestAction(
		array(
			'controller' => 'ims_sirvs', 
			'action' => 'getcategories')
	);
	for($i =0; $i< count($categories); $i++)
	{	
		$total_cost = 0;
		foreach ($categories [$i]['child'] as $child)
		{
			 foreach($sirv['ImsSirvItem'] as $sirv_item) {	
				
				$result = $this->requestAction(
								array(
									'controller' => 'ims_sirvs', 
									'action' => 'getitem'), 
								array('itemid' => $sirv_item['ims_item_id'])
							);
				
				if($child['ImsItemCategory']['id'] == $result['ims_item_category_id']){
					if($result['booked'] == 1){
					$total_price += $sirv_item['unit_price'] * $sirv_item['quantity'];
					$total_cost += $sirv_item['unit_price'] * $sirv_item['quantity'];
				?>
					<tr bgcolor="#<?php echo $color[$count % 2]; ?>">
						<td><?php echo $count++ + 1; ?></td>
						<td><?php echo '<b><i>' . $result['description'] . '</i></b>'; ?></td>
						<td><?php echo $result['name'];  ?></td>
						<td><?php echo $sirv_item['measurement']; ?></td>
						<td><?php echo $sirv_item['quantity']; ?></td>
						<td align="right"><?php echo number_format( $sirv_item['unit_price'] , 2 , '.' , ',' ); ?></td>
						<td align="right"><?php echo number_format( $sirv_item['unit_price'] * $sirv_item['quantity'] , 2 , '.' , ',' ); ?></td>
						<td><?php echo $sirv_item['remark']; ?></td>
						<td><?php echo $sirv_item['serial']; ?></td>
					</tr>
				<?php
				}
			}
		} 
	}
		if($total_cost >0){
		?>
		<tr >
			<td colspan="6" align="right"><b><?php echo $categories [$i]['ImsItemCategory']['name'].' ';?>Total Cost:</b></td>
			<td align="right" bgcolor="#A9F5E1"><?php echo number_format( $total_cost , 2 , '.' , ',' ); ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	<?php
	}
	}
	?>
    <tr bgcolor="#A9E2F3">
        <td colspan="6" align="right"><b>Over All Cost:</b></td>
        <td align="right"><b><?php echo number_format( $total_price , 2 , '.' , ',' ); ?></b></td>
        <td>&nbsp;</td>
		<td>&nbsp;</td>
    </tr>
</table>
<br/><br/>

<b align="left"><font color="blue">Adjustment</font></b>
<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
        <th>N<u>o</u>.</th>
		<th>Code N<u>o</u>.</th>
        <th>Description</th>
        <th>Unit of Meas.</th>
        <th>Quantity</th>
        <th>Unit Price</th>
        <th>Total Price</th>
        <th>Remarks</th>
		<th>Serial</th>
    </tr>
    <?php $count = 0; $color = array(0 => 'dddddd', 1 => 'eeeeee'); $total_price = 0;
	
	$categories = $this->requestAction(
		array(
			'controller' => 'ims_sirvs', 
			'action' => 'getcategories')
	);
	for($i =0; $i< count($categories); $i++)
	{	
		$total_cost = 0;
		foreach ($categories [$i]['child'] as $child)
		{
			 foreach($sirvArray as $sirv_item) {	
				
				$grn = $this->requestAction(
								array(
									'controller' => 'ims_sirvs', 
									'action' => 'getgrn'), 
								array('sirvitemid' => $sirv_item['id'])
							);
						
				$result = $this->requestAction(
								array(
									'controller' => 'ims_sirvs', 
									'action' => 'getitem'), 
								array('itemid' => $sirv_item['ims_item_id'])
							);
				
				if($child['ImsItemCategory']['id'] == $result['ims_item_category_id']){
					
					$total_price += $sirv_item['unit_price'] * $sirv_item['quantity'];
					$total_cost += $sirv_item['unit_price'] * $sirv_item['quantity'];
				?>
					<tr bgcolor="#<?php echo $color[$count % 2]; ?>">
						<td><?php echo $count++ + 1; ?></td>
						<td><?php echo '<b><i>' . $result['description'] . '</i></b>'; ?></td>
						<td><?php echo $result['name'];  ?></td>
						<td><?php echo $sirv_item['measurement']; ?></td>
						<td><?php echo $sirv_item['quantity']; ?></td>
						<td align="right"><?php echo number_format( $sirv_item['unit_price'] , 2 , '.' , ',' ); ?></td>
						<td align="right"><?php echo number_format( $sirv_item['unit_price'] * $sirv_item['quantity'] , 2 , '.' , ',' ); ?></td>
						<td><?php echo $sirv_item['remark']; ?></td>
						<td><?php echo $sirv_item['serial']; ?></td>
					</tr>
				<?php
			
			}
		} 
	}
		if($total_cost >0){
		?>
		<tr >
			<td colspan="6" align="right"><b><?php echo $categories [$i]['ImsItemCategory']['name'].' ';?>Total Cost:</b></td>
			<td align="right" bgcolor="#A9F5E1"><?php echo number_format( $total_cost , 2 , '.' , ',' ); ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	<?php
	}
	}
	?>
    <tr bgcolor="#A9E2F3">
        <td colspan="6" align="right"><b>Over All Cost:</b></td>
        <td align="right"><b><?php echo number_format( $total_price , 2 , '.' , ',' ); ?></b></td>
        <td>&nbsp;</td>
		<td>&nbsp;</td>
    </tr>
</table>
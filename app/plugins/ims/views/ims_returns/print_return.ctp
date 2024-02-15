<center>
    <img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" />
    <!--<h2>ABAY BANK S.C</h2>-->
    <h1><U>Return</U></h1>
</center>
<table border="0" width="100%">
    <tr>
	    <td> </td>
		<td> </td>
        <td  align="center">Date: <?php echo date('d-M-Y', strtotime($return['ImsReturn']['created'])); ?></td>
    </tr>
    <tr>
        <td align="left" valign="top" >Returned From Management / Branch: <u><?php					
						echo '&nbsp' . $return['ReturningBranch']['name'];?></u><br/>
            
        </td>
        <td align="left" valign="top">
            Return N<u>o</u>: <b><?php echo $return['ImsReturn']['name'];?> </b><br/>       
		
        </td>  
    </tr>
</table>
<hr/>

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
		<th>SIRV</th>
    </tr>
    <?php $count = 0; $color = array(0 => 'dddddd', 1 => 'eeeeee'); $total_price = 0;
	
	$categories = $this->requestAction(
		array(
			'controller' => 'ims_returns', 
			'action' => 'getcategories')
	);
	for($i =0; $i< count($categories); $i++)
	{	
		$total_cost = 0;
		foreach ($categories [$i]['child'] as $child)
		{
			 foreach($return['ImsReturnItem'] as $return_item) {		
				
				$result = $this->requestAction(
								array(
									'controller' => 'ims_returns', 
									'action' => 'getitem'), 
								array('itemid' => $return_item['ims_item_id'])
							);
				if($child['ImsItemCategory']['id'] == $result['ims_item_category_id']){
				$total_price += $return_item['unit_price'] * $return_item['quantity'];
				$total_cost += $return_item['unit_price'] * $return_item['quantity'];
				
				$sirv = $this->requestAction(
								array(
									'controller' => 'ims_returns', 
									'action' => 'getsirv'), 
								array('sirvitemid' => $return_item['ims_sirv_item_id'])
							);
			?>
			<tr bgcolor="#<?php echo $color[$count % 2]; ?>">
				<td><?php echo $count++ + 1; ?></td>
				<td><?php echo '<b><i>' . $result['description'] . '</i></b>'; ?></td>
				<td><?php echo $result['name'];  ?></td>
				<td><?php echo $return_item['measurement']; ?></td>
				<td><?php echo $return_item['quantity']; ?></td>
				<td align="right"><?php echo number_format( $return_item['unit_price'] , 4 , '.' , ',' ); ?></td>
				<td align="right"><?php echo number_format( $return_item['unit_price'] * $return_item['quantity'] , 2 , '.' , ',' ); ?></td>
				<td><?php echo $return_item['remark']; ?></td>
				<td><?php echo $sirv['name']; ?></td>
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
		</tr>
	<?php
	}
	}
	?>
    <tr >
        <td colspan="6" align="right" bgcolor="#A9E2F3"><b>Over All Cost:</b></td>
        <td align="right" bgcolor="#A9E2F3"><b><?php echo number_format( $total_price , 2 , '.' , ',' ); ?></b></td>
    </tr>	
</table></br>
			Amount in words : <u> <?php
				$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
				echo $f->format(number_format( $total_price , 2 , '.' , '' ));?></u>
<!--<table width="100%">
	<tr></br>
		<td align="center">
			Received in good condition</br>
		</td>
	</tr>	
</table>
<table width="90%">
	<tr>
		<td align="left"  ></br>
			Prepared by:&nbsp;____________________</br>
			Signature:&nbsp;______________________
		</td>
		<td align="left" ></br>
			Approved by:&nbsp;__________________</br>
			Signature:&nbsp;______________________
		</td>
		<td align="left" ></br>
			Store Keeper:&nbsp;___________________</br>
			Signature:&nbsp;______________________
		</td>
		<td align="left" ></br>
			Received by:&nbsp;_________
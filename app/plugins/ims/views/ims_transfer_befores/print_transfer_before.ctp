

<center>
    <img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" />
    <!--<h2>ABAY BANK S.C</h2>-->
    <h1><U>Fixed Asset Transfer Form (FATF)</U></h1>
</center>
<table border="0" width="100%">
    <tr>
	    <td align="left" valign="top">
            FATF N<u>o</u>: <b><?php echo $transferBefore['ImsTransferBefore']['name'];?> </b><br/>       
		
        </td> 
		<td> </td>
        <td  align="center">Date: <?php echo date('d-M-Y', strtotime($transferBefore['ImsTransferBefore']['created'])); ?></td>
    </tr>
	<tr>
		<td align="left" valign="top" style="padding-top:15px;">
			<b><u>Asset Transferred From<u></b>
		</td>
		<td align="left" valign="top" style="padding-top:15px;">
			<b><u>Asset Transferred To</u></b>
		</td>
	</tr>
    <tr>
        <td align="left" valign="top" style="padding-top:10px;">Branch : <u><?php
						$result = $this->requestAction(
							array(
								'controller' => 'ims_transfer_befores', 
								'action' => 'getUser'), 
							array('userid' => $transferBefore['TransfferingUser']['id'])
						);
						echo '&nbsp' . $transferBefore['TransfferingBranch']['name'];?></u><br/>
            
        </td>
		<td align="left" valign="top" style="padding-top:10px;">Branch : <u><?php
						$result = $this->requestAction(
							array(
								'controller' => 'ims_transfer_befores', 
								'action' => 'getUser'), 
							array('userid' => $transferBefore['ReceivingUser']['id'])
						);
						echo '&nbsp' . $transferBefore['ReceivingBranch']['name'];?></u><br/>
            
        </td>	
		
		
         
    </tr>
	<tr>
		<td align="left" valign="top" style="padding-top:5px;">Name : <u><?php
						$result = $this->requestAction(
							array(
								'controller' => 'ims_transfer_befores', 
								'action' => 'getUser'), 
							array('userid' => $transferBefore['TransfferingUser']['id'])
						);
						echo '&nbsp' . $result['Person']['first_name'].' '.$result['Person']['middle_name'].' '.$result['Person']['last_name'];?></u><br/>
            
        </td>
		<td align="left" valign="top" style="padding-top:5px;">Name : <u><?php
						$result = $this->requestAction(
							array(
								'controller' => 'ims_transfer_befores', 
								'action' => 'getUser'), 
							array('userid' => $transferBefore['ReceivingUser']['id'])
						);
						echo '&nbsp' . $result['Person']['first_name'].' '.$result['Person']['middle_name'].' '.$result['Person']['last_name'];?></u><br/>
            
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
        <th>Tag</th>
    </tr>
    <?php $count = 0; $color = array(0 => 'dddddd', 1 => 'eeeeee'); $total_price = 0;
	
	$categories = $this->requestAction(
		array(
			'controller' => 'ims_transfer_befores', 
			'action' => 'getcategories')
	);
	for($i =0; $i< count($categories); $i++)
	{	
		$total_cost = 0;
		foreach ($categories [$i]['child'] as $child)
		{
			 foreach($transferBefore['ImsTransferItemBefore'] as $transfer_item) {		
				
				$result = $this->requestAction(
								array(
									'controller' => 'ims_transfer_befores', 
									'action' => 'getitem'), 
								array('itemid' => $transfer_item['ims_item_id'])
							);
				if($child['ImsItemCategory']['id'] == $result['ims_item_category_id']){
				$total_price += $transfer_item['unit_price'] * $transfer_item['quantity'];
				$total_cost += $transfer_item['unit_price'] * $transfer_item['quantity'];
				
				
			?>
			<tr bgcolor="#<?php echo $color[$count % 2]; ?>">
				<td><?php echo $count++ + 1; ?></td>
				<td><?php echo '<b><i>' . $result['description'] . '</i></b>'; ?></td>
				<td><?php echo $result['name'];  ?></td>
				<td><?php echo $transfer_item['measurement']; ?></td>
				<td><?php echo $transfer_item['quantity']; ?></td>
				<td align="right"><?php echo number_format( $transfer_item['unit_price'] , 4 , '.' , ',' ); ?></td>
				<td align="right"><?php echo number_format( $transfer_item['unit_price'] * $transfer_item['quantity'] , 2 , '.' , ',' ); ?></td>
				<td><?php echo $transfer_item['tag']; ?></td>
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
<table width="100%">
	<tr>
		<td align="left" valign="top" style="padding-top:35px;">signature of transferor <br/><br/>
            _________________
        </td>
		<td align="left" valign="top" style="padding-top:35px;">signature of recipient <br/><br/>
            _________________
        </td>
		<td align="left" valign="top" style="padding-top:35px;">signature of observer <br/><br/>
            _________________
        </td>
		<td align="left" valign="top" style="padding-top:35px;">signature of approver <br/><br/>
            _________________
        </td>
	</tr>
	
</table>
<table>
	<tr>
		<td align="left" valign="top" style="padding-top:15px;">
			<b>This form is prepared in three copies:- 1<sup>st</sup> copy for facility, 2<sup>nd</sup> copy for recipient and 3<sup>rd</sup> copy for transferor.</b> 
		</td>
	</tr>
</table>
<!--<table width="90%">
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
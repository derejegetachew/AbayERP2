<center>
    <img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" />
    <!--<h2>ABAY BANK S.C</h2>-->
    <h1><U>Stock Issue & Receiving Voucher (SIRV)</U></h1>
</center>
<table border="0" width="100%">
    <tr>
	    <td align="left" valign="top"> 
			Store: <b><?php echo $sirv['ImsStore']['name']?></b>
		</td>
		<td> </td>
		<td> </td>
        <td  align="center">Date: <?php date_default_timezone_set("Africa/Addis_Ababa"); echo date('d-m-Y '); ?></td>
    </tr>
    <tr>
        <td align="left" valign="top" >Management / Branch: <u><?php 
			$result = $this->requestAction(
							array(
								'controller' => 'ims_requisitions', 
								'action' => 'getbranch'), 
							array('branchid' => $sirv['ImsRequisition']['branch_id'])
						);					
						echo '&nbsp' . $result;?></u><br/>
            Requisition N<u>o</u>: <u><?php echo '&nbsp' . $sirv['ImsRequisition']['name']; ?></u><br/>
        </td> 
		<td align="left" valign="top">
            Requested by: <b><?php echo $sirv['RequestedUser']['Person']['first_name'].' '.$sirv['RequestedUser']['Person']['middle_name'].' '.$sirv['RequestedUser']['Person']['last_name'];?> </b><br/>
			SIRV created by: <b><?php echo $sirv['SirvUser']['Person']['first_name'].' '.$sirv['SirvUser']['Person']['middle_name'].' '.$sirv['SirvUser']['Person']['last_name'];?></b><br/>
        </td>  
		<td align="left" valign="top">
			<?php 
				if($sirv['ImsDelegate'][0]['user_id'] == null){
			?>
					Delegate Name: <b><?php echo $sirv['ImsDelegate'][0]['name'];?> </b><br/>
					Delegate Phone N<u>o</u>: <b><?php echo $sirv['ImsDelegate'][0]['phone'];?></b><br/>
			<?php
				}
				else if ($sirv['ImsDelegate'][0]['user_id'] != null)
				{
				$result = $this->requestAction(
							array(
								'controller' => 'ims_requisitions', 
								'action' => 'getUser'), 
							array('userid' => $sirv['ImsDelegate'][0]['user_id'])
						);

				$employee = $this->requestAction(
							array(
								'controller' => 'ims_requisitions', 
								'action' => 'getEmployee'), 
							array('userid' => $sirv['ImsDelegate'][0]['user_id'])
						);
						
			?>
					Delegate Name: <b><?php echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.$result['Person']['last_name'];?> </b><br/>
					Delegate Phone N<u>o</u>: <b><?php echo $employee['Employee']['telephone'];?></b><br/>
			<?php
				}
			?>
            
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
    </tr>
    <?php $count = 0; $color = array(0 => 'dddddd', 1 => 'eeeeee'); $total_price = 0; ?>
    <?php foreach($sirv['ImsRequisitionItem'] as $sirv_item) { //$total_price += $sirv_item['unit_price'] * $sirv_item['issued'];
		$result = $this->requestAction(
						array(
							'controller' => 'ims_requisitions', 
							'action' => 'getitem'), 
						array('itemid' => $sirv_item['ims_item_id'])
					);
	?>
    <tr bgcolor="#<?php echo $color[$count % 2]; ?>">
        <td><?php echo $count++ + 1; ?></td>
		<td><?php echo '<b><i>' . $result['description'] . '</i></b>'; ?></td>
        <td><?php echo $result['name'];  ?></td>
        <td><?php echo $sirv_item['measurement']; ?></td>
        <td><?php echo $sirv_item['issued']; ?></td>
        <td align="right"><?php echo ''//number_format( $sirv_item['unit_price'] , 2 , '.' , ',' ); ?></td>
        <td align="right"><?php echo ''//number_format( $sirv_item['unit_price'] * $sirv_item['issued'] , 2 , '.' , ',' ); ?></td>
		<td><?php echo $sirv_item['remark']; ?></td>
    </tr>
    <?php } ?>
    <tr bgcolor="#<?php echo $color[$count % 2]; ?>">
        <td colspan="6" align="right"><b>Total Cost:</b></td>
        <td align="right"><?php echo ''//number_format( $total_price , 2 , '.' , ',' ); ?></td>
        <td>&nbsp;</td>
    </tr>
</table>


<table width="100%">
	<tr></br>
		<td align="center">
		
		</td>
	</tr>	
</table>
<table width="90%">

<br/><br/>
	 <tr>
		<td align="left"  ></br>
			Issued by:&nbsp;______________________</br>
      
			Signature:&nbsp;______________________</br>
      Date :&nbsp;_________________________
		</td>
   <td></td>
		<td align="left" ></br>
			Delivered By:&nbsp;____________________</br>
      
			Signature:&nbsp;_______________________</br>
      Date :&nbsp;__________________________
		</td>
  </tr>
   
   <br/> <br/>
   <tr >
		<td align="left" ></br>
			Approved by:&nbsp;___________________</br>
      
			Signature:&nbsp;  _____________________</br>
      
     	Date :&nbsp;_________________________
		</td>
    <td></td>
   	<td align="left" ></br>
			Received By:&nbsp;___________________</br>
      
			Signature:&nbsp;_____________________</br>
      
      Date :&nbsp;________________________
		</td>
   
   </tr>
<center>
	<img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" />
    <!--<h2>ABAY BANK S.C</h2>-->
    <h1>Transfer Store Items</h1>
</center>
<table border="0" width="100%">
    <tr>
		<td></td>
		<td></td>
		<td></td>
        <td  align="center">Date: <?php date_default_timezone_set("Africa/Addis_Ababa"); echo date('d-m-Y '); ?></td>
    </tr>
	
    <tr>		
        <td colspan="1" style="padding:0 0 0 55px;" valign="top"></br>
            Transfer From: <b><?php echo $transfer['FromStore']['name'];?> </b><br/>
            Transfer To: <b><?php echo $transfer['ToStore']['name'];?> </b><br/>
			Transfer N<u>o</u>.: <b><?php echo $transfer['ImsTransferStoreItem']['name'];?> </b>
        </td>        
    </tr>    
</table>
<hr/>

<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
        <th>N<u>o</u>.</th>
		<th>Item Code</th>
        <th>Description</th>
        <th>Unit of Measure</th>
        <th>Quantity</th>     
        <th>Remarks</th>
    </tr>	
    <?php $count = 0; $color = array(0 => 'dddddd', 1 => 'eeeeee'); ?>
    <?php foreach($transfer['ImsTransferStoreItemDetail'] as $transfer_item) {?>
    <tr bgcolor="#<?php echo $color[$count % 2]; ?>">
        <td><?php echo $count++ + 1; ?></td>
		<td><?php echo $transfer_item['ImsItem']['description'];?></td>
        <td><?php echo $transfer_item['ImsItem']['name']?></td>
        <td><?php echo $transfer_item['measurement']; ?></td>
        <td><?php if ($transfer['ImsTransferStoreItem']['status'] == 'accepted'){
					echo $transfer_item['issued']; 
				}
				else echo $transfer_item['quantity'];
			?>
		</td>
        <td><?php echo $transfer_item['ImsItem']['remark'];?></td>
    </tr>
    <?php } ?>   
</table>
<table>
	<tr>
		<td align="left" colspan ="2"></br>
			I have received the above items in good condition.
		</td>
	</tr><br/><br/>
	<tr>
		<td align="left" style="padding:0 0 0 55px;"></br>
			<b>From Store Keeper</b><br/><br/>
			Name:<?php echo $transfer['FromStoreKeeper']['Person']['first_name'].' '.$transfer['FromStoreKeeper']['Person']['middle_name'].' '.$transfer['FromStoreKeeper']['Person']['last_name']?><br/>
			Signature:.......................................
		</td>
		<td align="left" style="padding:0 0 0 105px;"></br>
			<b>To Store Keeper</b><br/><br/>
			Name:<?php echo $transfer['ToStoreKeeper']['Person']['first_name'].' '.$transfer['ToStoreKeeper']['Person']['middle_name'].' '.$transfer['ToStoreKeeper']['Person']['last_name']?><br/>
			Signature:.......................................
		</td>
		<td align="left" style="padding:0 0 0 105px;"></br>
			<b>Witness</b><br/><br/>
			Name:.....................................<br/>
			Signature:.......................................
		</td>
	</tr>
</table>

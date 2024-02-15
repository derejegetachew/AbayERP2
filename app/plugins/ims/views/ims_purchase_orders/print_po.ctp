<center>
    <img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" />
    <!--<h2>ABAY BANK S.C</h2>-->
    <h1>PURCHASE ORDER (PO)</h1>
</center>
<table border="0" width="100%">
	<tr>
	</tr>
	<tr>
		<td align="left" valign="top" colspan="1">
            To: <b><u><?php echo $purchase_order['ImsSupplier']['name'];?> </u></b><br/>
			Supplier's Tin N<u>o</u>.:<?php echo $purchase_order['ImsSupplier']['tin'];?><br/>
			Proforma Invoice N<u>o</u>.:&nbsp;_______________<br/>
			
        </td>	
    
	    <td align="left" valign="MIDDLE" colspan="1"> 
			PO Date:&nbsp;<u><?php date_default_timezone_set("Africa/Addis_Ababa"); echo date('d-m-Y '); ?></u> <br/>
			PO N<u>o</u>.:&nbsp;<b><?php echo $purchase_order['ImsPurchaseOrder']['name'];?> </b><br/>
		</td>
		
        <td  align="left">
			<b>Buyer's Information</b><br/>			
			TIN N<u>o</u>.: 0012812734<br/>
			Tel. No: 0115549741, &nbsp;&nbsp;0115570753<br/>
			
            <!--Date: <?php date_default_timezone_set("Africa/Addis_Ababa"); echo date('d-m-Y '); ?> <br/>  -->         
            Fax: 0115570735 <br/>
			P.O.Box: 5887 <br/>
            Addis Ababa, Ethiopia
		</td>
    </tr>
    
    <tr>
        
		<td>
		</td>
        <td align="left" valign="top" colspan="3">
            Terms of Payment: ___________________________ <br/>
			Advance Payment (if any): ____________________ <br/>
            Terms of Delivery: ___________________________ <br/>
            Time of Delivery: ____________________________ <br/>
			Place of Delivery: ____________________________ <br/>
        </td>
		<td>
		</td>
    </tr>
    <tr>
        <td colspan="4" align="left"></br>
            Please supply the under listed item(s)/service(s) as per the terms and conditions stated in this Purchase Order
			in reference to your proforma Invoice N<u>o</u>.___________________________dated _____________________________.<br/>
        </td>
    </tr>
</table>
<hr/>

<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
        <th>Item N<u>o</u>.</th>
        <th>DESCRIPTION</th>
        <th>Unit of Measure</th>
        <th>Quantity</th>
        <th>Unit Price</th>
        <th>Total Price</th>
        <th>Remarks</th>
    </tr>
    <?php $count = 0; $color = array(0 => 'dddddd', 1 => 'eeeeee'); $total_price = 0; ?>
    <?php foreach($purchase_order['ImsPurchaseOrderItem'] as $po_item) { $total_price += $po_item['unit_price'] * $po_item['ordered_quantity']; ?>
    <tr bgcolor="#<?php echo $color[$count % 2]; ?>">
        <td><?php echo $count++ + 1; ?></td>
        <td><?php echo $po_item['ImsItem']['name'] . '<br><b><i>' . $po_item['ImsItem']['description'] . '</i></b>'; ?></td>
        <td><?php echo $po_item['measurement']; ?></td>
        <td><?php echo $po_item['ordered_quantity']; ?></td>
        <td align="right"><?php echo number_format( $po_item['unit_price'] , 4 , '.' , ',' ); ?></td>
        <td align="right"><?php echo number_format( $po_item['unit_price'] * $po_item['ordered_quantity'] , 2 , '.' , ',' ); ?></td>
        <td><?php echo $po_item['remark']; ?></td>
    </tr>
    <?php } ?>
    <tr bgcolor="#<?php echo $color[$count % 2]; ?>">
        <td colspan="5" align="right"><b>Total:</b></td>
        <td align="right"><?php echo number_format( $total_price , 2 , '.' , ',' ); ?></td>
        <td>&nbsp;</td>
    </tr>
</table>
<table>
	<tr></br>
		<td align="left">
			Amount in words : <u> <?php
				$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
				echo $f->format(number_format( $total_price , 2 , '.' , '' ));?></u></br></br></br>
		</td>
	</tr>	
</table>
<table width="100%">
	<tr>
		<td align="left"  ></br>
			<center><u><?php echo $purchase_order['User']['Person']['first_name'] . ' ' . $purchase_order['User']['Person']['middle_name'] . ' ' . 
                    $purchase_order['User']['Person']['last_name']; ?></u></center></br>
			<center>Prepared by</center>
		</td>
		<td align="left" ></br>
			<center><u><?php echo $purchase_order['ImsPurchaseOrder']['approved_by'] <> 0? $purchase_order['ApprovedUser']['Person']['first_name'] . ' ' . $purchase_order['ApprovedUser']['Person']['middle_name'] . ' ' . 
                    $purchase_order['ApprovedUser']['Person']['last_name']: ''; ?></u></center></br>
			<center>Checked by</center>
		</td>
		<td align="left" ></br>
			<center><u>Eyob Nigusse</u></center></br>
			<center>Approved by</center>
		</td>
	</tr>
	<tr>
        <td colspan="4" align="left"></br>
            <p style="margin-left:2.5em;"><b><u>Terms and Conditions:-</u></b></p>
			<div style ="background-color:rgba(0,0,50,0.1); font-size:13px;">The Purchase Order (PO) shall serve as a contractual agreement between the Bank and the Supplier, with offering
			the better quality item(s)/service(s) with reasonable price. Delay in delivery or delivering defective item(s) or
			service(s) which do not conform or other causes shall entitle ABAY BANK S.C to revoke this purchase and 
			in its discretion, to take such steps or make such claim as it may deem appropriate.</br> 
			<center><i><b>Abay: "The Trustworthy Bank"</b></i></center></div>
        </td>
    </tr>
</table>

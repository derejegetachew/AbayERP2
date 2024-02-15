<center>
    <h2>ABAY BANK S.C</h2>
    <h1>PURCHASE ORDER</h1>
</center>
<table border="0" width="100%">
    <tr>
        <td colspan="4" align="center">TIN: 0012812734</td>
    </tr>
    <tr>
        <td align="left" valign="top">
            Date: _______________________ <br/>
            Your Ref: ___________________ <br/>
        </td>
        <td align="left" valign="top" colspan="2">
            Order No: _____________ <br/>
            Our Ref: ______________ <br/>
        </td>
        <td align="left" valign="top">
            P.O.Box: __________________ <br/>
            Tel. No: __________________ <br/>
            Date: _____________________ <br/>
            Date: _____________________ <br/>
            Fax: ______________________ <br/>
            Addis Ababa, Ethiopia
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" colspan="2">
            To: ________________________________ <br/>
             ___________________________________ <br/>
        </td>
        <td align="left" valign="top" colspan="2">
            Terms of Payment: ___________________________ <br/>
            Terms of Delivery: ___________________________ <br/>
            Time of Delivery: ____________________________ <br/>
        </td>
    </tr>
    <tr>
        <td colspan="4" align="left">
            Please supply the under mentioned items as per your proforma Invoice No.___________________<br/>
            _____________ dated ________________________ in accordance with terms and condition <br/>
            stated in your proforma invoice.
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
    <?php foreach($purchase_order['PurchaseOrderItem'] as $po_item) { $total_price += $po_item['unit_price'] * $po_item['ordered_quantity']; ?>
    <tr bgcolor="#<?php echo $color[$count % 2]; ?>">
        <td><?php echo $count++ + 1; ?></td>
        <td><?php echo $po_item['Item']['name'] . '<br>' . $po_item['Item']['description']; ?></td>
        <td><?php echo $po_item['measurement']; ?></td>
        <td><?php echo $po_item['ordered_quantity']; ?></td>
        <td align="right"><?php echo number_format( $po_item['unit_price'] , 4 , '.' , ',' ); ?></td>
        <td align="right"><?php echo number_format( $po_item['unit_price'] * $po_item['ordered_quantity'] , 2 , '.' , ',' ); ?></td>
        <td>&nbsp;</td>
    </tr>
    <?php } ?>
    <tr bgcolor="#<?php echo $color[$count % 2]; ?>">
        <td colspan="5" align="right"><b>Total:</b></td>
        <td align="right"><?php echo number_format( $total_price , 2 , '.' , ',' ); ?></td>
        <td>&nbsp;</td>
    </tr>
</table>

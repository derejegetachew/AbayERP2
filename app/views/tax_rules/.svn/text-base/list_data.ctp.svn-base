{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($tax_rules as $tax_rule){ if($st) echo ","; ?>			{
				"id":"<?php echo $tax_rule['TaxRule']['id']; ?>",
				"name":"<?php echo $tax_rule['TaxRule']['name']; ?>",
				"min":"<?php echo $tax_rule['TaxRule']['min']; ?>",
				"max":"<?php echo $tax_rule['TaxRule']['max']; ?>",
				"percent":"<?php echo $tax_rule['TaxRule']['percent']; ?>",
                                "deductable":"<?php echo $tax_rule['TaxRule']['deductable']; ?>",
				"payroll":"<?php echo $tax_rule['Payroll']['name']; ?>"			}
<?php $st = true; } ?>		]
}
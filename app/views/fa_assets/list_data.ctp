{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($fa_assets as $fa_asset){ if($st) echo ","; ?>			{
				"id":"<?php echo $fa_asset['FaAsset']['id']; ?>",
				"reference":"<?php if($fa_asset['FaAsset']['approved']==0) {echo '<font color=red>'.$fa_asset['FaAsset']['reference'].'</font>';}else{echo '<font color=black>'.$fa_asset['FaAsset']['reference'].'</font>';}  ?>",
				"name":"<?php echo $fa_asset['FaAsset']['name']; ?>",
				"location":"<?php echo $fa_asset['FaAsset']['branch_name']; ?>",
				"original_cost":"<?php echo $fa_asset['FaAsset']['original_cost']; ?>",
				"book_date":"<?php echo $fa_asset['FaAsset']['book_date']; ?>",
				"sold":"<?php echo $fa_asset['FaAsset']['sold']; ?>",
				"sold_date":"<?php echo $fa_asset['FaAsset']['sold_date']; ?>",
   	  "sold_amount":"<?php if($fa_asset['FaAsset']['sold_checker']==null) {echo '<font color=red>'.$fa_asset['FaAsset']['sold_amount'].'</font>';}else{echo '<font color=black>'.$fa_asset['FaAsset']['sold_amount'].'</font>';}  ?>",
				"tax_rate":"<?php echo $fa_asset['FaAsset']['tax_rate']*100; ?>",
				"tax_cat":"<?php echo $fa_asset['FaAsset']['tax_cat']; ?>",
				"ifrs_class":"<?php echo $fa_asset['FaAsset']['ifrs_class']; ?>",
				"ifrs_cat":"<?php echo $fa_asset['FaAsset']['ifrs_cat']; ?>",
				"ifrs_useful_age":"<?php echo $fa_asset['FaAsset']['ifrs_useful_age']; ?>",
				"residual_value_rate":"<?php echo $fa_asset['FaAsset']['residual_value_rate']*100; ?>"			}
<?php $st = true;  } ?>		]
}
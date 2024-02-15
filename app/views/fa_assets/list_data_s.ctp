{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($fa_assets as $fa_asset){ if($st) echo ","; ?>			{
				"id":"<?php echo $fa_asset['FaAsset']['id']; ?>",
				"reference":"<?php if($fa_asset['FaAsset']['approved']==0) {echo '<font color=red>'.$fa_asset['FaAsset']['reference'].'</font>';}else{echo '<font color=black>'.$fa_asset['FaAsset']['reference'].'</font>';}  ?>",
				"name":"<?php echo $fa_asset['FaAsset']['name']; ?>",
				"location":"<?php echo $fa_asset['FaAsset']['location']; ?>",
				"original_cost":"<?php echo $fa_asset['FaAsset']['original_cost']; ?>",
				"book_date":"<?php echo $fa_asset['FaAsset']['book_date']; ?>",
				"sold":"<?php echo $fa_asset['FaAsset']['sold']; ?>",
				"sold_date":"<?php echo $fa_asset['FaAsset']['sold_date']; ?>",
				"sold_amount":"<?php echo $fa_asset['FaAsset']['sold_amount']; ?>",
			  "maker":"<?php echo $fa_asset['FaAsset']['sold_maker']; ?>"
        	}
<?php $st = true;  } ?>		]
}
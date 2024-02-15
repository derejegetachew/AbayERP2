{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($fa_asset_logs as $fa_asset_log){ if($st) echo ","; ?>			{
				"id":"<?php echo $fa_asset_log['FaAssetLog']['id']; ?>",
				"fa_asset":"<?php echo $fa_asset_log['FaAsset']['name']; ?>",
				"branch_name":"<?php echo $fa_asset_log['FaAssetLog']['branch_name']; ?>",
				"branch_code":"<?php echo $fa_asset_log['FaAssetLog']['branch_code']; ?>",
				"tax_rate":"<?php echo $fa_asset_log['FaAssetLog']['tax_rate']; ?>",
				"tax_cat":"<?php echo $fa_asset_log['FaAssetLog']['tax_cat']; ?>",
				"class":"<?php echo $fa_asset_log['FaAssetLog']['class']; ?>",
				"ifrs_cat":"<?php echo $fa_asset_log['FaAssetLog']['ifrs_cat']; ?>",
				"useful_age":"<?php echo $fa_asset_log['FaAssetLog']['useful_age']; ?>",
				"residual_value":"<?php echo $fa_asset_log['FaAssetLog']['residual_value']; ?>",
				"created_at":"<?php echo $fa_asset_log['FaAssetLog']['created_at']; ?>"			}
<?php $st = true; } ?>		]
}
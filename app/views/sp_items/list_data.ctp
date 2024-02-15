{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($sp_items as $sp_item){ if($st) echo ","; ?>			{
				"id":"<?php echo $sp_item['SpItem']['id']; ?>",
				"name":"<?php if($sp_item['SpItem']['suspend']==1){echo '<font color=red>'.$sp_item['SpItem']['name'].'</font>';}else{echo $sp_item['SpItem']['name'];} ?>",
				"desc":"<?php if($sp_item['SpItem']['suspend']==1){echo '<font color=red>'.$sp_item['SpItem']['desc'];}else{echo '<font color=black>'.$sp_item['SpItem']['desc'];} ?>",
				"price":"<?php if($sp_item['SpItem']['suspend']==1) {echo '<font color=red>'.$sp_item['SpItem']['price'];}else{echo '<font color=black>'.$sp_item['SpItem']['price'];} ?>",
				"um":"<?php if($sp_item['SpItem']['suspend']==1) {echo '<font color=red>'.$sp_item['SpItem']['um'];}else{echo '<font color=black>'.$sp_item['SpItem']['um'];} ?>",
				"cat":"<?php if($sp_item['SpItem']['suspend']==1) {echo '<font color=red>'.$sp_item['SpCat']['name'];}else{echo '<font color=black>'.$sp_item['SpCat']['name'];} ?>",
				"sp_item_group":"<?php if($sp_item['SpItem']['suspend']==1) {echo '<font color=red>'.$sp_item['SpItemGroup']['name'];}else{echo '<font color=black>'.$sp_item['SpItemGroup']['name'];} ?>",
				"created":"<?php if($sp_item['SpItem']['suspend']==1) {echo '<font color=red>'.$sp_item['SpItem']['created'];}else{echo '<font color=black>'.$sp_item['SpItem']['created'];} ?>",
				"modified":"<?php if($sp_item['SpItem']['suspend']==1){echo '<font color=red>'.$sp_item['SpItem']['modified'];}else{echo '<font color=black>'.$sp_item['SpItem']['modified'];} ?>"			}
<?php $st = true; } ?>		]
}
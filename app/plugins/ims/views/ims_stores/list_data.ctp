{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($stores as $store){ if($st) echo ","; ?>			{
            "id":"<?php echo $store['ImsStore']['id']; ?>",
            "name":"<?php echo $store['ImsStore']['name']; ?>",
            "address":"<?php echo $store['ImsStore']['address']; ?>",
			"store_keeper_one":"<?php if($store['ImsStore']['store_keeper_one'] != 0){echo $store['StoreKeeperOne']['Person']['first_name'].' '.$store['StoreKeeperOne']['Person']['middle_name'];} ?>",
			"store_keeper_two":"<?php if($store['ImsStore']['store_keeper_two'] != 0){echo $store['StoreKeeperTwo']['Person']['first_name'].' '.$store['StoreKeeperTwo']['Person']['middle_name'];} ?>",
			"store_keeper_three":"<?php if($store['ImsStore']['store_keeper_three'] != 0){echo $store['StoreKeeperThree']['Person']['first_name'].' '.$store['StoreKeeperThree']['Person']['middle_name'];} ?>",
			"store_keeper_four":"<?php if($store['ImsStore']['store_keeper_four'] != 0){echo $store['StoreKeeperFour']['Person']['first_name'].' '.$store['StoreKeeperFour']['Person']['middle_name'];} ?>",
            "created":"<?php echo $store['ImsStore']['created']; ?>",
            "modified":"<?php echo $store['ImsStore']['modified']; ?>"			}
<?php $st = true; } ?>		]
}
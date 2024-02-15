<?php

function create_SIRV($item_code,$measurement,$quantity,$remark,$lastid,$budget_year_id,$branch_id,$store_id,$serial)
	{
		global $items;
		global $serials;
		$code = explode('"', $item_code);
		$msr = explode('"', $measurement);
		$qnt = explode('"', $quantity);
		$rmk = explode('"', $remark);
		$srl = explode('"', $serial);
		//requested quantity
		if($qnt[0] != ""){		
			$rq = $rrq = $qnt[0];
		}
		else 
		$rq = $rrq = $qnt[1];
		
		
		
		$item = $this->ImsItem->find('first', array('conditions' => array('ImsItem.description' => $code[1])));
		// print_r($item);
		
		if($item['ImsItem']['ims_item_category_id'] == 30 and $srl[1] == "")
		{
			$serials = $serials . $item['ImsItem']['name'].', ';
		}

		else 
		{
			$conditions = array('ImsCard.ims_item_id' => $item['ImsItem']['id']);
			$card = $this->ImsCard->find('first', array('conditions' =>$conditions,'order'=>'ImsCard.id DESC'));
			$tb = $lb = $card['ImsCard']['balance'];
			
			///////////  check store balance   /////////////////////////////////
			$conditions_store = array('ImsStoresItem.ims_item_id' => $item['ImsItem']['id'],'ImsStoresItem.ims_store_id' => $store_id);
			$storesitem = $this->ImsStoresItem->find('first', array('conditions' =>$conditions_store));
			
			if($storesitem['ImsStoresItem']['balance'] != null and $storesitem['ImsStoresItem']['balance'] > 0)
			{
				if($rq > $storesitem['ImsStoresItem']['balance']){
					$rq = $storesitem['ImsStoresItem']['balance'];
					$rrq = $rq;
				}
				//read the last n incoming items which are not in 'D' states in descending order of their created
				$value = array("NOT"=>array('ImsCard.status'=>array('D','')));
				$conditions_item = array('ImsCard.ims_item_id' => $item['ImsItem']['id'],'ImsCard.in_quantity !=' => 0,$value);
				$in_items = $this->ImsCard->find('all', array('conditions' =>$conditions_item,'order'=>'ImsCard.id DESC'));
				
				if(empty($in_items)){
					$items = $items . $item['ImsItem']['name'].', ';
				}
				else if(!empty($in_items))
				{
					foreach($in_items as $in_item)
					{
						if($in_item['ImsCard']['in_quantity'] < $lb)
						{
							//there is at least one record above
							$lb = $lb - $in_item['ImsCard']['in_quantity'];
							if($lb < $rq)
							 {	
								if($rrq > $tb)
								{
									$rrq = $tb;
								}
								$q = $rrq - $lb;
								if($q > $tb)
								{
									$q = $tb;
								}
								$balance = $tb - $q;
								if($balance < 0)
								{
									$balance = 0;
								}
								$rrq = $rrq - $q;
								//update the incoming item status
								$tb = $tb - $q;					
								if($tb > 0)
								{
									$this->ImsCard->id = $in_item['ImsCard']['id'];
									$this->ImsCard->saveField('status', 'S');								
								}
								else if($tb <= 0)
								{						
									$this->ImsCard->id = $in_item['ImsCard']['id'];
									$this->ImsCard->saveField('status', 'D');
								}
								
							
								if (!empty($item) && isset($item['ImsItem']['tag_code'])) {
									$branch = $this->Branch->read(null, $branch_id);
									// Insert multiple tags if the issued quantity is more than one.
									for ($t = 0; $t < $q; $t++) {
										$tag = "AB/" . $branch['Branch']['tag_code'] . "-" . $item['ImsItem']['tag_code'] . "-";
										$conditions_tag = array('ImsTag.code LIKE' => $tag . "%");
										$tag_result = $this->ImsTag->find('first', array('conditions' => $conditions_tag, 'order' => array('ImsTag.code DESC')));
								
										if (!empty($tag_result)) {
											$tag_value = end(explode('-', $tag_result['ImsTag']['code']));
											$tag_value = preg_replace('/[\n\r]/', '', $tag_value);
											$tag_value = preg_replace('/\s+/', '', $tag_value);
											$tag_value = $tag_value + 1;
											$tag = $tag . sprintf("%03d", $tag_value);
										} else {
											$tag = $tag . "001";
										}
										$this->ImsTag->create();
										$this->data['ImsTag']['ims_sirv_item_id'] = $lastid_sirv;
										$this->data['ImsTag']['code'] = $tag;
										$this->ImsTag->save($this->data);
									}
								}
						                              
							}
						}else {			
							$q = $rrq;
							if($q > $tb){
								$q = $tb;
							}
							$balance = $tb - $q;
							if($balance < 0){
								$balance = 0;
							}
							$rrq = $rrq - $q;
							
												
						
							if($item['ImsItem']['tag_code'] != null)
							{
								$branch = $this->Branch->read(null,$branch_id);
								
								$tag = "AB/" . $branch['Branch']['tag_code'] . "-" . $item['ImsItem']['tag_code'] . "-";
								$conditions_tag = array('ImsTag.code LIKE' => $tag."%");
								$tag_result = $this->ImsTag->find('first', array('conditions' =>$conditions_tag, 'order'=>array('ImsTag.code DESC')));
								if(!empty($tag_result))
								{
									$tag_value = end(explode('-',$tag_result['ImsTag']['code']));
									$tag_value = preg_replace('/[\n\r]/','',$tag_value);
									$tag_value = preg_replace('/\s+/','',$tag_value);
									$tag_value = $tag_value + 1;
									$tag =  $tag . sprintf("%03d", $tag_value);
								}
								else $tag = $tag . "001";
								
								$this->ImsTag->create();
								$this->data['ImsTag']['ims_sirv_item_id'] = $lastid_sirv;
								$this->data['ImsTag']['code'] = $tag;
								
								$this->ImsTag->save($this->data);
							}
						}
					}
				}
			}
		}
	}




    
?>
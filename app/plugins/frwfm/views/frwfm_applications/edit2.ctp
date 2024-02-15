		<?php
			$this->ExtForm->create('FrwfmApplication');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FrwfmApplicationEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'edit2')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $frwfm_application['FrwfmApplication']['id'])); ?>,
				<?php if(array_key_exists('edited_by', $arr2)){ $this->ExtForm->input('edited_by', array('hidden' => $arr2['edited_by'])); echo ',';}?>
				<?php 
					$options = array();
					$options['items'] = $branches;
					$options['value'] = $frwfm_application['FrwfmApplication']['branch_id'];
					$options['fieldLabel']='Branch';
					$options['disabled']=$arr2['disable'];
					$this->ExtForm->input('branch_id', $options);
				?><?php	if(array_key_exists('branch_id', $arr2)){?>
				,{
					xtype: 'displayfield',
					name: 'displayfield1',
					fieldLabel: 'Modified To: ',
					value: '<span style="color:red;"><?php foreach($bra_name as $bra_names){
						if($arr2['branch_id'] == $bra_names['Branch']['id'])
						echo $bra_names['Branch']['name'];
						}?></span>'
				}<?php } ?>
				,<?php 
					$options = array();
					$options['value'] = $frwfm_application['FrwfmApplication']['date'];
					$options['fieldLabel']='Date of Application';
					$options['disabled']=$arr2['disable'];
					$this->ExtForm->input('date', $options);
				?><?php	if(array_key_exists('date', $arr2)){?>
				,{
					xtype: 'displayfield',
					name: 'displayfield1',
					fieldLabel: 'Modified To: ',
					value: '<span style="color:red;"><?php echo $arr2['date'];?></span>'
				}<?php } ?>,
				{   
					xtype:'fieldset',
					title: 'Customer Information',
					autoHeight: true,
					boxMinHeight: 300,
					items: [{
							layout:'column',
							items:[{
							layout: 'form',
							items:[
				<?php 
					$options = array();
					$options['fieldLabel']='Name';
					$options['value'] = $frwfm_application['FrwfmApplication']['name'];
					$options['disabled']=$arr2['disable'];
					$this->ExtForm->input('name', $options);
				?><?php	if(array_key_exists('name', $arr2)){?>
				,{
					xtype: 'displayfield',
					name: 'displayfield1',
					fieldLabel: 'Modified To: ',
					value: '<span style="color:red;"><?php echo $arr2['name'];?></span>'
				}<?php } ?>,
				<?php 
					$options = array();
					$options['fieldLabel']='Phone No';
					$options['value'] = $frwfm_application['FrwfmApplication']['mobile_phone'];
					$options['disabled']=$arr2['disable'];
					$this->ExtForm->input('mobile_phone', $options);
				?><?php	if(array_key_exists('mobile_phone', $arr2)){?>
				,{
					xtype: 'displayfield',
					name: 'displayfield1',
					fieldLabel: 'Modified To: ',
					value: '<span style="color:red;"><?php echo $arr2['mobile_phone'];?></span>'
				}<?php } ?>,
				<?php 
					$options = array();
					$options['fieldLabel']='TIN';
					$options['value'] = $frwfm_application['FrwfmApplication']['license'];
					$options['disabled']=$arr2['disable'];
					$this->ExtForm->input('license', $options);
				?><?php	if(array_key_exists('license', $arr2)){?>
				,{
					xtype: 'displayfield',
					name: 'displayfield1',
					fieldLabel: 'Modified To: ',
					value: '<span style="color:red;"><?php echo $arr2['license'];?></span>'
				}<?php } ?>
							]
							},
							{
						layout: 'form',
						items:[
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $locations;
						$options['value'] = $frwfm_application['FrwfmApplication']['location_id'];
						$options['disabled']=$arr2['disable'];
						$this->ExtForm->input('location_id', $options);
				?><?php	if(array_key_exists('location_id', $arr2)){?>
				,{
					xtype: 'displayfield',
					name: 'displayfield1',
					fieldLabel: 'Modified To: ',
					value: '<span style="color:red;"><?php foreach($loc_name as $loc_names){ 
					if($loc_names['Location']['id']== $arr2['location_id'])
					echo $loc_names['Location']['name'];}?></span>'
				}<?php } ?>,
				<?php 
					$options = array();
					$options = array('vtype' => 'email');
					$options['value'] = $frwfm_application['FrwfmApplication']['email'];
					$options['disabled']=$arr2['disable'];
					$this->ExtForm->input('email', $options);
				?><?php	if(array_key_exists('email', $arr2)){?>
				,{
					xtype: 'displayfield',
					name: 'displayfield1',
					fieldLabel: 'Modified To: ',
					value: '<span style="color:red;"><?php echo $arr2['email'];?></span>'
				}<?php } ?>,
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Relation With Bank', 'value' => 'Depositor');
                    $options['items'] = array('Depositor' => 'Depositor', 'Exporter' => 'Exporter','Borrower'=>'Borrower');
					$options['value'] = $frwfm_application['FrwfmApplication']['relation_with_bank'];
					$options['disabled']=$arr2['disable'];
					$this->ExtForm->input('relation_with_bank', $options);
				?><?php	if(array_key_exists('relation_with_bank', $arr2)){?>
				,{
					xtype: 'displayfield',
					name: 'displayfield1',
					fieldLabel: 'Modified To: ',
					value: '<span style="color:red;"><?php echo $arr2['relation_with_bank'];?></span>'
				}<?php } ?>
				]} ]}]
						
				},
				{   
					xtype:'fieldset',
					title: 'FC Request',
					autoHeight: true,
					boxMinHeight: 300,
					items: [{
							layout:'column',
							items:[{
							layout: 'form',
							items:[
				<?php 
					$options = array();
					$options['value'] = $frwfm_application['FrwfmApplication']['amount'];
					$options['disabled']=$arr2['disable'];
					$this->ExtForm->input('amount', $options);
					$options['disabled']=$arr2['disable'];
				?><?php	if(array_key_exists('amount', $arr2)){?>
				,{
					xtype: 'displayfield',
					name: 'displayfield1',
					fieldLabel: 'Modified To: ',
					value: '<span style="color:red;"><?php echo $arr2['amount'];?></span>'
				}<?php } ?>,
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Mode of Payment', 'value' => 'LC');
                    $options['items'] = array('LC' => 'LC', 'CAD' => 'CAD','TT'=>'TT');
					$options['value'] = $frwfm_application['FrwfmApplication']['mode_of_payment'];
					$options['disabled']=$arr2['disable'];
					$this->ExtForm->input('mode_of_payment', $options);
				?><?php	if(array_key_exists('mode_of_payment', $arr2)){?>
				,{
					xtype: 'displayfield',
					name: 'displayfield1',
					fieldLabel: 'Modified To: ',
					value: '<span style="color:red;"><?php echo $arr2['mode_of_payment'];?></span>'
				}<?php } ?>,<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Types of Goods', 'value' => 'Fuel');
                    $options['items'] = array('Fuel' => 'Fuel', 'Fertilizer' => 'Fertilizer','Other Agricultural Inputs'=>'Other Agricultural Inputs','Pharmaceutical Products'=>'Pharmaceutical Products','Factories Request for Machineries'=>'Factories Request for Machineries','Factories Request for Equipments'=>'Factories Request for Equipments','Factories Request for Spare Parts'=>'Factories Request for Spare Parts','Factories Request for Raw Material'=>'Factories Request for Raw Material','Factories Request for Accessories'=>'Factories Request for Accessories','Nutrition food for babies'=>'Nutrition food for babies','Salary Transfer for foreign employees'=>'Salary Transfer for foreign employees','Freight and Transit Service Payment'=>'Freight and Transit Service Payment','Invisible'=>'Invisible','Essential Goods ( Educational material )'=>'Essential Goods ( Educational material )','Other'=>'Other','Chemicals'=>'Chemicals');
					$options['value'] = $frwfm_application['FrwfmApplication']['types_of_goods'];
					$options['disabled']=$arr2['disable'];
					$this->ExtForm->input('types_of_goods', $options);
				?><?php	if(array_key_exists('types_of_goods', $arr2)){?>
				,{
					xtype: 'displayfield',
					name: 'displayfield1',
					fieldLabel: 'Modified To: ',
					value: '<span style="color:red;"><?php echo $arr2['types_of_goods'];?></span>'
				}<?php } ?>,<?php 
					$options = array();
					$options['fieldLabel']='NBE Account No';
					$options['value'] = $frwfm_application['FrwfmApplication']['nbe_account_no'];
					$options['allowBlank']='true';
					$options['disabled']=$arr2['disable'];
					$this->ExtForm->input('nbe_account_no', $options);
				?><?php	if(array_key_exists('nbe_account_no', $arr2)){?>
				,{
					xtype: 'displayfield',
					name: 'displayfield1',
					fieldLabel: 'Modified To: ',
					value: '<span style="color:red;"><?php echo $arr2['nbe_account_no'];?></span>'
				}<?php } ?>
							]},{
							layout: 'form',
							items:[
							<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Currency', 'value' => 'ETB');
                    $options['items'] = array('ETB' => 'ETB', 'USD' => 'USD','EUR'=>'EUR','GBP'=>'GBP','NOK'=>'NOK','DKK'=>'DKK','JPY'=>'JPY','CAD'=>'CAD','UAE'=>'UAE','CHF'=>'CHF','ZAR'=>'ZAR');
					$options['value'] = $frwfm_application['FrwfmApplication']['currency'];
					$options['disabled']=$arr2['disable'];
					$this->ExtForm->input('currency', $options);
				?><?php	if(array_key_exists('currency', $arr2)){?>
				,{
					xtype: 'displayfield',
					name: 'displayfield1',
					fieldLabel: 'Modified To: ',
					value: '<span style="color:red;"><?php echo $arr2['currency'];?></span>'
				}<?php } ?>,
				<?php 
					$options = array();
					$options['value'] = $frwfm_application['FrwfmApplication']['proforma_invoice_no'];
					$options['disabled']=$arr2['disable'];
					$this->ExtForm->input('proforma_invoice_no', $options);
				?><?php	if(array_key_exists('proforma_invoice_no', $arr2)){?>
				,{
					xtype: 'displayfield',
					name: 'displayfield1',
					fieldLabel: 'Modified To: ',
					value: '<span style="color:red;"><?php echo $arr2['proforma_invoice_no'];?></span>'
				}<?php } ?>,
				<?php 
					$options = array();
					$options['value'] = $frwfm_application['FrwfmApplication']['proforma_date'];
					$options['disabled']=$arr2['disable'];
					$this->ExtForm->input('proforma_date', $options);
				?><?php	if(array_key_exists('proforma_date', $arr2)){?>
				,{
					xtype: 'displayfield',
					name: 'displayfield1',
					fieldLabel: 'Modified To: ',
					value: '<span style="color:red;"><?php echo $arr2['proforma_date'];?></span>'
				}<?php } ?>,<?php 
					$options = array();
					$options['fieldLabel']='Description of Goods';
					$options['value'] = $frwfm_application['FrwfmApplication']['desc_of_goods'];
					$options['disabled']=$arr2['disable'];
					$this->ExtForm->input('desc_of_goods', $options);
				?><?php	if(array_key_exists('desc_of_goods', $arr2)){?>
				,{
					xtype: 'displayfield',
					name: 'displayfield1',
					fieldLabel: 'Modified To: ',
					value: '<span style="color:red;"><?php echo $arr2['desc_of_goods'];?></span>'
				}<?php } ?>,
				<?php 
					$options = array();
						$options = array(
						'xtype' => 'textarea',
						'grow' => false,
						'fieldLabel' => 'Remark',
						'anchor' => '100%'					
						);
						$options['value'] = $frwfm_application['FrwfmApplication']['remark'];
						$options['disabled']=$arr2['disable'];
						$this->ExtForm->input('remark', $options);
				?><?php	if(array_key_exists('remark', $arr2)){?>
				,{
					xtype: 'displayfield',
					name: 'displayfield1',
					fieldLabel: 'Modified To: ',
					value: '<span style="color:red;"><?php echo $arr2['remark'];?></span>'
				}<?php } ?>]
							}]
							}]
							}
								]
		});
		
		var FrwfmApplicationEditWindow = new Ext.Window({
			title: '<?php __('Edit Frwfm Application'); ?>',
			width: 700,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FrwfmApplicationEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FrwfmApplicationEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Frwfm Application.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FrwfmApplicationEditWindow.collapsed)
						FrwfmApplicationEditWindow.expand(true);
					else
						FrwfmApplicationEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php $user = $this->Session->read();
							if(!empty($arr2['edited_by']) && $arr2['edited_by'] != $user['Auth']['User']['id']){
								 __('Approve');
								}else
								__('Save');	?>',
				handler: function(btn){
					FrwfmApplicationEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FrwfmApplicationEditWindow.close();
						<?php if(isset($parent_id)){ ?>
							RefreshParentFrwfmApplicationData();
						<?php } else { ?>
							RefreshFrwfmApplicationData();
						<?php } ?>
						},
						failure: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Warning'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.errormsg,
                                icon: Ext.MessageBox.ERROR
							});
						}
					});
				}
			},{
				text: '<?php __('Reset'); ?>',
				handler: function(btn){
					Ext.Ajax.request({
						url: '<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'edit2')); ?>/<?php echo $frwfm_application['FrwfmApplication']['id'];?>/reset',
						success: function(response, opts) {
							//alert(response.responseText);
							var json = Ext.util.JSON.decode(response.responseText);
							Ext.Msg.show({
						
									title: '<?php __('Success'); ?>',
									buttons: Ext.MessageBox.OK,
									msg: json.msg,
									icon: Ext.MessageBox.INFO
								});
								RefreshFrwfmApplicationData();
								FrwfmApplicationEditWindow.close();
						},
						failure: function(response, opts){
							var json = Ext.util.JSON.decode(response.responseText);
								Ext.Msg.show({
									title: '<?php __('Warning'); ?>',
									buttons: Ext.MessageBox.OK,
									msg: json.errormsg,
									icon: Ext.MessageBox.ERROR
								});
								FrwfmApplicationEditWindow.close();
						}
						});
				}
			},{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					FrwfmApplicationEditWindow.close();
				}
			}]
		});

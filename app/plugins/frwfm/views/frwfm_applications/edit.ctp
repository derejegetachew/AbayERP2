		<?php
			$this->ExtForm->create('FrwfmApplication');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FrwfmApplicationEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $frwfm_application['FrwfmApplication']['id'])); ?>,
				<?php 
					$options = array();
					$options['items'] = $branches;
					$options['value'] = $frwfm_application['FrwfmApplication']['branch_id'];
					$options['fieldLabel']='Branch';
					$this->ExtForm->input('branch_id', $options);
				?>,<?php 
					$options = array();
					$options['value'] = $frwfm_application['FrwfmApplication']['date'];
					$options['fieldLabel']='Date of Application';
					$this->ExtForm->input('date', $options);
				?>,
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
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$options['fieldLabel']='Phone No';
					$options['value'] = $frwfm_application['FrwfmApplication']['mobile_phone'];
					$this->ExtForm->input('mobile_phone', $options);
				?>,
				<?php 
					$options = array();
					$options['fieldLabel']='TIN';
					$options['value'] = $frwfm_application['FrwfmApplication']['license'];
					$this->ExtForm->input('license', $options);
				?>
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
					$this->ExtForm->input('location_id', $options);
				?>,
				<?php 
					$options = array();
					$options = array('vtype' => 'email');
					$options['value'] = $frwfm_application['FrwfmApplication']['email'];
					$this->ExtForm->input('email', $options);
				?>,
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Relation With Bank', 'value' => 'Depositor');
                    $options['items'] = array('Depositor' => 'Depositor', 'Exporter' => 'Exporter','Borrower'=>'Borrower');
					$options['value'] = $frwfm_application['FrwfmApplication']['relation_with_bank'];
					$this->ExtForm->input('relation_with_bank', $options);
				?>
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
					$this->ExtForm->input('amount', $options);
				?>,
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Mode of Payment', 'value' => 'LC');
                    $options['items'] = array('LC' => 'LC', 'CAD' => 'CAD','TT'=>'TT');
					$options['value'] = $frwfm_application['FrwfmApplication']['mode_of_payment'];
					$this->ExtForm->input('mode_of_payment', $options);
				?>,<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Types of Goods', 'value' => 'Fuel');
                    $options['items'] = array('Printing Paper'=>'Printing Paper','Fuel' => 'Fuel', 'Fertilizer' => 'Fertilizer','Other Agricultural Inputs'=>'Other Agricultural Inputs','Pharmaceutical Products'=>'Pharmaceutical Products','Factories Request for Machineries'=>'Factories Request for Machineries','Factories Request for Equipments'=>'Factories Request for Equipments','Factories Request for Spare Parts'=>'Factories Request for Spare Parts','Factories Request for Raw Material'=>'Factories Request for Raw Material','Factories Request for Accessories'=>'Factories Request for Accessories','Nutrition food for babies'=>'Nutrition food for babies','Salary Transfer for foreign employees'=>'Salary Transfer for foreign employees','Freight and Transit Service Payment'=>'Freight and Transit Service Payment','Invisible'=>'Invisible','Essential Goods ( Educational material )'=>'Essential Goods ( Educational material )','Other'=>'Other','Chemicals'=>'Chemicals');
					$options['value'] = $frwfm_application['FrwfmApplication']['types_of_goods'];
					$this->ExtForm->input('types_of_goods', $options);
				?>,<?php 
					$options = array();
					$options['fieldLabel']='NBE Account No';
					$options['value'] = $frwfm_application['FrwfmApplication']['nbe_account_no'];
					$options['allowBlank']='true';
					$this->ExtForm->input('nbe_account_no', $options);
				?>
							]},{
							layout: 'form',
							items:[
							<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Currency', 'value' => 'ETB');
                    $options['items'] = array('ETB' => 'ETB', 'USD' => 'USD','EUR'=>'EUR','GBP'=>'GBP','NOK'=>'NOK','DKK'=>'DKK','JPY'=>'JPY','CAD'=>'CAD','UAE'=>'UAE','CHF'=>'CHF','ZAR'=>'ZAR');
					$options['value'] = $frwfm_application['FrwfmApplication']['currency'];
					$this->ExtForm->input('currency', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $frwfm_application['FrwfmApplication']['proforma_invoice_no'];
					$this->ExtForm->input('proforma_invoice_no', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $frwfm_application['FrwfmApplication']['proforma_date'];
					$this->ExtForm->input('proforma_date', $options);
				?>,<?php 
					$options = array();
					$options['fieldLabel']='Description of Goods';
					$options['value'] = $frwfm_application['FrwfmApplication']['desc_of_goods'];
					$this->ExtForm->input('desc_of_goods', $options);
				?>,
				<?php 
					$options = array();
						$options = array(
						'xtype' => 'textarea',
						'grow' => false,
						'fieldLabel' => 'Remark',
						'anchor' => '100%'					
						);
						$options['value'] = $frwfm_application['FrwfmApplication']['remark'];
					$this->ExtForm->input('remark', $options);
				?>]
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
				text: '<?php __('Save'); ?>',
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
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					FrwfmApplicationEditWindow.close();
				}
			}]
		});

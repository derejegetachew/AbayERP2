		<?php
			$this->ExtForm->create('IbdPurchaseOrder');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdPurchaseOrderAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 180,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdPurchaseOrders', 'action' => 'add')); ?>',
		

			items: [
				{
					layout:'column',
					items:[{
						columnWidth:.5,
						layout: 'form',
						items: [
							
					<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('NAME_OF_IMPORTER', $options);
					?>,
					<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('PURCHASE_ORDER_ISSUE_DATE', $options);
					?>,
					<?php 
					$options = array('readOnly'=>'true');
					$options['value']=$po;
					$this->ExtForm->input('PURCHASE_ORDER_NO', $options);
					?>,
					<?php 
					$options = array('allowBlank'=>false);
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $currencies;
					$this->ExtForm->input('currency_id', $options);
					?>,
						{
				    id:'FCY_AMOUNT',
					xtype:'textfield',
					fieldLabel:'FCY_AMOUNT',
					anchor:'100%',
					name :'data[IbdPurchaseOrder][FCY_AMOUNT]',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('RATE').getValue();
							  var p=Ext.getCmp('percent').getValue();
							// var sett_fcy_amount=Ext.getCmp('SETT_FCY_AMOUNT').getValue();
							// var other_birr=Ext.getCmp('SETT_CAD_PAYABLE').getValue();
							 var result=value*other;
							  result=(result*p)/100;
                             Ext.getCmp('CAD_PAYABLE_IN_BIRR').setValue(result);
							 Ext.getCmp('REM_FCY_AMOUNT').setValue(value);
							 Ext.getCmp('REM_CAD_PAYABLE_IN_BIRR').setValue(result);
						}
					}
			     },{
				    id:'RATE',
					xtype:'textfield',
					fieldLabel:'RATE',
					anchor:'100%',
					name : 'data[IbdPurchaseOrder][RATE]',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('FCY_AMOUNT').getValue();
							  var p=Ext.getCmp('percent').getValue();
							// var other_birr=Ext.getCmp('SETT_CAD_PAYABLE').getValue();
							 var result=value*other;
							 result=(result*p)/100;
                             Ext.getCmp('CAD_PAYABLE_IN_BIRR').setValue(result);
							 Ext.getCmp('REM_CAD_PAYABLE_IN_BIRR').setValue(result);
						}
					}
				}
					,
					{
				    id:'percent',
					xtype:'spinnerfield',
					fieldLabel:'Collected %',
					anchor:'100%',
					minValue:'0',
					maxValue:'100',
					name : 'data[IbdPurchaseOrder][percent]',
					enableKeyEvents:true,
					value:'100',
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var fcy=Ext.getCmp('FCY_AMOUNT').getValue();
							 var rate=Ext.getCmp('RATE').getValue();
							// var other_birr=Ext.getCmp('SETT_CAD_PAYABLE').getValue();
							 var total=(fcy*rate);
							 var collected=(total*value)/100;
                             Ext.getCmp('CAD_PAYABLE_IN_BIRR').setValue(collected);
							 Ext.getCmp('REM_CAD_PAYABLE_IN_BIRR').setValue(collected);
						}
					}
				}
					,
					<?php 
						$options = array('readOnly'=>'true');
						$options['id']="CAD_PAYABLE_IN_BIRR";
						$this->ExtForm->input('CAD_PAYABLE_IN_BIRR', $options);
					?>,
					<?php 
						$options = array('allowBlank'=>false);
						$this->ExtForm->input('ITEM_DESCRIPTION_OF_GOODS', $options);
					?>,
					<?php 
						$options = array('allowBlank'=>false);
						$this->ExtForm->input('DRAWER_NAME', $options);
					?>,
					<?php 
						$options = array('allowBlank'=>false);
						$this->ExtForm->input('MINUTE_NO', $options);
					?>
						]
						},{
						columnWidth:.5,
						layout: 'form',
						items: [
							<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('FCY_APPROVAL_DATE', $options);
					?>,
					<?php 
						$options = array('allowBlank'=>false);
						$this->ExtForm->input('FCY_APPROVAL_INTIAL_ORDER_NO', $options);
					?>,
					<?php 
						$options = array('id'=>'FROM_THEIR_FCY_ACCOUNT','xtype'=>'combo','allowBlank'=>false);
					    $list=array('RETENTION A'=>'RETENTION A','RETENTION B'=>'RETENTION B','DIASPORA'=>'DIASPORA','NRNT'=>'NRNT','NRFC'=>'NRFC','Suppliers_Credit'=>'Suppliers Credit');
						$options['items'] = $list;
						$this->ExtForm->input('FROM_THEIR_FCY_ACCOUNT', $options);
					?>,
					<?php 
					$options = array('allowBlank'=>false);
					$now=new DateTime('now');
					$now->modify('+90 day');
					$now = $now->format('Y-m-d');
					$options['value']=$now;
					$this->ExtForm->input('EXPIRE_DATE', $options);
					?>,
					<?php 
					$options = array('allowBlank'=>false);
					$options['id']="NBE_ACCOUNT";
					$this->ExtForm->input('NBE_ACCOUNT', $options);
					?>

					
					]
             	  }
				   ,{
						columnWidth:.5,
						layout: 'form',
						items: [
							<?php 
						$options = array('readOnly'=>'true');
						$options['id']="REM_FCY_AMOUNT";
						$this->ExtForm->input('REM_FCY_AMOUNT', $options);
					 ?>,
					<?php 
						$options = array('readOnly'=>'true');
						$options['id']="REM_CAD_PAYABLE_IN_BIRR";
						$this->ExtForm->input('REM_CAD_PAYABLE_IN_BIRR', $options);
					?>		,
						<?php 
						$options = array();
						$options['id']="REMARK";
						$this->ExtForm->input('REMARK', $options);
					?>
							]
             	      }

				   
				   
				   ]
				}

			]
		});
		
		var IbdPurchaseOrderAddWindow = new Ext.Window({
			title: '<?php __('Add Purchase Order'); ?>',
			width: 1000,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdPurchaseOrderAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdPurchaseOrderAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ibd Purchase Order.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdPurchaseOrderAddWindow.collapsed)
						IbdPurchaseOrderAddWindow.expand(true);
					else
						IbdPurchaseOrderAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdPurchaseOrderAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdPurchaseOrderAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdPurchaseOrderData();
<?php } else { ?>
							RefreshIbdPurchaseOrderData();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					IbdPurchaseOrderAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdPurchaseOrderAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdPurchaseOrderData();
<?php } else { ?>
							RefreshIbdPurchaseOrderData();
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
					IbdPurchaseOrderAddWindow.close();
				}
			}]
		});

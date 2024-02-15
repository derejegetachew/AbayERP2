		<?php
			$this->ExtForm->create('IbdPurchaseOrder');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdPurchaseOrderEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 180,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdPurchaseOrders', 'action' => 'edit')); ?>',
			

			items: [
				{
					layout:'column',
					items:[{
						columnWidth:.5,
						layout: 'form',
						items: [
							
				<?php $this->ExtForm->input('id', array('hidden' => $ibd_purchase_order['IbdPurchaseOrder']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_purchase_order['IbdPurchaseOrder']['PURCHASE_ORDER_ISSUE_DATE'];
					$this->ExtForm->input('PURCHASE_ORDER_ISSUE_DATE', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_purchase_order['IbdPurchaseOrder']['NAME_OF_IMPORTER'];
					$this->ExtForm->input('NAME_OF_IMPORTER', $options);
				?>,
				<?php 
					$options = array('readOnly'=>'true');
					$options['value'] = $ibd_purchase_order['IbdPurchaseOrder']['PURCHASE_ORDER_NO'];
					$this->ExtForm->input('PURCHASE_ORDER_NO', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $currencies;
					$options['value'] = $ibd_purchase_order['IbdPurchaseOrder']['currency_id'];
					$this->ExtForm->input('currency_id', $options);
				?>,
				{
				    id:'FCY_AMOUNT',
					xtype:'textfield',
					fieldLabel:'FCY_AMOUNT',
					anchor:'100%',
					value:'<?php echo  $ibd_purchase_order['IbdPurchaseOrder']['FCY_AMOUNT'];?>',
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
					value:'<?php echo   $ibd_purchase_order['IbdPurchaseOrder']['RATE']; ?>',
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
				},
				{
				    id:'percent',
					xtype:'spinnerfield',
					fieldLabel:'Collected %',
					anchor:'100%',
					minValue:'0',
					maxValue:'100',
					value:'<?php echo   $ibd_purchase_order['IbdPurchaseOrder']['percent']; ?>',
					name : 'data[IbdPurchaseOrder][percent]',
					enableKeyEvents:true,
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
					$options = array('id'=>'CAD_PAYABLE_IN_BIRR','readOnly'=>'true');
					$options['value'] = $ibd_purchase_order['IbdPurchaseOrder']['CAD_PAYABLE_IN_BIRR'];
					$this->ExtForm->input('CAD_PAYABLE_IN_BIRR', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_purchase_order['IbdPurchaseOrder']['ITEM_DESCRIPTION_OF_GOODS'];
					$this->ExtForm->input('ITEM_DESCRIPTION_OF_GOODS', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_purchase_order['IbdPurchaseOrder']['DRAWER_NAME'];
					$this->ExtForm->input('DRAWER_NAME', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_purchase_order['IbdPurchaseOrder']['MINUTE_NO'];
					$this->ExtForm->input('MINUTE_NO', $options);
				?>
				]
						},{
						columnWidth:.5,
						layout: 'form',
						items: [
				<?php 
					$options = array();
					if($ibd_purchase_order['IbdPurchaseOrder']['FCY_APPROVAL_DATE']=='0000-00-00'){
                      $options['value']=null;
					}else{
					$options['value'] = $ibd_purchase_order['IbdPurchaseOrder']['FCY_APPROVAL_DATE'];
				    }
					
					$this->ExtForm->input('FCY_APPROVAL_DATE', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_purchase_order['IbdPurchaseOrder']['FCY_APPROVAL_INTIAL_ORDER_NO'];
					$this->ExtForm->input('FCY_APPROVAL_INTIAL_ORDER_NO', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_purchase_order['IbdPurchaseOrder']['FROM_THEIR_FCY_ACCOUNT'];
					$this->ExtForm->input('FROM_THEIR_FCY_ACCOUNT', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_purchase_order['IbdPurchaseOrder']['EXPIRE_DATE'];
					$this->ExtForm->input('EXPIRE_DATE', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_purchase_order['IbdPurchaseOrder']['NBE_ACCOUNT'];
					$this->ExtForm->input('NBE_ACCOUNT', $options);
				?>

				]
             	  },{
						columnWidth:.5,
						layout: 'form',
						items: [
				<?php 
					$options = array('id'=>'REM_FCY_AMOUNT','readOnly'=>'true');
					$options['value'] = $ibd_purchase_order['IbdPurchaseOrder']['REM_FCY_AMOUNT'];
					$this->ExtForm->input('REM_FCY_AMOUNT', $options);
				?>,
				<?php 
					$options = array('id'=>'REM_CAD_PAYABLE_IN_BIRR','readOnly'=>'true');
					$options['value'] = $ibd_purchase_order['IbdPurchaseOrder']['REM_CAD_PAYABLE_IN_BIRR'];
					$this->ExtForm->input('REM_CAD_PAYABLE_IN_BIRR', $options);
				?>					,
				<?php 
					$options = array('id'=>'REMARK');
					$options['value'] = $ibd_purchase_order['IbdPurchaseOrder']['REMARK'];
					$this->ExtForm->input('REMARK', $options);
				?>		]
			}

		
		
		]
	    }  ]
		});
		
		var IbdPurchaseOrderEditWindow = new Ext.Window({
			title: '<?php __('Edit Purchase Order'); ?>',
			width: 1000,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdPurchaseOrderEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdPurchaseOrderEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ibd Purchase Order.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdPurchaseOrderEditWindow.collapsed)
						IbdPurchaseOrderEditWindow.expand(true);
					else
						IbdPurchaseOrderEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdPurchaseOrderEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdPurchaseOrderEditWindow.close();
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
					IbdPurchaseOrderEditWindow.close();
				}
			}]
		});

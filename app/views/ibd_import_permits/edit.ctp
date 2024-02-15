		<?php
			$this->ExtForm->create('IbdImportPermit');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdImportPermitEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 190,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdImportPermits', 'action' => 'edit')); ?>',
			

			items: [
				{
			layout:'column',
            items:[{
						columnWidth:.5,
						layout: 'form',
						items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ibd_import_permit['IbdImportPermit']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_import_permit['IbdImportPermit']['PERMIT_ISSUE_DATE'];
					$this->ExtForm->input('PERMIT_ISSUE_DATE', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_import_permit['IbdImportPermit']['NAME_OF_IMPORTER'];
					$this->ExtForm->input('NAME_OF_IMPORTER', $options);
				?>,
				<?php 
					$options = array('readOnly'=>'true');
					$options['value'] = $ibd_import_permit['IbdImportPermit']['IMPORT_PERMIT_NO'];
					$this->ExtForm->input('IMPORT_PERMIT_NO', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $currencies;
					$options['value'] = $ibd_import_permit['IbdImportPermit']['currency_id'];
					$this->ExtForm->input('currency_id', $options);
				?>,
				{
				    id:'FCY_AMOUNT',
					xtype:'textfield',
					fieldLabel:'FCY_AMOUNT',
					anchor:'100%',
					value: '<?php echo $ibd_import_permit['IbdImportPermit']['FCY_AMOUNT'];?>',
					name :'data[IbdImportPermit][FCY_AMOUNT]',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('PREVAILING_RATE').getValue();
							 var result=value*other;
                             Ext.getCmp('LCY_AMOUNT').setValue(result);

						}
					}
			    }
				,
				{
				    id:'PREVAILING_RATE',
					xtype:'textfield',
					fieldLabel:'PREVAILING_RATE',
					anchor:'100%',
					value: '<?php echo $ibd_import_permit['IbdImportPermit']['PREVAILING_RATE']; ?>',
					name : 'data[IbdImportPermit][PREVAILING_RATE]',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('FCY_AMOUNT').getValue();
							 var result=value*other;
                             Ext.getCmp('LCY_AMOUNT').setValue(result);
						}
					}
			}
				,
				<?php 
					$options = array('id'=>'LCY_AMOUNT','readOnly'=>'true');
					$options['value'] = $ibd_import_permit['IbdImportPermit']['LCY_AMOUNT'];
					$this->ExtForm->input('LCY_AMOUNT', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $payment_terms;
					$options['value'] = $ibd_import_permit['IbdImportPermit']['payment_term_id'];
					$this->ExtForm->input('payment_term_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_import_permit['IbdImportPermit']['REF_NO'];
					$this->ExtForm->input('REF_NO', $options);
				?>
				,
				<?php 
					$options = array();
					$options['value'] = $ibd_import_permit['IbdImportPermit']['ITEM_DESCRIPTION_OF_GOODS'];
					$this->ExtForm->input('ITEM_DESCRIPTION_OF_GOODS', $options);
				?>
					]
						},{
						columnWidth:.5,
						layout: 'form',
						items: [
				<?php 
					$options = array();
					$options['value'] = $ibd_import_permit['IbdImportPermit']['SUPPLIERS_NAME'];
					$this->ExtForm->input('SUPPLIERS_NAME', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_import_permit['IbdImportPermit']['MINUTE_NO'];
					$this->ExtForm->input('MINUTE_NO', $options);
				?>,
				<?php 
					$options = array('allowBlank' => true);
					if($ibd_import_permit['IbdImportPermit']['FCY_APPROVAL_DATE']=='0000-00-00'){
                      $options['value']=null;
					}else{
					$options['value'] = $ibd_import_permit['IbdImportPermit']['FCY_APPROVAL_DATE'];
				    }
					$this->ExtForm->input('FCY_APPROVAL_DATE', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_import_permit['IbdImportPermit']['EXPIRE_DTAE'];
					$this->ExtForm->input('EXPIRE_DTAE', $options);
				?>
				,
				<?php 
					$options = array();
					$options['value'] = $ibd_import_permit['IbdImportPermit']['FCY_APPROVAL_INTIAL_ORDER_NO'];
					$this->ExtForm->input('FCY_APPROVAL_INTIAL_ORDER_NO', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_import_permit['IbdImportPermit']['FROM_THEIR_FCY_ACCOUNT'];
					$this->ExtForm->input('FROM_THEIR_FCY_ACCOUNT', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_import_permit['IbdImportPermit']['THE_PRICE_AS_PER_NBE_SELLECTED'];
					$this->ExtForm->input('THE_PRICE_AS_PER_NBE_SELLECTED', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_import_permit['IbdImportPermit']['NBE_UNDERTAKING'];
					$this->ExtForm->input('NBE_UNDERTAKING', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_import_permit['IbdImportPermit']['NBE_ACCOUNT'];
					$this->ExtForm->input('NBE_ACCOUNT', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_import_permit['IbdImportPermit']['SUPPLIERS_CREDIT'];
					$this->ExtForm->input('SUPPLIERS_CREDIT', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_import_permit['IbdImportPermit']['REMARK'];
					$this->ExtForm->input('REMARK', $options);
				?>	
						]
					}]
				}		
		 
		 ]
		});
		
		var IbdImportPermitEditWindow = new Ext.Window({
			title: '<?php __('Edit Ibd Import Permit'); ?>',
			width: 1000,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdImportPermitEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdImportPermitEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ibd Import Permit.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdImportPermitEditWindow.collapsed)
						IbdImportPermitEditWindow.expand(true);
					else
						IbdImportPermitEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdImportPermitEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdImportPermitEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdImportPermitData();
<?php } else { ?>
							RefreshIbdImportPermitData();
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
					IbdImportPermitEditWindow.close();
				}
			}]
		});

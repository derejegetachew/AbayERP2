		<?php
			$this->ExtForm->create('IbdInvisiblePermit');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdInvisiblePermitEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 160,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdInvisiblePermits', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ibd_invisible_permit['IbdInvisiblePermit']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_invisible_permit['IbdInvisiblePermit']['DATE_OF_ISSUE'];
					$this->ExtForm->input('DATE_OF_ISSUE', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_invisible_permit['IbdInvisiblePermit']['NAME_OF_APPLICANT'];
					$this->ExtForm->input('NAME_OF_APPLICANT', $options);
				?>,
				<?php 
					$options = array('readOnly'=>'true');
					$options['value'] = $ibd_invisible_permit['IbdInvisiblePermit']['PERMIT_NO'];
					$this->ExtForm->input('PERMIT_NO', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_invisible_permit['IbdInvisiblePermit']['PURPOSE_OF_PAYMENT'];
					$this->ExtForm->input('PURPOSE_OF_PAYMENT', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $currencies;
					$options['value'] = $ibd_invisible_permit['IbdInvisiblePermit']['currency_id'];
					$this->ExtForm->input('currency_id', $options);
				?>,
				{
				    id:'FCY_AMOUNT',
					xtype:'textfield',
					fieldLabel:'FCY_AMOUNT',
					anchor:'100%',
					value:'<?php echo  $ibd_invisible_permit['IbdInvisiblePermit']['FCY_AMOUNT'];?>',
					name :'data[IbdPurchaseOrder][FCY_AMOUNT]',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('rate').getValue();
							 
							 var result=value*other;
							  
                             Ext.getCmp('LCY_AMOUNT').setValue(result);
						}
					}
			     }
				,
				{
				    id:'rate',
					xtype:'textfield',
					fieldLabel:'Rate',
					anchor:'100%',
					value:'<?php echo  $ibd_invisible_permit['IbdInvisiblePermit']['rate'];?>',
					name :'data[IbdInvisiblePermit][rate]',
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
					$options = array('id'=>'LCY_AMOUNT');
					$options['value'] = $ibd_invisible_permit['IbdInvisiblePermit']['LCY_AMOUNT'];
					$this->ExtForm->input('LCY_AMOUNT', $options);
				?>
				,
				<?php 
					$options = array();
					$options['value'] = $ibd_invisible_permit['IbdInvisiblePermit']['TT_REFERENCE'];
					$this->ExtForm->input('TT_REFERENCE', $options);
				?>,
				<?php 
					$options = array('xtype'=>'combo','allowBlank'=>true,'fieldLabel'=>'FCY USED FROM');
					$list=array('RETENTION A'=>'RETENTION A','RETENTION B'=>'RETENTION B','DIASPORA'=>'DIASPORA','NRNT'=>'NRNT','SUPPLIERS_CREDIT'=>'SUPPLIERS CREDIT','BIRR_ACCOUNT'=>'BIRR ACCOUNT');
					$options['items'] = $list;
					$options['value'] = $ibd_invisible_permit['IbdInvisiblePermit']['FROM_THEIR_LCY_ACCOUNT'];
					$this->ExtForm->input('FROM_THEIR_LCY_ACCOUNT', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_invisible_permit['IbdInvisiblePermit']['REMARK'];
					$this->ExtForm->input('REMARK', $options);
				?>			]
		});
		
		var IbdInvisiblePermitEditWindow = new Ext.Window({
			title: '<?php __('Edit Ibd Invisible Permit'); ?>',
			width: 500,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdInvisiblePermitEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdInvisiblePermitEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ibd Invisible Permit.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdInvisiblePermitEditWindow.collapsed)
						IbdInvisiblePermitEditWindow.expand(true);
					else
						IbdInvisiblePermitEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdInvisiblePermitEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdInvisiblePermitEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdInvisiblePermitData();
<?php } else { ?>
							RefreshIbdInvisiblePermitData();
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
					IbdInvisiblePermitEditWindow.close();
				}
			}]
		});

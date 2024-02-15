		<?php
			$this->ExtForm->create('IbdInvisiblePermit');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdInvisiblePermitAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 170,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdInvisiblePermits', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
			
				<?php 
					$options = array();
					$this->ExtForm->input('NAME_OF_APPLICANT', $options);
				?>,	
				<?php 
				$options = array();
				$this->ExtForm->input('DATE_OF_ISSUE', $options);
			?>,
				<?php 
					$options = array('value'=>$ref_no,'readOnly'=>'true');
					$this->ExtForm->input('PERMIT_NO', $options);
				?>,
				<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('PURPOSE_OF_PAYMENT', $options);
				?>,
				<?php 
					$options = array();
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
					name :'data[IbdInvisiblePermit][FCY_AMOUNT]',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('rate').getValue();
							 var result=value*other;
                             Ext.getCmp('LCY_AMOUNT').setValue(result);

						}
					}
			},
			{
				    id:'rate',
					xtype:'textfield',
					fieldLabel:'Rate',
					anchor:'100%',
					name : 'data[IbdInvisiblePermit][rate]',
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
					$this->ExtForm->input('LCY_AMOUNT', $options);
				?>,
				<?php 
					$options = array('allowBlank'=>true);
					$this->ExtForm->input('TT_REFERENCE', $options);
				?>,
			
				<?php 
					$options = array('xtype'=>'combo','allowBlank'=>true,'fieldLabel'=>'FCY USED FROM');
					$list=array('RETENTION A'=>'RETENTION A','RETENTION B'=>'RETENTION B','DIASPORA'=>'DIASPORA','NRNT'=>'NRNT','NRFC'=>'NRFC','SUPPLIERS_CREDIT'=>'SUPPLIERS CREDIT','BIRR_ACCOUNT'=>'BIRR ACCOUNT');
					$options['items'] = $list;
					$this->ExtForm->input('FROM_THEIR_LCY_ACCOUNT', $options);
				?>,
				<?php 
					$options = array('allowBlank'=>true);
					$this->ExtForm->input('REMARK', $options);
				?>			]
		});
		
		var IbdInvisiblePermitAddWindow = new Ext.Window({
			title: '<?php __('Add Ibd Invisible Permit'); ?>',
			width: 500,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdInvisiblePermitAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdInvisiblePermitAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ibd Invisible Permit.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdInvisiblePermitAddWindow.collapsed)
						IbdInvisiblePermitAddWindow.expand(true);
					else
						IbdInvisiblePermitAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdInvisiblePermitAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdInvisiblePermitAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					IbdInvisiblePermitAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdInvisiblePermitAddWindow.close();
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
					IbdInvisiblePermitAddWindow.close();
				}
			}]
		});

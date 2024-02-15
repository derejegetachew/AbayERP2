		<?php
			$this->ExtForm->create('IbdSettelment');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdSettelmentAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdSettelments', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array('value'=>str_replace("<","/", $parent_id),'readOnly'=>true);
					$this->ExtForm->input('reference', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('date', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('opening_date', $options);
				?>,
					{
				    id:'fcy_amount',
					xtype:'textfield',
					fieldLabel:'fcy_amount',
					anchor:'100%',
					name :'data[IbdSettelment][fcy_amount]',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('rate').getValue();
							 var result=value*other;
                             Ext.getCmp('lcy_amount').setValue(result);
						}
					}
			     }
				, 
				{
				    id:'rate',
					xtype:'textfield',
					fieldLabel:'rate',
					anchor:'100%',
					value:'<?php echo $rate; ?>',
					name : 'data[IbdSettelment][rate]',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('fcy_amount').getValue();
							 var result=value*other;
                             Ext.getCmp('lcy_amount').setValue(result);
							
						}
					}
				}
				,
				<?php 
					$options = array('id'=>'lcy_amount','readOnly'=>'true');
					$this->ExtForm->input('lcy_amount', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('margin_amount', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('ibc_no', $options);
				?>			]
		});
		
		var IbdSettelmentAddWindow = new Ext.Window({
			title: '<?php __('Add Ibd Settelment'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdSettelmentAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdSettelmentAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ibd Settelment.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdSettelmentAddWindow.collapsed)
						IbdSettelmentAddWindow.expand(true);
					else
						IbdSettelmentAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdSettelmentAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdSettelmentAddForm.getForm().reset();
							RefreshIbdPurchaseOrderData();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdSettelmentData();
							
<?php } else { ?>
							RefreshIbdSettelmentData();
							
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
					IbdSettelmentAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							RefreshIbdPurchaseOrderData();
							IbdSettelmentAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdSettelmentData();
							
<?php } else { ?>
							RefreshIbdSettelmentData();
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
					IbdSettelmentAddWindow.close();
				}
			}]
		});

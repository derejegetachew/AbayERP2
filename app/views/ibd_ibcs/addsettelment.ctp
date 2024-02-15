<?php
			$this->ExtForm->create('IbdPurchaseOrder');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdPurchaseOrderAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 180,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdPurchaseOrders', 'action' => 'addsettelment')); ?>',
			items: [
				
							
					<?php 
					$options = array();
					$this->ExtForm->input('date', $options);
					?>,                               
					<?php 
					$options = array();
					$this->ExtForm->input('opening_date', $options);
					?>,
					<?php 
					$options = array();
					$this->ExtForm->input('fcy_amount', $options);
					?>,
					<?php 
						$options = array();
						$this->ExtForm->input('rate', $options);
					?>,
					<?php 
						$options = array();
						$this->ExtForm->input('lcy_amount', $options);
					?>
				   
				 
			]
		});
		
		var settelemtwindow = new Ext.Window({
			title: '<?php __('Add Purchase Order'); ?>',
			width: 400,
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

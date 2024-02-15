		<?php
			$this->ExtForm->create('Lease');
			$this->ExtForm->defineFieldFunctions();
		?>
		var LeaseAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'leases', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('branch_code', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('contract_years', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('start_date', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('end_date', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('total_amount', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('paid_years', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('paid_amount', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('rent_amount', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('expensed', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('is_lease', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('discount', $options);
				?>			]
		});
		
		var LeaseAddWindow = new Ext.Window({
			title: '<?php __('Add Lease'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: LeaseAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					LeaseAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Lease.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(LeaseAddWindow.collapsed)
						LeaseAddWindow.expand(true);
					else
						LeaseAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					LeaseAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							LeaseAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentLeaseData();
<?php } else { ?>
							RefreshLeaseData();
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
					LeaseAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							LeaseAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentLeaseData();
<?php } else { ?>
							RefreshLeaseData();
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
					LeaseAddWindow.close();
				}
			}]
		});

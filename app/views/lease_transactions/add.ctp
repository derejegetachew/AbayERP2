		<?php
			$this->ExtForm->create('LeaseTransaction');
			$this->ExtForm->defineFieldFunctions();
		?>
		var LeaseTransactionAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'leaseTransactions', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $leases;
					$this->ExtForm->input('lease_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('month', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('payment', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('disount_factor', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('npv', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('lease_liability', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('interest_charge', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('asset_nbv_bfwd', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('amortization', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('asset_nbv_cfwd', $options);
				?>			]
		});
		
		var LeaseTransactionAddWindow = new Ext.Window({
			title: '<?php __('Add Lease Transaction'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: LeaseTransactionAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					LeaseTransactionAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Lease Transaction.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(LeaseTransactionAddWindow.collapsed)
						LeaseTransactionAddWindow.expand(true);
					else
						LeaseTransactionAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					LeaseTransactionAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							LeaseTransactionAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentLeaseTransactionData();
<?php } else { ?>
							RefreshLeaseTransactionData();
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
					LeaseTransactionAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							LeaseTransactionAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentLeaseTransactionData();
<?php } else { ?>
							RefreshLeaseTransactionData();
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
					LeaseTransactionAddWindow.close();
				}
			}]
		});

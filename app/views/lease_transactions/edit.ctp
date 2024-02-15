		<?php
			$this->ExtForm->create('LeaseTransaction');
			$this->ExtForm->defineFieldFunctions();
		?>
		var LeaseTransactionEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'leaseTransactions', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $lease_transaction['LeaseTransaction']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $leases;
					$options['value'] = $lease_transaction['LeaseTransaction']['lease_id'];
					$this->ExtForm->input('lease_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $lease_transaction['LeaseTransaction']['month'];
					$this->ExtForm->input('month', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $lease_transaction['LeaseTransaction']['payment'];
					$this->ExtForm->input('payment', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $lease_transaction['LeaseTransaction']['disount_factor'];
					$this->ExtForm->input('disount_factor', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $lease_transaction['LeaseTransaction']['npv'];
					$this->ExtForm->input('npv', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $lease_transaction['LeaseTransaction']['lease_liability'];
					$this->ExtForm->input('lease_liability', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $lease_transaction['LeaseTransaction']['interest_charge'];
					$this->ExtForm->input('interest_charge', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $lease_transaction['LeaseTransaction']['asset_nbv_bfwd'];
					$this->ExtForm->input('asset_nbv_bfwd', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $lease_transaction['LeaseTransaction']['amortization'];
					$this->ExtForm->input('amortization', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $lease_transaction['LeaseTransaction']['asset_nbv_cfwd'];
					$this->ExtForm->input('asset_nbv_cfwd', $options);
				?>			]
		});
		
		var LeaseTransactionEditWindow = new Ext.Window({
			title: '<?php __('Edit Lease Transaction'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: LeaseTransactionEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					LeaseTransactionEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Lease Transaction.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(LeaseTransactionEditWindow.collapsed)
						LeaseTransactionEditWindow.expand(true);
					else
						LeaseTransactionEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					LeaseTransactionEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							LeaseTransactionEditWindow.close();
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
					LeaseTransactionEditWindow.close();
				}
			}]
		});

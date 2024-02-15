		<?php
			$this->ExtForm->create('ImsTransferItemBefore');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsTransferItemBeforeAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsTransferItemBefores', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_transfer_befores;
					$this->ExtForm->input('ims_transfer_before_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_sirv_item_befores;
					$this->ExtForm->input('ims_sirv_item_before_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_items;
					$this->ExtForm->input('ims_item_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('measurement', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('quantity', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('unit_price', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('tag', $options);
				?>			]
		});
		
		var ImsTransferItemBeforeAddWindow = new Ext.Window({
			title: '<?php __('Add Ims Transfer Item Before'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsTransferItemBeforeAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsTransferItemBeforeAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ims Transfer Item Before.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsTransferItemBeforeAddWindow.collapsed)
						ImsTransferItemBeforeAddWindow.expand(true);
					else
						ImsTransferItemBeforeAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsTransferItemBeforeAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsTransferItemBeforeAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsTransferItemBeforeData();
<?php } else { ?>
							RefreshImsTransferItemBeforeData();
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
					ImsTransferItemBeforeAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsTransferItemBeforeAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsTransferItemBeforeData();
<?php } else { ?>
							RefreshImsTransferItemBeforeData();
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
					ImsTransferItemBeforeAddWindow.close();
				}
			}]
		});

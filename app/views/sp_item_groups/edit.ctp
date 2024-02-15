		<?php
			$this->ExtForm->create('SpItemGroup');
			$this->ExtForm->defineFieldFunctions();
		?>
		var SpItemGroupEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'spItemGroups', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $sp_item_group['SpItemGroup']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $sp_item_group['SpItemGroup']['name'];
					$this->ExtForm->input('name', $options);
				?>			]
		});
		
		var SpItemGroupEditWindow = new Ext.Window({
			title: '<?php __('Edit Sp Item Group'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: SpItemGroupEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					SpItemGroupEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Sp Item Group.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(SpItemGroupEditWindow.collapsed)
						SpItemGroupEditWindow.expand(true);
					else
						SpItemGroupEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					SpItemGroupEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							SpItemGroupEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentSpItemGroupData();
<?php } else { ?>
							RefreshSpItemGroupData();
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
					SpItemGroupEditWindow.close();
				}
			}]
		});

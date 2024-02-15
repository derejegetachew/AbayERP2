		<?php
			$this->ExtForm->create('DmsGroup');
			$this->ExtForm->defineFieldFunctions();
		?>
		var DmsGroupEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'dmsGroups', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $dms_group['DmsGroup']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $dms_group['DmsGroup']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $users;
					$options['value'] = $dms_group['DmsGroup']['user_id'];
					$this->ExtForm->input('user_id', $options);
				?>,
				{
					xtype:'checkbox',
					fieldLabel:'Public',
					name:'data[DmsGroup][public]',
					anchor: '100%',
					value: '<?php echo $dms_group['DmsGroup']['public']; ?>',
					<?php if($dms_group['DmsGroup']['public']==1): ?> checked: 'checked',<?php endif; ?>
					handler: function(chk,checked) {
					if(checked==true){
alert('Dear Staff,\n\nDue to many misleading, outdated, duplicate and bulk group lists, it is decided that only HR employees should be able to create public groups.\n\nNote: You can recommend a specific group list to be available for all by contacting HR department.\n\nRegards,');
						}			
					}
				}]
				});
		
		var DmsGroupEditWindow = new Ext.Window({
			title: '<?php __('Edit Dms Group'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: DmsGroupEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					DmsGroupEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Dms Group.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(DmsGroupEditWindow.collapsed)
						DmsGroupEditWindow.expand(true);
					else
						DmsGroupEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					DmsGroupEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DmsGroupEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentDmsGroupData();
<?php } else { ?>
							RefreshDmsGroupData();
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
					DmsGroupEditWindow.close();
				}
			}]
		});

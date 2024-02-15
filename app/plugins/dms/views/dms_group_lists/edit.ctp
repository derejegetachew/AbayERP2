		<?php
			$this->ExtForm->create('DmsGroupList');
			$this->ExtForm->defineFieldFunctions();
		?>
		var DmsGroupListEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'dmsGroupLists', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $dms_group_list['DmsGroupList']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $users;
					$options['value'] = $dms_group_list['DmsGroupList']['user_id'];
					$this->ExtForm->input('user_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $dms_groups;
					$options['value'] = $dms_group_list['DmsGroupList']['dms_group_id'];
					$this->ExtForm->input('dms_group_id', $options);
				?>			]
		});
		
		var DmsGroupListEditWindow = new Ext.Window({
			title: '<?php __('Edit Dms Group List'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: DmsGroupListEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					DmsGroupListEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Dms Group List.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(DmsGroupListEditWindow.collapsed)
						DmsGroupListEditWindow.expand(true);
					else
						DmsGroupListEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					DmsGroupListEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DmsGroupListEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentDmsGroupListData();
<?php } else { ?>
							RefreshDmsGroupListData();
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
					DmsGroupListEditWindow.close();
				}
			}]
		});

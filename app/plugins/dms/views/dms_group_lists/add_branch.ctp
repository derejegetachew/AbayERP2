		<?php
			$this->ExtForm->create('DmsGroupList');
			$this->ExtForm->defineFieldFunctions();
		?>

		var DmsGroupListAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'dmsGroupLists', 'action' => 'add_branch')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$options['items'] = $branches;
					$this->ExtForm->input('branch_id', $options);
				?>	,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $dms_groups;
					$this->ExtForm->input('dms_group_id', $options);
				?>			]
		});
		
		var DmsGroupListAddWindow = new Ext.Window({
			title: '<?php __('Add Group List'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: DmsGroupListAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					DmsGroupListAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Dms Group List.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(DmsGroupListAddWindow.collapsed)
						DmsGroupListAddWindow.expand(true);
					else
						DmsGroupListAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					DmsGroupListAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DmsGroupListAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					DmsGroupListAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DmsGroupListAddWindow.close();
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
					DmsGroupListAddWindow.close();
				}
			}]
		});

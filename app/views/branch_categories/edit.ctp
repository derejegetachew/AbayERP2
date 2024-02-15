		<?php
			$this->ExtForm->create('BranchCategory');
			$this->ExtForm->defineFieldFunctions();
		?>
		var BranchCategoryEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'branchCategories', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $branch_category['BranchCategory']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $branch_category['BranchCategory']['name'];
					$this->ExtForm->input('name', $options);
				?>			]
		});
		
		var BranchCategoryEditWindow = new Ext.Window({
			title: '<?php __('Edit Branch Category'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BranchCategoryEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BranchCategoryEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Branch Category.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BranchCategoryEditWindow.collapsed)
						BranchCategoryEditWindow.expand(true);
					else
						BranchCategoryEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					BranchCategoryEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BranchCategoryEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentBranchCategoryData();
<?php } else { ?>
							RefreshBranchCategoryData();
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
					BranchCategoryEditWindow.close();
				}
			}]
		});

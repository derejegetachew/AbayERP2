		<?php
			$this->ExtForm->create('CmsAssignment');
			$this->ExtForm->defineFieldFunctions();
		?>
		var CmsAssignmentEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'cmsAssignments', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $cms_assignment['CmsAssignment']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $cms_cases;
					$options['value'] = $cms_assignment['CmsAssignment']['cms_case_id'];
					$this->ExtForm->input('cms_case_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $cms_assignment['CmsAssignment']['assigned_by'];
					$this->ExtForm->input('assigned_by', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $cms_assignment['CmsAssignment']['assigned_to'];
					$this->ExtForm->input('assigned_to', $options);
				?>			]
		});
		
		var CmsAssignmentEditWindow = new Ext.Window({
			title: '<?php __('Edit Cms Assignment'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CmsAssignmentEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CmsAssignmentEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Cms Assignment.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CmsAssignmentEditWindow.collapsed)
						CmsAssignmentEditWindow.expand(true);
					else
						CmsAssignmentEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					CmsAssignmentEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CmsAssignmentEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentCmsAssignmentData();
<?php } else { ?>
							RefreshCmsAssignmentData();
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
					CmsAssignmentEditWindow.close();
				}
			}]
		});

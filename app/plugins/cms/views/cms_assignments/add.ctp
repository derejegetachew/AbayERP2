		<?php
			$this->ExtForm->create('CmsAssignment');
			$this->ExtForm->defineFieldFunctions();
		?>
		var CmsAssignmentAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'cmsAssignments', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $cms_cases;
						
					$this->ExtForm->input('cms_case_id', $options);
				?>,
				<?php 
					$options = array();
					$options = array(
					'xtype'=>'combo',
					'fieldLabel'=>'Assign To',
					'items'=>$users);
					$this->ExtForm->input('assigned_to', $options);
				?>	,
				<?php 
					$options = array();
					$options = array(
					'xtype'=>'checkbox',
					'fieldLabel'=>'Include in F.A.Q');
					$this->ExtForm->input('searchable', $options);
				?>	]
		});
		
		var CmsAssignmentAddWindow = new Ext.Window({
			title: '<?php __('Add Cms Assignment'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CmsAssignmentAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CmsAssignmentAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Cms Assignment.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CmsAssignmentAddWindow.collapsed)
						CmsAssignmentAddWindow.expand(true);
					else
						CmsAssignmentAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Assign'); ?>',
				handler: function(btn){
					CmsAssignmentAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CmsAssignmentAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshCmsCaseData();
							RefreshCmsReplyData();
<?php } else { ?>
							RefreshCmsCaseData();
							RefreshCmsReplyData();
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
					CmsAssignmentAddWindow.close();
				}
			}]
		});

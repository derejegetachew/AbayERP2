		<?php
			$this->ExtForm->create('CmsCase');
			$this->ExtForm->defineFieldFunctions();
		?>
		var CmsCaseEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'cmsCases', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $cms_case['CmsCase']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $cms_case['CmsCase']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $cms_case['CmsCase']['content'];
					$this->ExtForm->input('content', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $branches;
					$options['value'] = $cms_case['CmsCase']['branch_id'];
					$this->ExtForm->input('branch_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $cms_case['CmsCase']['level'];
					$this->ExtForm->input('level', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $cms_case['CmsCase']['attachement'];
					$this->ExtForm->input('attachement', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $users;
					$options['value'] = $cms_case['CmsCase']['user_id'];
					$this->ExtForm->input('user_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $cms_case['CmsCase']['status'];
					$this->ExtForm->input('status', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $cms_case['CmsCase']['searchable'];
					$this->ExtForm->input('searchable', $options);
				?>			]
		});
		
		var CmsCaseEditWindow = new Ext.Window({
			title: '<?php __('Edit Cms Case'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CmsCaseEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CmsCaseEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Cms Case.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CmsCaseEditWindow.collapsed)
						CmsCaseEditWindow.expand(true);
					else
						CmsCaseEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					CmsCaseEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CmsCaseEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentCmsCaseData();
<?php } else { ?>
							RefreshCmsCaseData();
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
					CmsCaseEditWindow.close();
				}
			}]
		});

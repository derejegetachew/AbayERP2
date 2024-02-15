		<?php
			$this->ExtForm->create('DmsShare');
			$this->ExtForm->defineFieldFunctions();
		?>
		var DmsShareEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'dmsShares', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $dms_share['DmsShare']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $dms_documents;
					$options['value'] = $dms_share['DmsShare']['dms_document_id'];
					$this->ExtForm->input('dms_document_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $branches;
					$options['value'] = $dms_share['DmsShare']['branch_id'];
					$this->ExtForm->input('branch_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $users;
					$options['value'] = $dms_share['DmsShare']['user_id'];
					$this->ExtForm->input('user_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $dms_share['DmsShare']['read'];
					$this->ExtForm->input('read', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $dms_share['DmsShare']['write'];
					$this->ExtForm->input('write', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $dms_share['DmsShare']['delete'];
					$this->ExtForm->input('delete', $options);
				?>			]
		});
		
		var DmsShareEditWindow = new Ext.Window({
			title: '<?php __('Edit Dms Share'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: DmsShareEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					DmsShareEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Dms Share.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(DmsShareEditWindow.collapsed)
						DmsShareEditWindow.expand(true);
					else
						DmsShareEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					DmsShareEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DmsShareEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentDmsShareData();
<?php } else { ?>
							RefreshDmsShareData();
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
					DmsShareEditWindow.close();
				}
			}]
		});

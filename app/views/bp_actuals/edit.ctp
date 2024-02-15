		<?php
			$this->ExtForm->create('BpActual');
			$this->ExtForm->defineFieldFunctions();
		?>
		var BpActualEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $bp_actual['BpActual']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $bp_actual['BpActual']['amount'];
					$this->ExtForm->input('amount', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_actual['BpActual']['month'];
					$this->ExtForm->input('month', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $branches;
					$options['value'] = $bp_actual['BpActual']['branch_id'];
					$this->ExtForm->input('branch_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $bp_items;
					$options['value'] = $bp_actual['BpActual']['bp_item_id'];
					$this->ExtForm->input('bp_item_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_actual['BpActual']['remark'];
					$this->ExtForm->input('remark', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_actual['BpActual']['type'];
					$this->ExtForm->input('type', $options);
				?>			]
		});
		
		var BpActualEditWindow = new Ext.Window({
			title: '<?php __('Edit Bp Actual'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BpActualEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BpActualEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Bp Actual.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BpActualEditWindow.collapsed)
						BpActualEditWindow.expand(true);
					else
						BpActualEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					BpActualEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BpActualEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentBpActualData();
<?php } else { ?>
							RefreshBpActualData();
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
					BpActualEditWindow.close();
				}
			}]
		});

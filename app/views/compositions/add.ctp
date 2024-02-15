		<?php
			$this->ExtForm->create('Composition');
			$this->ExtForm->defineFieldFunctions();
		?>
		var CompositionAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'compositions', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
			<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $branches;
					$options['fieldLabel']="Unit/Branch";
					$this->ExtForm->input('branch_id', $options);
				?>,
				<?php 
					$options = array();
					$options['items'] = $positions;
					$options['fieldLabel']="Job Title";
					$this->ExtForm->input('position_id', $options);
				?>,				
				{
					xtype: 'numberfield',
					fieldLabel: 'Number of Positions',
					name: 'data[Composition][count]',
					anchor: '100%',
					value: '1',
					minValue:0,
					allowNegative:false,
					allowBlank:false,
					validator() {
						value = this.getValue();
						if (value >= 0) {
							return true;
						}
						return 'Not valid';
					}
				}			]
		});
		
		var CompositionAddWindow = new Ext.Window({
			title: '<?php __('Add New Positions'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CompositionAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CompositionAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Composition.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CompositionAddWindow.collapsed)
						CompositionAddWindow.expand(true);
					else
						CompositionAddWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					CompositionAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CompositionAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentCompositionData();
<?php } else { ?>
							RefreshCompositionData();
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
					CompositionAddWindow.close();
				}
			}]
		});

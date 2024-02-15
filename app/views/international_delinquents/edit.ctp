		<?php
			$this->ExtForm->create('InternationalDelinquent');
			$this->ExtForm->defineFieldFunctions();
		?>
		var InternationalDelinquentEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'internationalDelinquents', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $international_delinquent['InternationalDelinquent']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $international_delinquent['InternationalDelinquent']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $international_delinquent['InternationalDelinquent']['Nationality'];
					$this->ExtForm->input('Nationality', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $international_delinquent['InternationalDelinquent']['BOD'];
					$this->ExtForm->input('BOD', $options);
				?>			]
		});
		
		var InternationalDelinquentEditWindow = new Ext.Window({
			title: '<?php __('Edit International Delinquent'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: InternationalDelinquentEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					InternationalDelinquentEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing International Delinquent.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(InternationalDelinquentEditWindow.collapsed)
						InternationalDelinquentEditWindow.expand(true);
					else
						InternationalDelinquentEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					InternationalDelinquentEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							InternationalDelinquentEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentInternationalDelinquentData();
<?php } else { ?>
							RefreshInternationalDelinquentData();
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
					InternationalDelinquentEditWindow.close();
				}
			}]
		});

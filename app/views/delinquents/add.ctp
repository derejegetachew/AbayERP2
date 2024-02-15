		<?php
			$this->ExtForm->create('Delinquent');
			$this->ExtForm->defineFieldFunctions();
		?>
		var DelinquentAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'delinquents', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$this->ExtForm->input('Name', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('letter_no', $options);
				?>,
				/*<?php 
					$options = array();
					$this->ExtForm->input('Soundex_Name', $options);
				?>,*/
				<?php 
					$options = array();
					$this->ExtForm->input('Closing_Bank', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('Branch', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('Date_Account_Closed', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('Tin', $options);
				?>,
                                      <?php   	$options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Holder');
                                        $options['items'] = array('1' => 'Individual','2' => 'Company');
					$this->ExtForm->input('holder', $options);
                                   ?>,
                                      <?php   	$options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Type');
                                        $options['items'] = array('1' => 'Delinquent','2' => 'PEP','3' => 'Terminated');
					$this->ExtForm->input('type', $options);
                                   ?>,

				<?php 
					$options = array();
					$this->ExtForm->input('Reason_For_Closing', $options);
				?>
]

		});
		
		var DelinquentAddWindow = new Ext.Window({
			title: '<?php __('Add Delinquent'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: DelinquentAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					DelinquentAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Delinquent.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(DelinquentAddWindow.collapsed)
						DelinquentAddWindow.expand(true);
					else
						DelinquentAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					DelinquentAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DelinquentAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentDelinquentData();
<?php } else { ?>
							RefreshDelinquentData();
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
					DelinquentAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DelinquentAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentDelinquentData();
<?php } else { ?>
							RefreshDelinquentData();
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
					DelinquentAddWindow.close();
				}
			}]
		});

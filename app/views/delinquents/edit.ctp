		<?php
			$this->ExtForm->create('Delinquent');
			$this->ExtForm->defineFieldFunctions();
		?>
		var DelinquentEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'delinquents', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $delinquent['Delinquent']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $delinquent['Delinquent']['Name'];
					$this->ExtForm->input('Name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $delinquent['Delinquent']['letter_no'];
					$this->ExtForm->input('letter_no', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $delinquent['Delinquent']['Soundex_Name'];
					$this->ExtForm->input('Soundex_Name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $delinquent['Delinquent']['Closing_Bank'];
					$this->ExtForm->input('Closing_Bank', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $delinquent['Delinquent']['Branch'];
					$this->ExtForm->input('Branch', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $delinquent['Delinquent']['Date_Account_Closed'];
					$this->ExtForm->input('Date_Account_Closed', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $delinquent['Delinquent']['Tin'];
					$this->ExtForm->input('Tin', $options);
				?>,
				<?php  
                                                $options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Holder');
                                        $options['items'] = array('1' => 'Individual','2' => 'Company');					
					$options['value'] = $delinquent['Delinquent']['holder'];
					$this->ExtForm->input('holder', $options);
				?>,<?php  
                                                $options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Type');
                                        $options['items'] = array('1' => 'Delinquent','2' => 'PEP','3' => 'Terminated');					
					$options['value'] = $delinquent['Delinquent']['type'];
					$this->ExtForm->input('type', $options);
				?>
				]
		});
		
		var DelinquentEditWindow = new Ext.Window({
			title: '<?php __('Edit Delinquent'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: DelinquentEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					DelinquentEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Delinquent.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(DelinquentEditWindow.collapsed)
						DelinquentEditWindow.expand(true);
					else
						DelinquentEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					DelinquentEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DelinquentEditWindow.close();
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
					DelinquentEditWindow.close();
				}
			}]
		});

		<?php
			$this->ExtForm->create('MisLetterDetail');
			$this->ExtForm->defineFieldFunctions();
		?>
		var MisLetterDetailEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'misLetterDetails', 'action' => 'edit')); ?>',
			defaultType: 'textfield',
			

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $mis_letter_detail['MisLetterDetail']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $mis_letters;
					$options['value'] = $mis_letter_detail['MisLetterDetail']['mis_letter_id'];
					$this->ExtForm->input('mis_letter_id', $options);
				?>,
				<?php 
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Type', 'editable' => false, 'anchor' => '60%');
					$options['items'] = array('Account' => 'Account', 'Share' => 'Share');
					$options['value'] = $mis_letter_detail['MisLetterDetail']['type'];
					$this->ExtForm->input('type', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'Account/Share Of');
					$options['value'] = $mis_letter_detail['MisLetterDetail']['account_of'];
					$this->ExtForm->input('account_of', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'Account/Share Number');
					$options['value'] = $mis_letter_detail['MisLetterDetail']['account_number'];
					$this->ExtForm->input('account_number', $options);
				?>,
				<?php 
					$options = array('allowBlank' => false, 'vtype' => 'Currency', 'anchor' => '60%');
					$options['maskRe'] = '/[0-9.]/i';
					$options['value'] = $mis_letter_detail['MisLetterDetail']['amount'];
					$this->ExtForm->input('amount', $options);
				?>,				
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						id: 0,
						fields: ['id','name'],
						
						data: [
						<?php foreach($branches as $branch){?>
						['<?php echo $branch['Branch']['id']?>','<?php echo $branch['Branch']['name']?>'],
						<?php
						}
						?>
						]
						
					}),
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[MisLetterDetail][branch_id]',
					id: 'branch',
					name: 'branch',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select One',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '60%',
					fieldLabel: '<span style="color:red;">*</span> Branch',
					allowBlank: false,
					editable: true,
					lazyRender: true,
					blankText: 'Your input is invalid.',
					value: '<?php echo $mis_letter_detail['MisLetterDetail']['branch_id'];?>'
				},
				<?php 
					$options = array(
						'xtype' => 'textarea',
						'grow' => true,
						'fieldLabel' => 'Remark',
						'anchor' => '100%'
					);
					$options['value'] = $mis_letter_detail['MisLetterDetail']['remark'];
					$this->ExtForm->input('remark', $options);
				?>	]
		});
		
		var MisLetterDetailEditWindow = new Ext.Window({
			title: '<?php __('Edit Mis Letter Detail'); ?>',
			width: 500,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: MisLetterDetailEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					MisLetterDetailEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Mis Letter Detail.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(MisLetterDetailEditWindow.collapsed)
						MisLetterDetailEditWindow.expand(true);
					else
						MisLetterDetailEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					MisLetterDetailEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							MisLetterDetailEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentMisLetterDetailData();
<?php } else { ?>
							RefreshMisLetterDetailData();
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
					MisLetterDetailEditWindow.close();
				}
			}]
		});

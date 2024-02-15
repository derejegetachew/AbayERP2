		<?php
			$this->ExtForm->create('Delegation');
			$this->ExtForm->defineFieldFunctions();
		?>

		var DelegationAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'delegations', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				   {
                        xtype: 'combo',
                        hiddenName: 'data[Delegation][employee_id]',
                        forceSelection: true,
                        emptyText: 'Write Full Name',
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'local',
                        valueField: 'id',
                        displayField: 'full_name',
                        allowBlank: false,
                        blankText: 'Your input is invalid.',
                        store : vstore_employee_names,
                        fieldLabel: 'For ',
                        width:200,
                        hideTrigger:true,
                        tpl: '<tpl for="."><div ext:qtip="{full_name} . {position}" class="x-combo-list-item">{full_name} <br><b>{position}</b></div></tpl>'                       
                                    },
					   {
                        xtype: 'combo',
                        hiddenName: 'data[Delegation][delegated]',
                        forceSelection: true,
                        emptyText: 'Write Full Name',
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'local',
                        valueField: 'id',
                        displayField: 'full_name',
                        allowBlank: false,
                        blankText: 'Your input is invalid.',
                        store : vstore_employee_names,
                        fieldLabel: 'Assign ',
                        width:200,
                        hideTrigger:true,
                        tpl: '<tpl for="."><div ext:qtip="{full_name} . {position}" class="x-combo-list-item">{full_name} <br><b>{position}</b></div></tpl>'                       
                                    },
				<?php 
					$options = array();
					$this->ExtForm->input('start', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('end', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('comment', $options);
				?>			]
		});
		
		var DelegationAddWindow = new Ext.Window({
			title: '<?php __('Add Delegation'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: DelegationAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					DelegationAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Delegation.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(DelegationAddWindow.collapsed)
						DelegationAddWindow.expand(true);
					else
						DelegationAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					DelegationAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DelegationAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentDelegationData();
<?php } else { ?>
							RefreshDelegationData();
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
					DelegationAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DelegationAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentDelegationData();
<?php } else { ?>
							RefreshDelegationData();
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
					DelegationAddWindow.close();
				}
			}]
		});

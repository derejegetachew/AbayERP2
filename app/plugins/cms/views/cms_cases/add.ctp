		<?php
			$this->ExtForm->create('CmsCase');
			$this->ExtForm->defineFieldFunctions();
		?>
		
		var store_groups = new Ext.data.Store({
			reader: new Ext.data.JsonReader({
					root:'rows',
					totalProperty: 'results',
					fields: [
						'id', 'name'		
					]
			}),
			proxy: new Ext.data.HttpProxy({
					url: '<?php echo $this->Html->url(array('controller' => 'cmsCases', 'action' => 'search_group')); ?>'
			})
		});
	
		var CmsCaseAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'cmsCases', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array('fieldLabel' => 'Ticket Number','readOnly' => 'true');
					date_default_timezone_set("Africa/Addis_Ababa");  
                    $options['value'] = date("Ymd").'/'.str_pad(($count + 1), 3,'0',STR_PAD_LEFT);
					$this->ExtForm->input('ticket_number', $options);
				?>,
				<?php 
					$options = array();
					$options = array('fieldLabel' => 'Title');
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array(
						'xtype' => 'textarea',
						'grow' => false,
						'fieldLabel' => 'Content',
						'anchor' => '100%'					
						);
					
					$this->ExtForm->input('content', $options);
				?>,
				<?php 
					$options = array('disableKeyFilter' => 'false','editable' => 'true');
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
					$options['listeners'] = "{
                            scope: this,
                            'select': function(combo, record, index){
                                var group = Ext.getCmp('group');
                                group.setValue('');
                                group.store.removeAll();
                                group.store.reload({
                                    params: {
                                        branch_id : combo.getValue()
                                    }
                                });
                            }
                        }";
					$options['items'] = $branches;
					$this->ExtForm->input('branch_id', $options);
				?>,
				{
					xtype: 'combo',
					emptyText: 'All',
					id: 'group',
					name: 'group',
					hiddenName:'data[CmsCase][cms_group_id]',
					store : store_groups,
					displayField : 'name',
					valueField : 'id',
					anchor:'100%',
					fieldLabel: '<span style="color:red;">*</span> Group',
					mode: 'local',
					disableKeyFilter : true,
					allowBlank: false,
					typeAhead: true,
					emptyText: 'Select Group',
					editable: false,
					triggerAction: 'all'
				},				
				<?php 
					$options = array(
					'xtype' => 'combo',
					'fieldLabel' => 'Severity',
					'anchor' => '100%'
					);
					$options['items'] = array('low' => 'Low','medium' => 'Medium', 'high' => 'High','critical' => 'Critical');
					$this->ExtForm->input('level', $options);
				?>		]
		});
		
		var CmsCaseAddWindow = new Ext.Window({
			title: '<?php __('Create a New Issue'); ?>',
			width: 600,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CmsCaseAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CmsCaseAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Cms Case.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CmsCaseAddWindow.collapsed)
						CmsCaseAddWindow.expand(true);
					else
						CmsCaseAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Add Attachments'); ?>',
				handler: function(btn){
					CmsCaseAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){							
							CmsCaseAddWindow.close();
							ViewParentAttachments(a.result.msg);
							CmsCaseAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Send'); ?>',
				handler: function(btn){
					CmsCaseAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: 'Case Created',
                                icon: Ext.MessageBox.INFO
							});
							CmsCaseAddWindow.close();
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
					CmsCaseAddWindow.close();
				}
			}]
		});

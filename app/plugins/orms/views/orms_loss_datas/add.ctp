		<?php
			$this->ExtForm->create('OrmsLossData');
			$this->ExtForm->defineFieldFunctions();
		?>
		
		var store_subcategories = new Ext.data.Store({
			reader: new Ext.data.JsonReader({
					root:'rows',
					totalProperty: 'results',
					fields: [
						'id', 'name'		
					]
			}),
			proxy: new Ext.data.HttpProxy({
					url: '<?php echo $this->Html->url(array('controller' => 'ormsLossDatas', 'action' => 'search_subcategory')); ?>'
			})
		});
		
		var store_risks = new Ext.data.Store({
			reader: new Ext.data.JsonReader({
					root:'rows',
					totalProperty: 'results',
					fields: [
						'id', 'name'		
					]
			}),
			proxy: new Ext.data.HttpProxy({
					url: '<?php echo $this->Html->url(array('controller' => 'ormsLossDatas', 'action' => 'search_risk')); ?>'
			})
		});
		
		var OrmsLossDataAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 120,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ormsLossDatas', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						id: 0,
						fields: ['id','name'],
						
						data: [
						<?php foreach($orms_risk_categories as $category){?>
						['<?php echo $category['OrmsRiskCategory']['id']?>','<?php echo $category['OrmsRiskCategory']['name']?>'],
						<?php
						}
						?>
						]
						
					}),
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[OrmsLossData][category_id]',
					id: 'category',
					name: 'category',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select Category',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Risk Category',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.',
					listeners : {
						scope: this,
						'select': function(combo, record, index){
							var subcategory = Ext.getCmp('subcategory');
							subcategory.setValue('');
							subcategory.store.removeAll();
							subcategory.store.reload({
								params: {
									category_id : combo.getValue()
								}
							});
						}
					}
				},
				{
					xtype: 'combo',
					store : store_subcategories,
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[OrmsLossData][subcategory_id]',
					id: 'subcategory',
					name: 'subcategory',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select SubCategory',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Risk SubCategory',
					allowBlank: false,
					editable: false,					
					blankText: 'Your input is invalid.',
					listeners : {
						scope: this,
						'select': function(combo, record, index){
							var risk = Ext.getCmp('risk');
							risk.setValue('');
							risk.store.removeAll();
							risk.store.reload({
								params: {
									subcategory_id : combo.getValue()
								}
							});
						}
					}
				},
				{
					xtype: 'combo',
					store : store_risks,
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[OrmsLossData][orms_risk_category_id]',
					id: 'risk',
					name: 'risk',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select risk',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Risk',
					allowBlank: false,
					editable: false,					
					blankText: 'Your input is invalid.'
				},
				<?php 
					$options = array('xtype' => 'textarea','grow' => false,'fieldLabel' => 'Description','anchor' => '100%');
					$this->ExtForm->input('description', $options);
				?>,				
				<?php 
					$options = array('anchor' => '60%');
					$this->ExtForm->input('occured_from', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%');
					$this->ExtForm->input('occured_to', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%');
					$this->ExtForm->input('discovered_date', $options);
				?>,
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "id", direction: "DESC" },
						storeId: 'severity',
						id: 0,
						fields: ['id','name'],
						
						data: [						
							[1,'Insignificant'],	[2,'Minor'],	[3,'Moderate'],	[4,'Major'],	[5,'Disastrous'],					
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[OrmsLossData][severity]',
					id: 'severity',
					name: 'severity',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select One',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '60%',
					fieldLabel: '<span style="color:red;">*</span> Severity',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					
					blankText: 'Your input is invalid.'
				},
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "id", direction: "DESC" },
						storeId: 'frequency',
						id: 0,
						fields: ['id','name'],
						
						data: [						
							[1,'Rare'],	[2,'Unlikely'],	[3,'Possible'],	[4,'Likely'],	[5,'Almost certain'],					
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[OrmsLossData][frequency]',
					id: 'frequency',
					name: 'frequency',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select One',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '60%',
					fieldLabel: '<span style="color:red;">*</span> Frequency',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				},
				<?php 
					$options = array('anchor' => '60%');
					$this->ExtForm->input('insured_amount', $options);
				?>			]
		});
		
		var OrmsLossDataAddWindow = new Ext.Window({
			title: '<?php __('Add Orms Loss Data'); ?>',
			width: 500,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: OrmsLossDataAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					OrmsLossDataAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Orms Loss Data.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(OrmsLossDataAddWindow.collapsed)
						OrmsLossDataAddWindow.expand(true);
					else
						OrmsLossDataAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					OrmsLossDataAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							OrmsLossDataAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentOrmsLossDataData();
<?php } else { ?>
							RefreshOrmsLossDataData();
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
					OrmsLossDataAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							OrmsLossDataAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentOrmsLossDataData();
<?php } else { ?>
							RefreshOrmsLossDataData();
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
					OrmsLossDataAddWindow.close();
				}
			}]
		});

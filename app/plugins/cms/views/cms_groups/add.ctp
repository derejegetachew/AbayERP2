		<?php
			$this->ExtForm->create('CmsGroup');
			$this->ExtForm->defineFieldFunctions();
		?>
		
		var store_employee_names = new Ext.data.GroupingStore({
		reader: new Ext.data.JsonReader({
				root:'rows',
				totalProperty: 'results',
				fields: [
					'user_id', 'full_name','position','photo'		
				]
		}),
		proxy: new Ext.data.HttpProxy({
				url: '<?php echo $this->Html->url(array('controller' => '../employees', 'action' => 'search_emp2')); ?>'
		}),	
			sortInfo:{field: 'full_name', direction: "ASC"}
		});
      store_employee_names.load({
            params: {
                start: 0
            }
        });
		
		var CmsGroupAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'cmsGroups', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$this->ExtForm->input('name', $options);
				?>,				
				{
				xtype: 'combo',
				store : new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'my_array_store',
						fields: ['id','name'],						
						data: [
						<?php foreach($branches as $branch){?>
						['<?php echo $branch['Branch']['id']?>','<?php echo $branch['Branch']['name']?>'],
						<?php
						}
						?>
						]
						
					}),
				hiddenName: 'data[CmsGroup][branch_id]',
				forceSelection: true,
				emptyText: 'Select Branch',
				triggerAction: 'all',
				lazyRender: true,
				mode: 'local',
				valueField: 'id',
				displayField: 'name',
				allowBlank: false,
				blankText: 'Your input is invalid.',				
				fieldLabel: 'Branch',
				width:265,
				},				
				{
				xtype: 'combo',
				hiddenName: 'data[CmsGroup][user_id]',
				forceSelection: true,
				emptyText: 'Select Team Leader',
				triggerAction: 'all',
				lazyRender: true,
				mode: 'local',
				valueField: 'user_id',
				displayField: 'full_name',
				allowBlank: false,
				blankText: 'Your input is invalid.',
				store : store_employee_names,
				fieldLabel: 'Team Leader',
				width:265,
				tpl: '<tpl for="."><div ext:qtip="{full_name} . {position}" class="x-combo-list-item"><div><img src="{photo}" style="float:left;width:32px"/> </div> {full_name} <br><b>{position}</b></div></tpl>'
                
             }]
		});
		
		var CmsGroupAddWindow = new Ext.Window({
			title: '<?php __('Add Group'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CmsGroupAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CmsGroupAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Cms Group.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CmsGroupAddWindow.collapsed)
						CmsGroupAddWindow.expand(true);
					else
						CmsGroupAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					CmsGroupAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CmsGroupAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentCmsGroupData();
<?php } else { ?>
							RefreshCmsGroupData();
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
					CmsGroupAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CmsGroupAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentCmsGroupData();
<?php } else { ?>
							RefreshCmsGroupData();
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
					CmsGroupAddWindow.close();
				}
			}]
		});

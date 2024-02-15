		<?php
			$this->ExtForm->create('Stafftooktraining');
			$this->ExtForm->defineFieldFunctions();
		?>
		 
		var StafftooktrainingAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			autoHeight: true,
			url:'<?php echo $this->Html->url(array('controller' => 'stafftooktrainings', 'action' => 'add2')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $takentrainings;
					$this->ExtForm->input('takentraining_id', $options);
				?>,
				{
				msgTarget: 'under',
                allowAddNewData: true,
                id:'employees',
				height:400,
				forceSelection: true,
                xtype:'superboxselect',
                fieldLabel: 'Employee List',
                emptyText: 'Write Names Here',
                resizable: true,
                name: 'data[Stafftooktraining][employees][]',
                anchor:'100%',
                store: vstore_employee_names,
                mode: 'local',
                displayField: 'full_name',
                valueField: 'id',
				tpl: '<tpl for="."><div ext:qtip="{full_name} . {position}" class="x-combo-list-item"><div><img src="{photo}" style="float:left;width:32px"/> </div> {full_name} <br><b>{position}</b></div></tpl>',
                extraItemCls: 'x-tag',
                listeners: {
                    beforeadditem: function(bs,v){
                        //console.log('beforeadditem:', v);
                        //return false;
                    },
                    additem: function(bs,v){
                        //console.log('additem:', v);
                    },
                    beforeremoveitem: function(bs,v){
                        //console.log('beforeremoveitem:', v);
                        //return false;
                    },
                    removeitem: function(bs,v){
                        //console.log('removeitem:', v);
                    },
                    newitem: function(bs,v){
                        v = v.slice(0,1).toUpperCase() + v.slice(1).toLowerCase();
                        var newObj = {
                            id: v,
                            name: v
                        };
                        bs.addItem(newObj);
                    }
                }
             }
					]
		});
		
		var StafftooktrainingAddWindow = new Ext.Window({
			title: '<?php __('Add Stafftooktraining'); ?>',
			width: 900,
			minWidth: 400,	
			height: 300,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: StafftooktrainingAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					StafftooktrainingAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Stafftooktraining.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(StafftooktrainingAddWindow.collapsed)
						StafftooktrainingAddWindow.expand(true);
					else
						StafftooktrainingAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					StafftooktrainingAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							StafftooktrainingAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentStafftooktrainingData();
<?php } else { ?>
							RefreshStafftooktrainingData();
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
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					StafftooktrainingAddWindow.close();
				}
			}]
		});

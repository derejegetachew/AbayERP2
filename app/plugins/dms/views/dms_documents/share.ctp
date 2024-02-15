		<?php
			$this->ExtForm->create('DmsDocument');
			$this->ExtForm->defineFieldFunctions();
		?>
		
	var store_employee_names = new Ext.data.GroupingStore({
		reader: new Ext.data.JsonReader({
				root:'rows',
				totalProperty: 'results',
				fields: [
					'user_id', 'full_name','position'		
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
		
	var store_branch_names = new Ext.data.GroupingStore({
		reader: new Ext.data.JsonReader({
				root:'rows',
				totalProperty: 'results',
				fields: [
					'id', 'name'	
				]
		}),
		proxy: new Ext.data.HttpProxy({
				url: '<?php echo $this->Html->url(array('controller' => '../branches', 'action' => 'list_data')); ?>'
		}),	
			sortInfo:{field: 'name', direction: "ASC"}
		});
      store_branch_names.load({
            params: {
                limit: 1000
            }
        });
		var DmsDocumentAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			height:100,
			id:'DmsDocumentAddForm',
			autoHeight: true,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'share')); ?>',
			defaultType: 'textfield',

			items: [
			<?php $this->ExtForm->input('id', array('hidden' => $folder_id)); ?>,
			{ 
                                xtype: 'fieldset',
                                title: 'Give Read Only Access To:',
                                autoHeight: true,
                                boxMinHeight: 300,
								collapsible: true,
								items:[
								{
								xtype:'checkbox',
								fieldLabel:'All Branches',
								name:'data[DmsDocument][all]',
								id:'checkbox',
								handler: function(chk,checked) {
									if(checked==true){
										Ext.getCmp('branches').disable();
										alert('Your folder will be visible to everyone');
									}else{
										Ext.getCmp('branches').enable();
									}				
								}
								},{
				allowBlank:true,
				msgTarget: 'under',
                allowAddNewData: true,
                id:'branches',
				height:300,
				forceSelection: true,
                xtype:'superboxselect',
                fieldLabel: 'Branches',
                emptyText: 'Enter or select one or more branches here',
                resizable: true,
                name: 'data[DmsDocument][branches][]',
                anchor:'100%',
                store: store_branch_names,
                mode: 'local',
                displayField: 'name',
                valueField: 'id',
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
             }]},
			 { 
                                xtype: 'fieldset',
                                title: 'Give Read & Write Access To:',
                                autoHeight: true,
                                boxMinHeight: 300,
								collapsible: true,
								collapsed: true,
								items:[{
								xtype:'checkbox',
								fieldLabel:'All Branches',
								name:'data[DmsDocument][all2]',
								id:'checkbox2',
								handler: function(chk,checked) {
									if(checked==true){
										Ext.getCmp('branches2').disable();
										Ext.getCmp('employees2').disable();
										alert('Your folder will be editable to everyone');
									}else{
										Ext.getCmp('branches2').enable();
										Ext.getCmp('employees2').enable();
									}				
								}
								},{
				allowBlank:true,
				msgTarget: 'under',
                allowAddNewData: true,
                id:'branches2',
				height:300,
				forceSelection: true,
                xtype:'superboxselect',
                fieldLabel: 'Branches',
                emptyText: 'Enter or select one or more branches here',
                resizable: true,
                name: 'data[DmsDocument][branches2][]',
                anchor:'100%',
                store: store_branch_names,
                mode: 'local',
                displayField: 'name',
                valueField: 'id',
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
             },{
				allowBlank:true,
				msgTarget: 'under',
                allowAddNewData: true,
                id:'employees2',
				height:300,
				forceSelection: true,
                xtype:'superboxselect',
                fieldLabel: 'Staff Names',
                emptyText: 'Enter or select one or more names here',
                resizable: true,
                name: 'data[DmsDocument][employees2][]',
                anchor:'100%',
                store: store_employee_names,
                mode: 'local',
                displayField: 'full_name',
                valueField: 'user_id',
				tpl: '<tpl for="."><div ext:qtip="{full_name} . {position}" class="x-combo-list-item">{full_name} <br><b>{position}</b></div></tpl>',
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
             }]},
			 { 
                                xtype: 'fieldset',
                                title: 'Give  Full access (R/W + Delete) Access To:',
                                autoHeight: true,
                                boxMinHeight: 300,
								collapsible: true,
								collapsed: true,
								items:[
								{
				allowBlank:true,
				msgTarget: 'under',
                allowAddNewData: true,
                id:'branches3',
				height:300,
				forceSelection: true,
                xtype:'superboxselect',
                fieldLabel: 'Branches',
                emptyText: 'Enter or select one or more branches here',
                resizable: true,
                name: 'data[DmsDocument][branches3][]',
                anchor:'100%',
                store: store_branch_names,
                mode: 'local',
                displayField: 'name',
                valueField: 'id',
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
             },{
				allowBlank:true,
				msgTarget: 'under',
                allowAddNewData: true,
                id:'employees3',
				height:300,
				forceSelection: true,
                xtype:'superboxselect',
                fieldLabel: 'Staff Names',
                emptyText: 'Enter or select one or more names here',
                resizable: true,
                name: 'data[DmsDocument][employees3][]',
                anchor:'100%',
                store: store_employee_names,
                mode: 'local',
                displayField: 'full_name',
                valueField: 'user_id',
				tpl: '<tpl for="."><div ext:qtip="{full_name} . {position}" class="x-combo-list-item">{full_name} <br><b>{position}</b></div></tpl>',
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
             }]}]
		});
		
		var DmsDocumentShareWindow = new Ext.Window({
			title: '<?php __('Share Folder'); ?>',
			width: 700,
			height: 700,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: DmsDocumentAddForm,
			buttons: [ {
				text: '<?php __('Done'); ?>',
				handler: function(btn){
			 DmsDocumentAddForm.getForm().submit({
                                waitMsg: '<?php __('Processing your request...'); ?>',
                                waitTitle: '<?php __('Wait Please...'); ?>',
                                success: function(f,a){
                                    Ext.Msg.show({
                                        title: '<?php __('Success'); ?>',
                                        buttons: Ext.MessageBox.OK,
                                        msg: a.result.msg,
                                        icon: Ext.MessageBox.INFO
                                    });
                                    DmsDocumentShareWindow.close();
                                    RefreshDmsDocumentData();
       
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
					DmsDocumentShareWindow.close();
				}
			}]
		});

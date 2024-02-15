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
		var DmsDocumentAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			height:100,
			id:'DmsDocumentAddForm',
			autoHeight: true,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'sendupload')); ?>',
			defaultType: 'textfield',

			items: [{
				allowBlank:false,
				msgTarget: 'under',
                allowAddNewData: true,
                id:'employees',
				height:300,
				forceSelection: true,
                xtype:'superboxselect',
                fieldLabel: 'To',
                emptyText: 'Enter or select one or more receipients here',
                resizable: true,
                name: 'data[DmsDocument][employees][]',
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
             },
			 <?php 
					$options = array();
					$options['fieldLabel']='Message (Optional)';
					$this->ExtForm->input('msg', $options);
				?>]
		});
		
		var DmsDocumentSendWindow = new Ext.Window({
			title: '<?php __('Send Files'); ?>',
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
				text: '<?php __('Add Files To Send'); ?>',
				handler: function(btn){
			
		if(DmsDocumentAddForm.getForm().isValid()){
			 Ext.Ajax.request({
                params: DmsDocumentAddForm.getForm().getValues(),
                url: '<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'sendupload')); ?>',
				method: 'POST',
				success: function(response, opts) {
				var dmsShare_data = response.responseText;
				
				eval(dmsShare_data);
				
				DmsDocumentUploadWindow.show();
				DmsDocumentSendWindow.close();
				},
				failure: function(response, opts) {
					Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the send window. Error code'); ?>: ' + response.status);
				}
			});
			}
				}
			},{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					DmsDocumentSendWindow.close();
				}
			}]
		});


    var RequisitionProgressForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ims_requisitions', 'action' => 'request_progress')); ?>',
			defaultType: 'textfield',

			items: [{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						
						
						fields: ['id','name'],
						
						data: [						
						['approved','Approved'],['SIRV created','SIRV Created'],['accepted','Accepted'],['received','Received'],['completed','Completed']					
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[ImsRequisition][status]',
					id: 'status',
					name: 'status',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select Status',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Status',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				},{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'my_array_store',
						id: 0,
						fields: ['id','name'],
						
						data: [						
						['HTML','HTML'],['PDF','PDF'],['EXCEL','EXCEL'],						
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[ImsRequisition][type]',
					id: 'type',
					name: 'type',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select Type',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> OutPut Type',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				}, {
					xtype: 'textfield',
					id: 'title',
					name: 'data[ImsRequisition][title]',
					hiddenName:'data[ImsRequisition][title]',
					emptyText: 'give a title',
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Title',
					allowBlank: false,
					blankText: 'Your input is invalid.'
					}]
		});
    
    
    var EmpCardWindow = new Ext.Window({
	title: 'Fixed Asset',
	width: 400,
	minWidth: 400,
	autoHeight: true,
	resizable: false,
	items: RequisitionProgressForm,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'center',
    modal: true,
	tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					RequisitionProgressForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to view fixed asset report.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(EmpCardWindow.collapsed)
						EmpCardWindow.expand(true);
					else
						EmpCardWindow.collapse(true);
				}
			}],
	buttons: [{
		text: 'Display',
		handler: function(btn){
			var form = RequisitionProgressForm.getForm(); // or inputForm.getForm();
			var el = form.getEl().dom;
			var target = document.createAttribute("target");
			target.nodeValue = "_blank";
			el.setAttributeNode(target);
			el.action = form.url;
			el.submit();
		//RequisitionProgressForm.getForm().submit({  target:'_blank'});
		}
            },{
		text: 'Close',
		handler: function(btn){
                    EmpCardWindow.close();
		}
            }]
    });
	EmpCardWindow.show();
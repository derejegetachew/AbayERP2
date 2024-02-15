//<script>

    var MaintenanceRequestReportForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'fms_maintenance_requests', 'action' => 'maintenance_request_report')); ?>',
			defaultType: 'textfield',

			items: [{
				xtype: 'compositefield',
                msgTarget : 'side',
                anchor    : '-20',
				fieldLabel: '<span style="color:red;">*</span> Date Range',
                defaults: {
                    flex: 1
                },
				items: [
                    {
					xtype : 'datefield',
					format : 'Y-m-d',
					hiddenName:'data[FmsVehicle][from]',
					id: 'from',
					name: 'data[FmsVehicle][from]',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'From Date',
					anchor: '100%',
					allowBlank: false,
					editable: false,
					selectOnFocus:true,
					valueField: 'id',
					fieldLabel: '<span style="color:red;">*</span> From',
					blankText: 'Your input is invalid.'
					},{
					xtype : 'datefield',
					format : 'Y-m-d',
					hiddenName:'data[FmsVehicle][to]',
					id: 'to',
					name: 'data[FmsVehicle][to]',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'To Date',
					anchor: '100%',
					allowBlank: false,
					editable: false,
					selectOnFocus:true,
					valueField: 'id',
					fieldLabel: '<span style="color:red;">*</span> To',
					blankText: 'Your input is invalid.'
					}
				]
				},{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						
						storeId: 'my_array_store',
						id: 0,
						fields: ['id','name'],
						
						data: [						
						['HTML','HTML'],['PDF','PDF'],['EXCEL','EXCEL'],						
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[FmsVehicle][type]',
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
				}]
		});
    
    
    var MaintenanceRequestReportWindow = new Ext.Window({
	title: 'Maintenance Request Report',
	width: 400,
	minWidth: 400,
	autoHeight: true,
	resizable: false,
	items: MaintenanceRequestReportForm,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'center',
    modal: true,
	tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					MaintenanceRequestReportForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to view Ending Balance report.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(MaintenanceRequestReportWindow.collapsed)
						MaintenanceRequestReportWindow.expand(true);
					else
						MaintenanceRequestReportWindow.collapse(true);
				}
			}],
	buttons: [{
		text: 'Display',
		handler: function(btn){
			var form = MaintenanceRequestReportForm.getForm(); // or inputForm.getForm();
			var el = form.getEl().dom;
			var target = document.createAttribute("target");
			target.nodeValue = "_blank";
			el.setAttributeNode(target);
			el.action = form.url;
			el.submit();
		//MaintenanceRequestReportForm.getForm().submit({  target:'_blank'});
		}
            },{
		text: 'Close',
		handler: function(btn){
                    MaintenanceRequestReportWindow.close();
		}
            }]
    });
	MaintenanceRequestReportWindow.show();
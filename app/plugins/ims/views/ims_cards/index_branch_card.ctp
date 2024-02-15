//<script>

    var BranchCardForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ims_cards', 'action' => 'branch_card')); ?>',
			defaultType: 'textfield',

			items: [
     {
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
					hiddenName:'data[ImsCard][from]',
					id: 'from',
					name: 'data[ImsCard][from]',
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
					hiddenName:'data[ImsCard][to]',
					id: 'to',
					name: 'data[ImsCard][to]',
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
				}
				,
      {
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						id: 0,
						fields: ['id','name'],
						
						data: [
						['All','All'],
						<?php foreach($branches as $branch){?>
						['<?php echo $branch['Branch']['id']?>','<?php echo $branch['Branch']['name']?>'],
						<?php
						}
						?>
						]
						
					}),
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[ImsCard][branch]',
					id: 'employee',
					name: 'data[ImsCard][branch]',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select One',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Branch',
					allowBlank: false,
					editable: true,
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
					hiddenName:'data[ImsCard][type]',
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
					name: 'data[ImsCard][title]',
					hiddenName:'data[ImsCard][title]',
					emptyText: 'give a title',
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Title',
					allowBlank: false,
					blankText: 'Your input is invalid.'
					}]
		});
    
    
    var BranchCardWindow = new Ext.Window({
	title: 'Fixed Asset',
	width: 400,
	minWidth: 400,
	autoHeight: true,
	resizable: false,
	items: BranchCardForm,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'center',
    modal: true,
	tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BranchCardForm.getForm().reset();
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
					if(BranchCardWindow.collapsed)
						BranchCardWindow.expand(true);
					else
						BranchCardWindow.collapse(true);
				}
			}],
	buttons: [{
		text: 'Display',
		handler: function(btn){
			var form = BranchCardForm.getForm(); // or inputForm.getForm();
			var el = form.getEl().dom;
			var target = document.createAttribute("target");
			target.nodeValue = "_blank";
			el.setAttributeNode(target);
			el.action = form.url;
			el.submit();
		//BranchCardForm.getForm().submit({  target:'_blank'});
		}
            },{
		text: 'Close',
		handler: function(btn){
                    BranchCardWindow.close();
		}
            }]
    });
	BranchCardWindow.show();
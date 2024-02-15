		<?php
			$this->ExtForm->create('FrwfmApplication');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IssueAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'nb_report')); ?>',
			defaultType: 'textfield',
			items: [
{ xtype: 'datefield',
 fieldLabel: 'From Date', 
 name: 'data[FrwfmApplication][fromDt]', 
 id: 'data[FrwfmApplication][fromDt]'},

 { xtype: 'datefield',
 fieldLabel: 'To Date',
 name: 'data[FrwfmApplication][toDt]',
 id: 'data[FrwfmApplication][toDt]'},
 ]
		});

		var NBWindow = new Ext.Window({
			title: '<?php __('NBE Report'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IssueAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IssueAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Issue.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(NBWindow.collapsed)
						NBWindow.expand(true);
					else
						NBWindow.collapse(true);
				}
			}],
			buttons: [{
				text: '<?php __('Display '); ?>',
				handler: function(btn){
					 var form = IssueAddForm.getForm(); // or inputForm.getForm();
					 var el = form.getEl().dom;
					 var target = document.createAttribute("target");
					 target.nodeValue = "_blank";
					 el.setAttributeNode(target);
					 el.action = form.url;
					 el.submit();
				}
			},
{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					NBWindow.close();
				}
			}]
		});
		NBWindow.show();

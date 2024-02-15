//<script>
function ListDeliquent() {
	console.log('inside ListDeliquent');
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'delinquents', 'action' => 'index')); ?>',
		success: function(response, opts) {
			var deliquent_data = response.responseText;
			
			eval(deliquent_data);
			
			DeliquentEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the deliquent index form. Error code'); ?>: ' + response.status);
		}
	});
}
/*-------------------------------------------------------------------------------------------------------------*/
		
		<?php
			$this->ExtForm->create('delinquentApplication');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IssueAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'delinquents', 'action' => 'search_for_branches')); ?>',
			defaultType: 'textfield',
			items: [
{ xtype: 'textfield',
 fieldLabel: 'First Name', 
 name: 'data[delinquentApplication][Name]', 
 id: 'data[delinquentApplication][Name]'},
 ]
		});

		var NBWindow = new Ext.Window({
			title: '<?php __('Search For Delinquent'); ?>',
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
			/*buttons: [{
				text: '<?php __('Display Delinquent '); ?>',
				handler:  function(btn){
						ListDeliquent();
						NBWindow.close();
					}
			},
{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					NBWindow.close();
				}
			}]*/
			buttons: [{
				text: '<?php __('Display Delinquent '); ?>',
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

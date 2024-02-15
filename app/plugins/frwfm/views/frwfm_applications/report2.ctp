		<?php
			$this->ExtForm->create('FrwfmApplication');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FrwfmApplicationAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'report')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$options['fieldLabel']='Initial Order';
					$this->ExtForm->input('initial_order', $options);
				?>,<?php 
					$options = array();
					$options['fieldLabel']='Invoice No';
					$this->ExtForm->input('proforma_invoice_no', $options);
				?>,<?php 
					$options = array();
					$options['fieldLabel']='Customer Name';
					$this->ExtForm->input('namex', $options);
				?>,
				<?php 
					$options = array();
					$options['fieldLabel']='Minute';
					$this->ExtForm->input('minute', $options);
				?>,
				<?php 
					$options = array();
						$options['items'] = $branches;
						$options['value'] = 'All';
					$this->ExtForm->input('branch_id', $options);
				?>,
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Status', 'value' => 'All');
                    $options['items'] = array('All' => 'All', 'Waiting List' => 'Waiting List','Presented for Approval'=>'Presented for Approval','Approved'=>'Approved','Posted'=>'Posted','Canceled'=>'Canceled');
					$this->ExtForm->input('status', $options);
				?>,
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Relation With Bank', 'value' => '');
                    $options['items'] = array(''=>'All','Depositor' => 'Depositor', 'Exporter' => 'Exporter','Borrower'=>'Borrower');
					$this->ExtForm->input('relation_with_bank', $options);
				?>,
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Mode of Payment', 'value' => '');
                    $options['items'] = array(''=>'All','LC' => 'LC', 'CAD' => 'CAD','TT'=>'TT');
					$this->ExtForm->input('mode_of_payment', $options);
				?>,<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Types of Goods', 'value' => '');
					$options['items'] = array(''=>'All','Fuel' => 'Fuel', 'Fertilizer' => 'Fertilizer','Other Agricultural Inputs'=>'Other Agricultural Inputs','Pharmaceutical Products'=>'Pharmaceutical Products','Factories Request for Machineries'=>'Factories Request for Machineries','Factories Request for Equipments'=>'Factories Request for Equipments','Factories Request for Spare Parts'=>'Factories Request for Spare Parts','Factories Request for Raw Material'=>'Factories Request for Raw Material','Factories Request for Accessories'=>'Factories Request for Accessories','Nutrition food for babies'=>'Nutrition food for babies','Salary Transfer for foreign employees'=>'Salary Transfer for foreign employees','Freight and Transit Service Payment'=>'Freight and Transit Service Payment','Invisible'=>'Invisible','Other'=>'Other');
					$this->ExtForm->input('types_of_goods', $options);
				?>,<?php 
					$options = array();
					$options['fieldLabel']='Amount with prefix ><= ';
					$this->ExtForm->input('amountr', $options);
				?>,<?php 
					$options = array();
					$options['fieldLabel']='From Date Y-m-d';
					$this->ExtForm->input('datex', $options);
				?>,<?php 
					$options = array();
					$options['fieldLabel']='To Date Y-m-d';
					$this->ExtForm->input('datex2', $options);
				?>,<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Currency', 'value' => '');
                    $options['items'] = array(''=>'All','ETB' => 'ETB', 'USD' => 'USD','EUR'=>'EUR','GBP'=>'GBP','NOK'=>'NOK','DKK'=>'DKK','JPY'=>'JPY','CAD'=>'CAD','UAE'=>'UAE','CHF'=>'CHF','ZAR'=>'ZAR');
					$this->ExtForm->input('currency', $options);
				?>,
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Order By', 'value' => 'initial_order');
                    $options['items'] = array('name' => 'Name', 'order' => 'Current Waiting Order','initial_order'=>'Initial Order','amount'=>'Amount','deposit_amount'=>'Deposit Amount');
					$this->ExtForm->input('Order', $options);
				?>	]
		});
		
		var ReportWindow = new Ext.Window({
			title: '<?php __('Report/Search'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FrwfmApplicationAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FrwfmApplicationAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Frwfm Application.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ReportWindow.collapsed)
						ReportWindow.expand(true);
					else
						ReportWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Printable'); ?>',
				handler: function(btn){
										     var form = FrwfmApplicationAddForm.getForm(); // or inputForm.getForm();
     var el = form.getEl().dom;
     var target = document.createAttribute("target");
     target.nodeValue = "_blank";
     el.setAttributeNode(target);
     el.action = form.url;
     el.submit();
				}
			}, {
				text: '<?php __('Excel'); ?>',
				handler: function(btn){
					 var form = FrwfmApplicationAddForm.getForm(); // or inputForm.getForm();
					 var el = form.getEl().dom;
					 var target = document.createAttribute("target");
					 target.nodeValue = "_blank";
					 el.setAttributeNode(target);
					 el.action = form.url + "/excel";
					 el.submit();
				}
			},{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					ReportWindow.close();
				}
			}]
		});
ReportWindow.show();
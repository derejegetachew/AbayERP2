<?php
			$this->ExtForm->create('CompetenceCategory');
			$this->ExtForm->defineFieldFunctions();
		?>
		var CompetenceCategoryReportForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'competenceCategories', 'action' => 'br_report')); ?>',
			defaultType: 'textfield',

			items: [
				
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $budget_years;
					$this->ExtForm->input('budget_year_id', $options);
				?>,
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'my_array_store',
						id: 0,
						fields: ['id','name'],
						
						data: [						
						['EXCEL','EXCEL'],						
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[CompetenceCategory][output_type]',
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
				},
				
							]
		});
		
		var CompetenceCategoryReportWindow = new Ext.Window({
			title: '<?php __('Show Report'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CompetenceCategoryReportForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CompetenceCategoryReportForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ho Performance Plan.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CompetenceCategoryReportWindow.collapsed)
						CompetenceCategoryReportWindow.expand(true);
					else
						CompetenceCategoryReportWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Display'); ?>',
				handler: function(btn){
					var form = CompetenceCategoryReportForm.getForm(); // or inputForm.getForm();
					var el = form.getEl().dom;
					var target = document.createAttribute("target");
					target.nodeValue = "_blank";
					el.setAttributeNode(target);
					el.action = form.url;
					el.submit();

				}
			}, {
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					CompetenceCategoryReportWindow.close();
				}
			}]
		});

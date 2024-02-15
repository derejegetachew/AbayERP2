		<?php
			$this->ExtForm->create('DmsGroupList');
			$this->ExtForm->defineFieldFunctions();
		?>
var myst= new Ext.data.ArrayStore({
id: 0,
fields: ['id','name'],
data:[<?php foreach($positions as $k=>$dmg){
	echo "['".$k."','".str_replace("&","",str_replace("'","",$dmg))."'],";
}?>]
});
		var DmsGroupListAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'dmsGroupLists', 'action' => 'add_position')); ?>',
			defaultType: 'textfield',

			items: [
				{	store:myst,
					xtype: 'combo',
					name: 'position_id',
					hiddenName: 'data[DmsGroupList][position_id]',
					fieldLabel: '<span style="color:red;">*</span> Position',
					typeAhead: true,
					emptyText: 'Select One',
					editable: true,
					forceSelection: true,
					triggerAction: 'all',
					lazyRender: true,
					mode: 'local',
					valueField: 'id',
					displayField: 'name',
					allowBlank: false,
					anchor: '100%'
				}
				<?php 
					//$options = array();
					//$options['xtype'] = $positions;
					//$this->ExtForm->input('position_id', $options);
				?>	,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $dms_groups;
					$this->ExtForm->input('dms_group_id', $options);
				?>			]
		});
		
		var DmsGroupListAddWindow = new Ext.Window({
			title: '<?php __('Add Group List'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: DmsGroupListAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					DmsGroupListAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Dms Group List.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(DmsGroupListAddWindow.collapsed)
						DmsGroupListAddWindow.expand(true);
					else
						DmsGroupListAddWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					DmsGroupListAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DmsGroupListAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentDmsGroupListData();
<?php } else { ?>
							RefreshDmsGroupListData();
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
				text: '<?php __('Preview'); ?>',
				handler: function(btn){
					values=DmsGroupListAddForm.getForm().getValues();
					pos_id=values['data[DmsGroupList][position_id]'];
					window.open('http://10.1.10.86/AbayERP/dms/dms_group_lists/preview_pos/'+myst.getAt(myst.find('id',pos_id)).data.name,'targetWindow',
                                   `toolbar=no,
                                    status=no,
                                    menubar=no,
                                    scrollbars=yes,
                                    resizable=yes,
                                    width=500,
                                    height=400`);
					
					
				}
			},{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					DmsGroupListAddWindow.close();
				}
			}]
		});

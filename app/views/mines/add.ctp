		//<script>
                <?php
			$this->ExtForm->create('Mine');
			$this->ExtForm->defineFieldFunctions();
		?>
		var MineAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'mines', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('field', $options);
				?>			]
		});


//custom array
var seltab;
var selfil;
var tabcheck=[];

function tableChange(val) {
        if (tabcheck.indexOf(val)!=-1) {
            return '<b><span style="color:red;">' + val + '</span></b>';
        } 
        return val;
    }

function fieldChange(val) {
        if (eval('fieldcheck'+seltab).indexOf(val)!=-1) {
            return '<b><span style="color:red;">' + val + '</span></b>';
        }
        return val;
    }
function AddCriteria() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'mines', 'action' => 'addcriteria')); ?>'+'?table='+seltab+'&field='+selfil,
		success: function(response, opts) {
			var crit_data = response.responseText;
			
			eval(crit_data);
			
			CritAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Criteria add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditCriteria(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'mines', 'action' => 'editcriteria')); ?>'+'?table='+seltab+'&field='+selfil+'&criteria='+id,
		success: function(response, opts) {
			var crit_data = response.responseText;
			
			eval(crit_data);
			
			CritAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Criteria add form. Error code'); ?>: ' + response.status);
		}
	});
}
function AddField() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'mines', 'action' => 'addfield')); ?>',
		success: function(response, opts) {
			var crit_data = response.responseText;
			
			eval(crit_data);
			
			FieldAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Criteria add form. Error code'); ?>: ' + response.status);
		}
	});
}

		var gridtable = new Ext.grid.GridPanel({
                store: store,
		sm: new Ext.grid.RowSelectionModel({singleSelect:true}),
                columns: [
                            {
                        id       :'table', 
                        width    : 200, 
                        dataIndex: 'table',
			renderer : tableChange, 
                            }],
                            title: 'Tables',
                    stateId: 'gridtable'
                });
                gridtable.on('rowclick', function(grid, rowIndex, columnIndex, e) {
                seltab=rowIndex;
                //eval("var fieldx = 'field'+rowIndex");
                fieldstore.loadData(eval('field'+rowIndex));
		criteriastore.loadData(none);
		btns.findById('add-criteria').disable();
		btns.findById('edit-criteria').disable();
		btns.findById('delete-criteria').disable();
                }, this);
var none= [];
var fieldstore = new Ext.data.ArrayStore({
        fields: [
           {name: 'field'}
        ]
    });
      fieldstore.loadData(none);
                var gridfield = new Ext.grid.GridPanel({
                store: fieldstore,
		sm: new Ext.grid.RowSelectionModel({singleSelect:true}),
                columns: [
                            {
                        id       :'field', 
                        width    : 150, 
                        dataIndex: 'field',
			renderer : fieldChange,
                            }],
                    title: 'Fields',
                    stateId: 'gridfield'
                });
               gridfield.on('rowclick', function(grid, rowIndex, columnIndex, e) {
		selfil=rowIndex;
		btns.findById('add-criteria').enable();
		btns.findById('edit-criteria').disable();
		btns.findById('delete-criteria').disable();
		var varstr='table'+seltab+'field'+selfil;
                criteriastore.loadData(eval(varstr));
		
                }, this);

var criteriastore = new Ext.data.ArrayStore({
        fields: [
           {name: 'field'}
        ]
    });
      criteriastore.loadData(none);
                var gridcriteria = new Ext.grid.GridPanel({
                store: criteriastore,
		sm: new Ext.grid.RowSelectionModel({singleSelect:true}),
                columns: [
                            {
                        id       :'field', 
                        width    : 200, 
                        dataIndex: 'field'
                            }],
                    title: 'Criteria',
                    stateId: 'gridcriteria'
                });
              gridcriteria.on('rowclick', function(grid, rowIndex, columnIndex, e) {
		btns.findById('edit-criteria').enable();
		btns.findById('delete-criteria').enable();
		
                }, this);


		var btns=new Ext.Panel({
                id:'btns-panel',
		items:[{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					id:'add-criteria',
					tooltip:'<?php __('Add Criteria'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						AddCriteria();
					}
				},{
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id:'edit-criteria',
					tooltip:'<?php __('Edit Criteria'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = gridcriteria.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
						//alert(gridcriteria.store.getAt(1).get('field'));
						EditCriteria(gridcriteria.store.indexOf(sel[0]));

						}}
					},
					{
					xtype: 'tbbutton',
					text: '<?php __('Remove'); ?>',
					id:'delete-criteria',
					tooltip:'<?php __('Remove Criteria'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm=gridcriteria.getSelectionModel();
var sel=sm.getSelections();
for(var i=0; i<sel.length; i++){
gridcriteria.store.remove(sel[i]);
}
if(gridcriteria.store.getCount()<=0){
for(var x=0; x<50; x++){
var strck=eval('field'+seltab+'['+selfil+']');
var tmpind=eval('fieldcheck'+seltab).indexOf(String(strck));
if(tmpind==-1)
break;
var varstr='fieldcheck'+seltab+'.splice('+tmpind+',1);';
eval(varstr);
}
fieldstore.loadData(eval('field'+seltab));
}
if(eval('fieldcheck'+seltab).length<=0){
for(var y=0; y<20; y++){
var tbind=tabcheck.indexOf(String(data[seltab]));
if(tbind==-1)
break;
tabcheck.splice(tbind,1);
}
store.loadData(data);
}
var varstr='table'+seltab+'field'+selfil+'=[];';
eval(varstr);
//criteriastore.loadData(eval(varstr),true);
gridcriteria.getStore().each(function(rec){
var rowData=rec.data;
var varstr='table'+seltab+'field'+selfil+'.push(["'+rowData['field']+'"]);';
eval(varstr);
});
//criteriastore.loadData(eval('table'+seltab+'field'+selfil),true);
btns.findById('edit-criteria').disable();
btns.findById('delete-criteria').disable();
					}
				}
				],
});
var outstr="";
            var panel = new Ext.Panel({
                id:'main-panel',
                baseCls:'x-plain',
                renderTo: Ext.getBody(),
                layout:'table',
                layoutConfig: {columns:4},
                defaults: {frame:true, width:220, height: 300},
                items:[gridtable,gridfield,gridcriteria,btns]
                });
		var MineAddWindow = new Ext.Window({
			title: '<?php __('Generate Report'); ?>',
			width: 760,
			minWidth: 700,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items:panel,
			buttons: [  {
				text: '<?php __('Next'); ?>',
				handler: function(btn){
				
					for(var i=0; i<tabcheck.length; i++){
						var conctable=gridtable.store.find('table',tabcheck[i]);
						if(conctable!=-1){
						    var arrfield=eval('field'+conctable);
						    fieldstore.loadData(arrfield);
						for(var j=0; j<eval('fieldcheck'+conctable).length; j++){
							var concfield=gridfield.store.find('field',eval('fieldcheck'+conctable+'['+j+']'));
							if(concfield!=-1){
							var arrcrit=eval('table'+conctable+'field'+concfield);
							for(var z=0; z<arrcrit.length; z++){
							outstr=outstr+'=_='+conctable+'*'+concfield+'*'+arrcrit[z];
							}
							}
						}

						}
					}//end for loop
AddField();
				}
			},{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					MineAddWindow.close();
				}
			}]
		});

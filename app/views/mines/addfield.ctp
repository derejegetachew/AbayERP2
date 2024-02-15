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
var seltabv;
var selfilv;
var tabcheckv=[];


function tableChangev(val) {
        if (tabcheckv.indexOf(val)!=-1) {
            return '<b><span style="color:darkgreen;">' + val + '</span></b>';
        } 
        return val;
    }

function fieldChangev(val) {
        if (eval('fieldcheckv'+seltabv).indexOf(val)!=-1) {
            return '<b><span style="color:darkgreen;">' + val + '</span></b>';
        }
        return val;
    }


		var gridtablev = new Ext.grid.GridPanel({
                store: storev,
		sm: new Ext.grid.RowSelectionModel({singleSelect:true}),
                columns: [
                            {
                        id       :'table', 
                        width    : 200, 
                        dataIndex: 'table',
			renderer : tableChangev, 
                            }],
                            title: 'Tables',
                    stateId: 'gridtablev'
                });
                gridtablev.on('rowclick', function(grid, rowIndex, columnIndex, e) {
                seltabv=rowIndex;
               btnsv.findById('sel-all').enable();
		btnsv.findById('des-all').enable();
                fieldstorev.loadData(eval('fieldv'+rowIndex));
		
                }, this);
var nonev= [];
var fieldstorev = new Ext.data.ArrayStore({
        fields: [
           {name: 'field'}
        ]
    });
      fieldstorev.loadData(nonev);
                var gridfieldv = new Ext.grid.GridPanel({
                store: fieldstorev,
                columns: [
                            {
                        id       :'field', 
                        width    : 150, 
                        dataIndex: 'field',
			renderer : fieldChangev,
                            }],
                    title: 'Fields',
                    stateId: 'gridfieldv'
                });

  		gridfieldv.on('rowclick', function(grid, rowIndex, columnIndex, e) {
              		var sm = gridfieldv.getSelectionModel();
			if(sm.isSelected(rowIndex)==true){
sm.unlock();
sm.deselectRow(rowIndex);
			}else{
sm.unlock();
			sm.selectRow(rowIndex,true);
sm.lock();
				}
				sm.lock();
		
                }, this);
var currentlyToggledv='';
var toggleHandlerv = function(btn, pressed){
	var clickedButton = btn.getText();
	currentlyToggledv = clickedButton;
}
var btnsv=new Ext.Panel({
                id:'btns-panel',
		items:[{
					xtype: 'tbbutton',
					text: '<?php __('Select All'); ?>',
					id:'sel-all',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = gridfieldv.getSelectionModel();
						sm.unlock();
						sm.selectAll();
						sm.lock();
					}
				},{
					xtype: 'tbbutton',
					text: '<?php __('Deselect All'); ?>',
					id:'des-all',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = gridfieldv.getSelectionModel();
						sm.unlock();
						sm.clearSelections();
						sm.lock();
					}
				},{
					xtype: 'tbbutton',
					text: '<?php __('Apply'); ?>',
					id:'apply',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
		var sm = gridfieldv.getSelectionModel();
						sm.each(function(rec){
var tmpind=eval('fieldcheckv'+seltabv).indexOf(String(rec.data.field));
if(tmpind==-1){
var exstr='fieldcheckv'+seltabv+'.push(String(rec.data.field));';
eval(exstr);
}
});
fieldstorev.loadData(eval('fieldv'+seltabv));
var tbind=tabcheckv.indexOf(String(data[seltabv]));
if(tbind==-1){
tabcheckv.push(String(datav[seltabv]));
storev.loadData(datav);}
					}
				},
{ 
					xtype: 'toolbar',
					columns: 9,
					defaults: {
						width: '50',
						enableToggle: true,
						toggleGroup : 'btnGroup',
						toggleHandler: toggleHandlerv
					},
					items: [
						{
							text: 'Unique data'
						}]}
]});
		
            var panel = new Ext.Panel({
                id:'main-panel',
                baseCls:'x-plain',
                renderTo: Ext.getBody(),
                layout:'table',
                layoutConfig: {columns:3},
                defaults: {frame:true, width:220, height: 300},
                items:[gridtablev,gridfieldv,btnsv]
                });
		var FieldAddWindow = new Ext.Window({
			title: '<?php __('Generate Report'); ?>',
			width: 560,
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
				text: '<?php __('Display'); ?>',
				handler: function(btn){
				var outstrv="";
					for(var i=0; i<tabcheckv.length; i++){
var tbind=tabcheck.indexOf(String(tabcheckv[i]));
if(tbind==-1){
tabcheck.push(String(tabcheckv[i]));
}
						var conctable=gridtablev.store.find('table',tabcheckv[i]);
						if(conctable!=-1){
						    var arrfield=eval('fieldv'+conctable);
						    fieldstorev.loadData(arrfield);
						for(var j=0; j<eval('fieldcheckv'+conctable).length; j++){
							var concfield=gridfieldv.store.find('field',eval('fieldcheckv'+conctable+'['+j+']'));
							if(concfield!=-1){
							outstrv=outstrv+'=_='+conctable+'*'+concfield;
							
							}
						}

						}
					}//end for loop
var tbs='';
for(var i=0; i<tabcheck.length; i++){
tbs=tbs+'*'+gridtablev.store.find('table',tabcheck[i]);
}
var param = {}; 
param[0]=outstr+'splithere'+outstrv+'splithere'+tbs;
param[1]=currentlyToggledv;
window.open('<?php echo $this->Html->url(array('controller' => 'mines', 'action' => 'generate')); ?>?param0=' + param[0]+'&param1='+param[1]);
MineAddWindow.close();
FieldAddWindow.close();
 /* Ext.Ajax.request({
                    url: '<?php echo $this->Html->url(array('controller' => 'mines', 'action' => 'generate')); ?>',
                    params: param,
                    method: 'GET',
                    success: function(response, opts){
						MineAddWindow.close();
                        FieldAddWindow.close();
						var data = response.responseText;
myWindow = window.open("data:text/html," + encodeURIComponent(data),
                       "_blank", "width=200,height=100");
myWindow.focus();

                    },
                    failure: function(){
                        // do stuff	
                    }
                });*/
					
				}
			},{
				text: '<?php __('Back'); ?>',
				handler: function(btn){
					FieldAddWindow.close();
				}
			}]
		});

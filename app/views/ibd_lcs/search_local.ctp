var currentlyToggled = '';
var toggleHandler = function(btn, pressed){
	var clickedButton = btn.getText();
	currentlyToggled = clickedButton;
}





function validateInput(operation, field, value) {
	if(operation == '' || field == '' || value == '')
		return 0;
	return 1;
}
function AddTextBoxValues(){
  
  if(Ext.getCmp('FCY_AMOUNT_L').getValue()!=''){
   AddParameter("<=",'FCY_AMOUNT',Ext.getCmp('FCY_AMOUNT_L').getValue());
    FCY_AMOUNT_L=Ext.getCmp('FCY_AMOUNT_L').getValue();
  }if(Ext.getCmp('FCY_AMOUNT_G').getValue()!=''){
  	AddParameter(">=","FCY_AMOUNT",Ext.getCmp('FCY_AMOUNT_G').getValue());
  	 FCY_AMOUNT_G=Ext.getCmp('FCY_AMOUNT_G').getValue();
  }if(Ext.getCmp('NAME_OF_IMPORTER').getValue()!=''){
  	AddParameter("LIKE","IbdLc.NAME_OF_IMPORTER",Ext.getCmp('NAME_OF_IMPORTER').getValue());
  	 NAME_OF_IMPORTER=Ext.getCmp('NAME_OF_IMPORTER').getValue();
  }



}

function AddParameter(currentlyToggled,field, value){

	if(!validateInput(currentlyToggled,field,value)){
		Ext.Msg.alert('Invalid Input','Your Input is Invalid');
		return;
	}
	
	if(currentlyToggled == "LIKE"){
		row = [[field, '\'' + field + ' LIKE\' => \'%' + value + '%\'']];
	}
	else if(currentlyToggled == "="){
		row = [[field, '\'' + field + '\' => \'' + value + '\'']];
	}
	else if(currentlyToggled == ">="){
        row = [[field, '\'' + field + ' >= \' => \'' + value + '\'']];
	}
	else if(currentlyToggled == "<="){
        row = [[field, '\'' + field + ' <= \' => \'' + value + '\'']];
	}
	else
		row = [[ field , "'" + field + ' ' + currentlyToggled + '\' => ' + InsertQuotations(value) ]];
	ParamStore.loadData(row,true);
	//ParamStore.reload();

	//Ext.getCmp('param_view').doLayout();
}

function InsertQuotations(value) {
	var quotedString = '';
	var values = value.split(',');
	for( i = 0; i < values.length; i++){
		if(i > 0)
			quotedString += ', ';
		quotedString += "'" + values[i].trim() + "'";
	}
	return quotedString;
}

function RemoveParameters(records){
		ParamStore.remove(records);
		ParamStore.reload();
}


function finalGrouping(records){
	var conditionsParameter = '';
	for(i = 0; i < records.length; i++){
			if(conditionsParameter == ''){
				conditionsParameter += 'array( ' + records[i].get('text') + ' )';
			}
			else
				conditionsParameter += ', array( ' + records[i].get('text') + ' )';
	}
	return conditionsParameter;
}


var SearchValue = new Ext.form.TextField({
	id: 'Search_Value',
	fieldLabel: '<?php __('Value'); ?>',
	anchor: '100%'
});

var ibdPurchaseOrderSearchForm = new Ext.form.FormPanel({
	 labelWidth: 100, // label settings here cascade unless overridden
        url:'save-form.php',
        bodyStyle:'padding:5px 5px 0',
        width: 350,
        autoHeight:true,
        defaults: {width: 230},

        items: [{
        	    id:'from_date',
                fieldLabel: 'From Date',
                xtype:'datefield',
                value:from_date,
                name: 'LC_ISSUE_DATE',
                allowBlank:true,
                listeners: {
			    	select: function(obj,d){
			    		
			    		from_date=(d.getMonth()+1)+"/"+d.getDate()+'/'+d.getFullYear();
			    		AddParameter(">=",obj.name,d.getFullYear()+"-"+ (d.getMonth()+1) +"-"+d.getDate());
			    	}
			    }
            },{
            	id:'to_date',
                fieldLabel: 'To Date',
                xtype:'datefield',
                value:to_date,
                 allowBlank:true,
                name: 'LC_ISSUE_DATE',
                listeners: {
			    	select: function(obj,d){
			    		to_date=(d.getMonth()+1)+"/"+d.getDate()+'/'+d.getFullYear();
			    		AddParameter("<=",obj.name,d.getFullYear()+"-"+(d.getMonth()+1) +"-"+d.getDate());
			    	}
			    }
            },{
                id: 'NAME_OF_IMPORTER',
                fieldLabel:'NAME OF IMPORTER',
                xtype:'textfield',
                value:NAME_OF_IMPORTER,
                name: 'NAME_OF_IMPORTER',
                 allowBlank:true
            },{
                id: 'FCY_AMOUNT_G',
                fieldLabel:'Fcy Amount(>=)',
                xtype:'textfield',
                value:FCY_AMOUNT_G,
                name: 'FCY_AMOUNT',
                 allowBlank:true
            },{
            	id: 'FCY_AMOUNT_L',
                fieldLabel:'Fcy Amount(<=)',
                name: 'FCY_AMOUNT',
                value:FCY_AMOUNT_L,
                xtype:'textfield',
                 allowBlank:true,
            },{
            	  store: new Ext.data.ArrayStore({ 
				    	id: 0, fields: [ 'id', 'name' ], 
					data: [ <?php $st = false;  foreach ($po as $k => $v) {
                    if ($st)
                        echo ',';
                    echo '[\'' . $k . '\', \'' . $v . '\']';
                    $st = true;
                    } ?> ]}), 
                id: 'LC_REF_NO',
                fieldLabel:'LC No',
                name: 'LC_REF_NO',
                xtype:'combo',
             	typeAhead: true, 
			    emptyText: 'Select One', 
			    editable: true, 
			    forceSelection: true, 
			    triggerAction: 'all', 
			    lazyRender: true, 
			    mode: 'local', 
			    valueField: 'id', 
			    value:LC_REF_NO,
			    displayField: 'name', 
			   allowBlank:true,
			    anchor: '100%',
			    listeners: {
			    	select: function(obj,r,i){
			    		//console.log(obj.name,);
			    		LC_REF_NO=r.data.id;
			    		AddParameter("=",obj.name,r.data.id);
			    	}
			    }

            },

{
            	  store: new Ext.data.ArrayStore({ 
				    	id: 0, fields: [ 'id', 'name' ], 
					data: [ <?php $st = false;  foreach ($permits as $k => $v) {
                    if ($st)
                        echo ',';
                    echo '[\'' . $k . '\', \'' . $v . '\']';
                    $st = true;
                    } ?> ]}), 
                id: 'PERMIT_NO',
                fieldLabel:'Permit No',
                name: 'PERMIT_NO',
                xtype:'combo',
             	typeAhead: true, 
			    emptyText: 'Select One', 
			    editable: true, 
			    forceSelection: true, 
			    triggerAction: 'all', 
			    lazyRender: true, 
			    mode: 'local', 
			    value:PERMIT_NO,
			    valueField: 'id', 
			    displayField: 'name', 
			    allowBlank:true,
			    anchor: '100%',
			    listeners: {
			    	select: function(obj,r,i){
			    		PERMIT_NO=r.data.id;
			    		AddParameter("=",obj.name,r.data.id);
			    	}
			    }

            }
            ,{
            	store: new Ext.data.ArrayStore({ 
		    	id: 0, fields: [ 'id', 'name' ], 
				data: [ <?php $st = false;  foreach ($currencies as $k => $v) {
                if ($st)
                    echo ',';
                echo '[\'' . $k . '\', \'' . $v . '\']';
                $st = true;
                } ?> ]}), 
                fieldLabel:'Currency Id',
                name: 'currency_id',
                 id: 'currency_id',
                xtype:'combo',
            	typeAhead: true, 
			    emptyText: 'Select One', 
			    editable: true, 
			    forceSelection: true, 
			    triggerAction: 'all', 
			    lazyRender: true, 
			    mode: 'local', 
			    valueField: 'id', 
			    value:currency_id,
			    displayField: 'name', 
			    allowBlank:true,
			    anchor: '100%',
			     listeners: {
			    	select: function(obj,r,i){
			    		currency_id=r.data.id;
			    		AddParameter("=",obj.name,r.data.id);
			    	}
			    }

            },
            {
            	store: new Ext.data.ArrayStore({ 
		    	id: 0, fields: [ 'id', 'name' ], 
				data: [ <?php $st = false;  foreach ($bank as $k => $v) {
                if ($st)
                    echo ',';
                echo '[\'' . $k . '\', \'' . $v . '\']';
                $st = true;
                } ?> ]}), 
                fieldLabel:'REIBURSING BANK',
                name: 'REIBURSING_BANK',
                 id: 'REIBURSING_BANK',
                xtype:'combo',
            	typeAhead: true, 
			    emptyText: 'Select One', 
			    editable: true, 
			    forceSelection: true, 
			    triggerAction: 'all', 
			    lazyRender: true, 
			    mode: 'local', 
			    valueField: 'id', 
			    value:REIBURSING_BANK,
			    displayField: 'name', 
			     allowBlank:true,
			    anchor: '100%',
			     listeners: {
			    	select: function(obj,r,i){
			    		REIBURSING_BANK=r.data.id;
			    		AddParameter("=",obj.name,r.data.id);
			    	}
			    }
            },{
            	store: new Ext.data.ArrayStore({ 
		    	id: 0, fields: [ 'id', 'name' ], 
				data: [ <?php $st = false;  foreach ($bank as $k => $v) {
                if ($st)
                    echo ',';
                echo '[\'' . $k . '\', \'' . $v . '\']';
                $st = true;
                } ?> ]}), 
                fieldLabel:'OPEN THROUGH',
                name: 'OPEN_THROUGH',
                 id: 'OPEN_THROUGH',
                xtype:'combo',
            	typeAhead: true, 
			    emptyText: 'Select One', 
			    editable: true, 
			    forceSelection: true, 
			    triggerAction: 'all', 
			    lazyRender: true, 
			    mode: 'local', 
			    valueField: 'id', 
			    value:OPEN_THROUGH,
			    displayField: 'name', 
			    allowBlank: true, 
			    anchor: '100%',
			     listeners: {
			    	select: function(obj,r,i){
			    		OPEN_THROUGH=r.data.id;
			    		AddParameter("=",obj.name,r.data.id);
			    	}
			    }
            },{
        	    id:'ext_from_date',
                fieldLabel: 'From Expire Date',
                xtype:'datefield',
                name: 'EXPIRY_DATE',
                value:ext_from_date,
                allowBlank:true,
                listeners: {
			    	select: function(obj,d){
			    		ext_from_date=(d.getMonth()+1)+"/"+d.getDate()+'/'+d.getFullYear();
			    		console.log(d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate());
			    		AddParameter(">=",obj.name,d.getFullYear()+"-"+ (d.getMonth()+1) +"-"+d.getDate());
			    	}
			    }
            },{
            	id:'ext_to_date',
                fieldLabel: 'To Expire Date',
                xtype:'datefield',
                value:ext_to_date,
                name: 'EXPIRY_DATE',
                 allowBlank:true,
                listeners: {
			    	select: function(obj,d){
			    		ext_to_date=(d.getMonth()+1)+"/"+d.getDate()+'/'+d.getFullYear();
			    		AddParameter("<=",obj.name,d.getFullYear()+"-"+(d.getMonth()+1) +"-"+d.getDate());
			    	}
			    }
            }
            
        ],

        buttons: [
        {
            xtype: 'button',
			text: '<?php __('Search'); ?>',
			handler: function(){
				console.log(ParamStore.getRange(0,ParamStore.getCount()));
				AddTextBoxValues();
				if(ParamStore.getCount() == 0)
					Ext.Msg.alert('<?php __('Invalid Input'); ?>','<?php __('Please input at least one search parameter'); ?>');
				else{
					export_all=false;
					SearchLocalWindow.close();
					var conditions = finalGrouping(ParamStore.getRange());
					store_ibdLcs.reload({
						  params: {
								start: 0,
								limit: list_size,
								conditions: conditions
						   }
					});
				}
			}
		},
		{
            text: 'Reset',
            handler: function(){
            		 PERMIT_NO='';
            		 LC_REF_NO='';
         		 currency_id=null;
         		  FCY_AMOUNT_G="";
                  FCY_AMOUNT_L="";
                  from_date=null;
                  to_date=null;
                  OPEN_THROUGH='';
                  REIBURSING_BANK='';
                   ext_from_date=null;
                  ext_to_date=null;
                  NAME_OF_IMPORTER=null;


                  Ext.getCmp('FCY_AMOUNT_G').setValue('');
				   Ext.getCmp('FCY_AMOUNT_L').setValue('');
                  Ext.getCmp('currency_id').setValue('');
                  Ext.getCmp('LC_REF_NO').setValue('');
                  Ext.getCmp('PERMIT_NO').setValue('');
                  Ext.getCmp('from_date').setValue('');
                  Ext.getCmp('to_date').setValue('');
                   Ext.getCmp('OPEN_THROUGH').setValue('');
                  Ext.getCmp('REIBURSING_BANK').setValue('');
                  Ext.getCmp('ext_from_date').setValue('');
                  Ext.getCmp('ext_to_date').setValue('');
                  Ext.getCmp('NAME_OF_IMPORTER').setValue('');
                  
                  ParamStore.removeAll();
            }
        }
        ,{
            text: 'Cancel',
            handler: function(){
            	SearchLocalWindow.close();
            }
        }]
});

var SearchLocalWindow = new Ext.Window({
	title: '<?php __('Search IbdPurchaseOrder'); ?>',
	modal: true,
	items: ibdPurchaseOrderSearchForm,
	resizable: false,
	width: 400,
	autoHeight: true,
	bodyStyle: 'padding: 5px;',
	layout: 'fit',
	plain: true
});
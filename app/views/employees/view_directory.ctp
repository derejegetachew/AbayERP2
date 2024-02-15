<?php //print_r($employee); ?>
    var store_employee_educations = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','level_of_attainment','field_of_study','institution','from_date','to_date','is_bank_related','employee','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'educations', 'action' => 'list_data', $employee['Employee']['id'])); ?>'	})
    });
    var store_employee_employeeDetails = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','employee','grade','step','position','branch','start_date','end_date','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'employeeDetails', 'action' => 'list_data', $employee['Employee']['id'])); ?>'	}),
             sortInfo:{field: 'start_date', direction: "ASC"}
    });
    var store_employee_experiences = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','employer','job_title','from_date','to_date','employee','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'experiences', 'action' => 'list_data', $employee['Employee']['id'])); ?>'	})
    });
    var store_employee_languages = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','name','speak','read','write','listen','employee','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'languages', 'action' => 'list_data', $employee['Employee']['id'])); ?>'	})
    });
    var store_employee_offsprings = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','first_name','last_name','sex','birth_date','employee','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'offsprings', 'action' => 'list_data', $employee['Employee']['id'])); ?>'	})
    });
		function EditPhoto(id){
		Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'editphoto')); ?>/'+id,
            success: function(response, opts) {
                var employee_data = response.responseText;
			
                eval(employee_data);
			
                EmployeeEditWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the employee edit form. Error code'); ?>: ' + response.status);
            }
	});
	}
<?php  
//  App::import('Amharic');
  //              $employee['User']['Person']['first_name_am']=Amharic::decode_amharic($employee['User']['Person']['first_name_am']);
      //          $employee['User']['Person']['middle_name_am']=Amharic::decode_amharic($employee['User']['Person']['middle_name_am']);
     //           $employee['User']['Person']['last_name_am']=Amharic::decode_amharic($employee['User']['Person']['last_name_am']);
                
$personal_html = "<table cellspacing=8  >" . 		
                "<tr><th align=right>" . __('Full Name', true) ."<br><br>". __('ሙሉ ስም', true) ."</th><td><b>" . $employee['User']['Person']['first_name'] ." ".$employee['User']['Person']['middle_name']." ".$employee['User']['Person']['last_name']. "</br>" . $employee['User']['Person']['first_name_am'] ." ".$employee['User']['Person']['middle_name_am']." ".$employee['User']['Person']['last_name_am']. "</b></td><th align=right>" . __('Mother Name', true) . ":</th><td><b>" . $employee['Employee']['mother_name'] . "</b></td>";
?>
<?php if($employee['Employee']['photo']!=''){ $personal_html.= "<td  valign=\"top\" rowspan=7><img src=\"img/employee_photos/" .  $employee['Employee']['photo'] . "\"/></td></tr>"; } else{ if($employee['User']['Person']['sex']=='M') $personal_html.= "<td  valign=\"top\" rowspan=7><img src=\"img/employee_photos/male.jpg\"/></td></tr>"; else $personal_html.= "<td  valign=\"top\" rowspan=7><img src=\"img/employee_photos/female.jpg\"/></td></tr>"; }?>
        
<?php 
if(!isset($employee['User']['Person']['BirthLocation']['name']))
    $employee['User']['Person']['BirthLocation']['name']='';
if(!isset($employee['Location']['name']))
    $employee['Location']['name']='';
if(!isset($employee['ContactLocation']['name']))
    $employee['ContactLocation']['name']='';
	
$personal_html.= "<tr><th align=right>" . __('Date of Birth', true) . ":</th><td><b>" . $employee['User']['Person']['birthdate'] . "</b></td><th align=right>" . __('Place of Birth', true) . ":</th><td><b>" . $employee['User']['Person']['BirthLocation']['name'] . "</b></td></tr>" . 
                
                "<tr><th align=right>" . __('Location', true) . ":</th><td><b>" . $employee['EmpLoc']['name'] . "</b></td><th align=right>" . __('City', true) . ":</th><td><b>" . $employee['Employee']['city'] . "</b></td></tr>" . 
		
		"<tr><th align=right>" . __('Kebele', true) . ":</th><td><b>" . $employee['Employee']['kebele'] . "</b></td><th align=right>" . __('House No', true) . ":</th><td><b>" . $employee['Employee']['house_no'] . "</b></td></tr>" . 
		
		"<tr><th align=right>" . __('P O Box', true) . ":</th><td><b>" . $employee['Employee']['p_o_box'] . "</b></td><th align=right>" . __('Telephone', true) . ":</th><td><b>" . $employee['Employee']['telephone'] . "</b></td></tr>" . 
		
		"<tr><th align=right>" . __('Marital Status', true) . ":</th><td><b>" . $employee['Employee']['marital_status'] . "</b></td><th align=right>" . __('Spouse Name', true) . ":</th><td><b>" . $employee['Employee']['spouse_name'] . "</b></td></tr>" . 
                
                "<tr><th align=right>" . __('Sex', true) . ":</th><td><b>" . $employee['User']['Person']['sex'] . "</b></td><th align=right>" . __('Identification Card Number', true) . ":</th><td><b>" . $employee['Employee']['card'] . "</b></td></tr>" . 
        
"</table>"; 
$contact_html="<table cellspacing=8>" . 		
               
		"<tr><th align=right>" . __('Full Name', true) . ":</th><td><b>" . $employee['Employee']['contact_name'] . "</b></td></td><th align=right>" . __('Email', true) . ":</th><td><b>" . $employee['Employee']['contact_email'] . "</b></td></tr>" . 
		
                "<tr><th align=right>" . __('Region', true) . ":</th><td><b>" . $employee['ContactLocation']['name'] . "</b></td><th align=right>" . __('City', true) . ":</th><td><b>" . $employee['Employee']['contact_city'] . "</b></tr>" . 
		
		"<tr><th align=right>" . __('Kebele', true) . ":</th><td><b>" . $employee['Employee']['contact_kebele'] . "</b></td><th align=right>" . __('House No', true) . ":</th><td><b>" . $employee['Employee']['contact_house_no'] . "</b></td></tr>" . 
		 
		"<tr><th align=right>" . __('Residence Tel', true) . ":</th><td><b>" . $employee['Employee']['contact_residence_tel'] . "</b></td><th align=right>" . __('Office Tel', true) . ":</th><td><b>" . $employee['Employee']['contact_office_tel'] . "</b></td></tr>" . 

		"<tr><th align=right>" . __('Mobile', true) . ":</th><td><b>" . $employee['Employee']['contact_mobile'] . "</b></td><th align=right>" . __('P O Box', true) . ":</th><td><b>" . $employee['Employee']['contact_p_o_box'] . "</b></td></tr>" . 
 
	"</table>"; 
function aasort (&$array, $key) {
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    $array=$ret;
}
function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}
//aasort($employee['EmployeeDetail'],"start_date");
array_sort_by_column($employee['EmployeeDetail'],"start_date");
//print_r($employee['EmployeeDetail']);
$employee_html="<table cellspacing=8>" . 		
		"<tr><th align=right>" . __('Date Of Employment', true) . ":</th><td><b>" . $employee['EmployeeDetail'][0]['start_date'] . "</b></td><th align=right>" . __('Terms of Employment', true) . ":</th><td><b>" . $employee['Employee']['terms_of_employment'] . "</b></td></tr>" . 
        "<tr><th align=right>" . __('Grade:', true) . ":</th><td><b>" . $employee['EmployeeDetail'][0]['Grade']['name'] . "</b></td><th align=right>" . __('Step', true) . ":</th><td><b>" . $employee['EmployeeDetail'][0]['Step']['name'] . "</b></td></tr>" . 
        "<tr><th align=right>" . __('Position', true) . ":</th><td><b>" . $employee['EmployeeDetail'][0]['Position']['name'] . "</b></td><th align=right>" . __('Branch', true) . ":</th><td><b>" . $employee['EmployeeDetail'][0]['Branch']['name'] . "</b></td></tr>" . 
"</table>"; 
if($employee['Employee']['status']!='active'){
    $employee_html="<b>Employee Terminated</b><br>Reason: ".$employee['Termination'][0]['reason']."<br>Date: ".$employee['Termination'][0]['date'];
}
?>
    var employee_view_panel_1 = {
        html : '<?php echo $personal_html; ?>',
        frame : true,
        autoHeight: true,
        autoWidth: true
    }
    var employee_view_panel_2 = {
        html : '<?php echo $contact_html; ?>',
        frame : true,
        autoHeight: true,
    }
    var employee_view_panel_3 = {
        html : '<?php echo $employee_html; ?>',
        frame : true,
        autoHeight: true,
    }
    var employee_view_panel_5 = new Ext.TabPanel({
        activeTab: 0,
        anchor: '100%',
        height:190,
        plain:true,
        defaults:{autoScroll: true},
        items:[
            {
                xtype: 'grid',
                loadMask: true,
                stripeRows: true,
                store: store_employee_educations,
                title: '<?php __('Education'); ?>',
                enableColumnMove: false,
                listeners: {
                    activate: function(){
                        if(store_employee_educations.getCount() == '')
                            store_employee_educations.reload();
                    }
                },
                columns: [
                    {header: "<?php __('Level Of Attainment'); ?>", dataIndex: 'level_of_attainment', sortable: true},
                    {header: "<?php __('Field Of Study'); ?>", dataIndex: 'field_of_study', sortable: true},
                    {header: "<?php __('Institution'); ?>", dataIndex: 'institution', sortable: true},
                    {header: "<?php __('From Date'); ?>", dataIndex: 'from_date', sortable: true},
                    {header: "<?php __('To Date'); ?>", dataIndex: 'to_date', sortable: true},
                    {header: "<?php __('Is Bank Related'); ?>", dataIndex: 'is_bank_related', sortable: true}
                    
                ],
                viewConfig: {
                    forceFit: true
                },
                bbar: new Ext.PagingToolbar({
                    pageSize: view_list_size,
                    store: store_employee_educations,
                    displayInfo: true,
                    displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
                    beforePageText: '<?php __('Page'); ?>',
                    afterPageText: '<?php __('of'); ?> {0}',
                    emptyMsg: '<?php __('No data to display'); ?>'
                })
            }, {
                xtype: 'grid',
                loadMask: true,
                stripeRows: true,
                store: store_employee_experiences,
                title: '<?php __('Experience'); ?>',
                enableColumnMove: false,
                listeners: {
                    activate: function(){
                        if(store_employee_experiences.getCount() == '')
                            store_employee_experiences.reload();
                    }
                },
                columns: [
                    {header: "<?php __('Employer'); ?>", dataIndex: 'employer', sortable: true},
                    {header: "<?php __('Job Title'); ?>", dataIndex: 'job_title', sortable: true},
                    {header: "<?php __('From Date'); ?>", dataIndex: 'from_date', sortable: true},
                    {header: "<?php __('To Date'); ?>", dataIndex: 'to_date', sortable: true}
                    
                ],
                viewConfig: {
                    forceFit: true
                },
                bbar: new Ext.PagingToolbar({
                    pageSize: view_list_size,
                    store: store_employee_experiences,
                    displayInfo: true,
                    displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
                    beforePageText: '<?php __('Page'); ?>',
                    afterPageText: '<?php __('of'); ?> {0}',
                    emptyMsg: '<?php __('No data to display'); ?>'
                })
            }, {
                xtype: 'grid',
                loadMask: true,
                stripeRows: true,
                store: store_employee_employeeDetails,
                title: '<?php __('Internal Experience'); ?>',
                enableColumnMove: false,
                listeners: {
                    activate: function(){
                        if(store_employee_employeeDetails.getCount() == '')
                            store_employee_employeeDetails.reload();
                    }
                },
                columns: [
                {header:"<?php __('Grade'); ?>", dataIndex: 'grade', sortable: true},
		{header:"<?php __('Step'); ?>", dataIndex: 'step', sortable: true},
		{header:"<?php __('Position'); ?>", dataIndex: 'position', sortable: true},
                {header:"<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
		{header: "<?php __('Start Date'); ?>", dataIndex: 'start_date', sortable: true},
                {header: "<?php __('End Date'); ?>", dataIndex: 'end_date', sortable: true}
                    
                ],
                viewConfig: {
                    forceFit: true
                },
                bbar: new Ext.PagingToolbar({
                    pageSize: view_list_size,
                    store: store_employee_employeeDetails,
                    displayInfo: true,
                    displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
                    beforePageText: '<?php __('Page'); ?>',
                    afterPageText: '<?php __('of'); ?> {0}',
                    emptyMsg: '<?php __('No data to display'); ?>'
                })
            },{
                xtype: 'grid',
                loadMask: true,
                stripeRows: true,
                store: store_employee_languages,
                title: '<?php __('Language Proficiency'); ?>',
                enableColumnMove: false,
                listeners: {
                    activate: function(){
                        if(store_employee_languages.getCount() == '')
                            store_employee_languages.reload();
                    }
                },
                columns: [
                    {header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
                    {header: "<?php __('Speak'); ?>", dataIndex: 'speak', sortable: true},
                    {header: "<?php __('Read'); ?>", dataIndex: 'read', sortable: true},
                    {header: "<?php __('Write'); ?>", dataIndex: 'write', sortable: true},
                    {header: "<?php __('Listen'); ?>", dataIndex: 'listen', sortable: true}
                    
                ],
                viewConfig: {
                    forceFit: true
                },
                bbar: new Ext.PagingToolbar({
                    pageSize: view_list_size,
                    store: store_employee_languages,
                    displayInfo: true,
                    displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
                    beforePageText: '<?php __('Page'); ?>',
                    afterPageText: '<?php __('of'); ?> {0}',
                    emptyMsg: '<?php __('No data to display'); ?>'
                })
            }, {
                xtype: 'grid',
                loadMask: true,
                stripeRows: true,
                store: store_employee_offsprings,
                title: '<?php __('Children'); ?>',
                enableColumnMove: false,
                listeners: {
                    activate: function(){
                        if(store_employee_offsprings.getCount() == '')
                            store_employee_offsprings.reload();
                    }
                },
                columns: [
                    {header: "<?php __('First Name'); ?>", dataIndex: 'first_name', sortable: true},
                    {header: "<?php __('Last Name'); ?>", dataIndex: 'last_name', sortable: true},
                    {header: "<?php __('Sex'); ?>", dataIndex: 'sex', sortable: true},
                    {header: "<?php __('Birth Date'); ?>", dataIndex: 'birth_date', sortable: true}
                    
                ],
                viewConfig: {
                    forceFit: true
                },
                bbar: new Ext.PagingToolbar({
                    pageSize: view_list_size,
                    store: store_employee_offsprings,
                    displayInfo: true,
                    displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
                    beforePageText: '<?php __('Page'); ?>',
                    afterPageText: '<?php __('of'); ?> {0}',
                    emptyMsg: '<?php __('No data to display'); ?>'
                })
            }			]
    });
    
    var EmployeeViewWindow = new Ext.Window({
        title: '<?php __('Detail of Employee'); ?>: <?php echo $employee['User']['Person']['first_name'] . " " . $employee['User']['Person']['middle_name'] . " " . $employee['User']['Person']['last_name']; ?>',
        width: 700,
        minWidth: 500,
        autoHeight: true,
        resizable: true,
        plain:true,
        bodyStyle:'padding:5px;',
        buttonAlign:'center',
        modal: true,
        items: [ {   
                xtype:'fieldset',
                title: 'Personal Information',
                autoHeight: true,
                boxMinHeight: 300,
                items: [employee_view_panel_1]
            }
            
        ],
        
        buttons: [{
                text: '<?php __('Close'); ?>',
                handler: function(btn){
                    EmployeeViewWindow.close();
                }
            }]
    });
    
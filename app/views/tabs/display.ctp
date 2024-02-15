if(center_panel.find('id', 'tab-tabx') != "") {
	var p = center_panel.findById('tab-tabx');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Tabs'); ?>',
		closable: true,
		loadMask: true,
		id: 'tab-tabx',
		xtype: 'tabpanel',
		enableTabScroll:true,
		margins: '0 0 0 0',
		plugins: new Ext.ux.TabCloseMenu(),
		activeTab: 0,
		items: [{
	title: '<?php echo $tab['Tab']['name']; ?>',
	html: '<?php echo $tab['Tab']['content']; ?>'
}]
		
	});

	center_panel.setActiveTab(p);

	
}

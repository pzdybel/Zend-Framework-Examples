dojo.provide('limesoft.Footer');

dojo.require('dijit._Templated');
dojo.require('limesoft._Widget');

dojo.declare('limesoft.Footer', [limesoft._Widget, dijit._Templated], {

	topic: limesoft.topic.footer,

	templateString: dojo.cache('limesoft', 'templates/Footer.html'),

	widgetsInTemplate: true,

	onReady: function() {

		this.applicationNode.innerHTML = limesoft.system.get('application');

		dojo.style(this.container, 'display', 'block');
	}

});

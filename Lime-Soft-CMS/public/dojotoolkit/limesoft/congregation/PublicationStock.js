dojo.provide('limesoft.congregation.PublicationStock');

dojo.require('dijit._Templated');
dojo.require('dijit.layout.BorderContainer');
dojo.require('dijit.layout.ContentPane');
dojo.require('limesoft._Widget');
dojo.require('dojox.rpc.JsonRPC');
dojo.require('dojox.rpc.Service');

dojo.declare('limesoft.congregation.PublicationStock', [limesoft._Widget, dijit._Templated], {

	templateString: dojo.cache('limesoft.congregation', 'templates/PublicationStock.html'),

	widgetsInTemplate: true,

	_pubServ: null,

	constructor: function() {

		this._pubServ = new dojox.rpc.Service(limesoft.baseUrl + 'congregation/services/publication');
	},

	buildRendering: function() {

		this.inherited(arguments);

		this._pubServ.test();
	},

	resize: function(arguments) {

		this.wrapper.resize();
	},

	onReady: function() {

		dojo.style(this.container, 'display', 'block');

		this.resize();
	}

});

dojo.provide('limesoft.Content');

dojo.require('dijit._Templated');
dojo.require('limesoft._Widget');
dojo.require('dijit.layout.ContentPane');

dojo.declare('limesoft.Content', [limesoft._Widget, dijit._Templated], {

	topic: limesoft.topic.content,

	templateString: dojo.cache('limesoft', 'templates/Content.html'),

	widgetsInTemplate: true,

	_temporaryContentNode: null,

	postMixInProperties: function() {

		this.inherited(arguments);

		this._temporaryContentNode = this.srcNodeRef;
	},

	startup: function() {

		this.inherited(arguments);

		// TODO: this is a temporary fix, review it
		if(null != this._temporaryContentNode) {
			if(typeof(this._temporaryContentNode.firstChild.id) == 'undefined') {
				this._setContentAttr(this._temporaryContentNode.innerHTML);
			}
			else {
				if(typeof(dijit.byId(this._temporaryContentNode.firstChild.id))=='undefined') {
					this._setContentAttr(this._temporaryContentNode.innerHTML);
				}
				else {
					this._setContentAttr(dijit.byId(this._temporaryContentNode.firstChild.id).domNode);
				}
			}
		}
	},

	resize: function(size) {

		this.inherited(arguments);

		var padding = 20; // TODO: this is a temporary fix, the value of padding has to be taken from styles
		dojo.style(this.container, 'left', padding + 'px');
		dojo.style(this.container, 'top', padding + 'px');
		dojo.style(this.container, 'width', (size.w - 2*padding) + 'px');
		dojo.style(this.container, 'height', (size.h - 2*padding) + 'px');
	},

	frame: function(show) {

		if(show === true) {
			dojo.addClass(this._content.domNode, 'lsContentFrame');
		}
		else {
			dojo.removeClass(this._content.domNode, 'lsContentFrame');
		}
	},

	onReady: function() {

		dojo.style(this.container, 'display', 'block');
	},

	onMessage: function(msg) {

		if(typeof(msg.action) != 'undefined') {
			if(msg.action == 'frame') {
				this[msg.action](msg.arguments[0] == 'show');
			}
		}
	},

	_setContentAttr: function(/*Any*/content) {

		this._content.attr('content', content);
	}

});

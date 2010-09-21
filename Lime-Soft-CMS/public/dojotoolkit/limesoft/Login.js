dojo.provide('limesoft.Login');

dojo.require('dijit._Templated');
dojo.require('dijit.form.Button');
dojo.require('dijit.form.TextBox');
dojo.require('limesoft._Widget');

dojo.declare('limesoft.Login', [limesoft._Widget, dijit._Templated], {

	topic: limesoft.topic.login,

	templateString: dojo.cache('limesoft', 'templates/Login.html'),

	widgetsInTemplate: true,

	buildRendering: function() {

		this.inherited(arguments);

		dojo.connect(this.buttonNode, 'onClick', this, '_login');
	},

	show: function() {

		dojo.publish(limesoft.topic.header, [{ show: 'navigation', options: { text: 'Go to the home page', url: limesoft.url.home } }]);
		dojo.publish(limesoft.topic.header, [{ hide: 'user' }]);
		dojo.publish(limesoft.topic.content, [{ action: 'frame', arguments: ['hide'] }]);

		dojo.style(this.container, 'display', 'block');
	},

	hide: function() {

		dojo.style(this.container, 'display', 'none');

		dojo.publish(limesoft.topic.header, [{ hide: 'navigation' }]);
		dojo.publish(limesoft.topic.header, [{ show: 'user' }]);
		dojo.publish(limesoft.topic.content, [{ action: 'frame', arguments: ['show'] }]);
	},

	login: function(username, password) {

		limesoft.system.login(username, password);
	},

	logout: function() {

		limesoft.system.logout();
	},

	validate: function() {
		var username = this.usernameNode.get('value');
		var password = this.passwordNode.get('value');
		if(!this._isValid(username, password)) {
			// TODO
		}
	},

	onMessage: function(msg) {

		if(typeof(msg.action) != 'undefined') {
			this[msg.action]();
		}
	},

	onLogin: function() {
	},

	onLogout: function() {
	},

	_login: function() {

		var username = this.usernameNode.get('value');
		var password = this.passwordNode.get('value');
		if(this._isValid(username, password)) {
			this.login(username, password);
		}
	},

	_isValid: function(username, password) {

		return !(''==username || ''==password);
	},

	_onKeyPress: function(event) {

		if(event.charOrCode==13) {
			this._login();
		}
	}

});

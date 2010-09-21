dojo.provide('limesoft.Header');

dojo.require('dijit._Templated');
dojo.require('limesoft._Widget');

dojo.declare('limesoft.Header', [limesoft._Widget, dijit._Templated], {

	topic: limesoft.topic.header,

	templateString: dojo.cache('limesoft', 'templates/Header.html'),

	widgetsInTemplate: true,

	navigation: function(show, options) {

		if(typeof(options) != 'undefined') {
			dojo.query('*', this.navigationNode).forEach(function(node) {
				if(dojo.hasClass(node, 'lsNavigationText')) {
					node.innerHTML = options.text;
				}
			});
			dojo.connect(this.navigationNode, 'onclick', null, function() {
				window.location = limesoft.url.home;
			});
		}
		dojo.style(this.navigationNode, 'display', show ? 'block' : 'none');
	},

	user: function(show) {

		var username = limesoft.system.get('username');
		dojo.style(this.userNode, 'display', show ? 'block' : 'none');
		dojo.query('*', this.userNode).forEach(function(node) {
			if(dojo.hasClass(node, 'lsUserName')) {
				node.innerHTML = 'Hello, <b>' + (username || 'guest') + '</b>';
			}
			else if(dojo.hasClass(node, 'lsUserInfo')) {
				node.innerHTML = (username == '' ? 'Log-in' : 'Log-out');
				dojo.connect(node, 'onclick', null, function() {
					window.location = (username == '' ? limesoft.system.getLoginUrl() : limesoft.system.getLogoutUrl());
				});
			}
		});
	},

	onReady: function() {

		if(typeof(this._display_user) == 'undefined' || this._display_user) {
			this.user(true);
		}

		dojo.style(this.container, 'display', 'block');
	},

	onMessage: function(msg) {

		if(typeof(msg.show) != 'undefined') {
			this['_display_' + msg.show] = true;
			this[msg.show](true, msg.options);
		}
		else if(typeof(msg.hide) != 'undefined') {
			this['_display_' + msg.hide] = false;
			this[msg.hide](false);
		}
	}

});

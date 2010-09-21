dojo.provide('limesoft.system');

dojo.require('dojox.rpc.JsonRPC');
dojo.require('dojox.rpc.Service');
dojo.require('limesoft.base');

dojo.declare('limesoft.system', dijit._Widget, {

	username: '',

	_authUrl: null,

	_authService: null,

	_loginUrl: null,

	_logoutUrl: null,

	constructor: function() {

		this._authUrl = limesoft.url.services.authentication;
		this._loginUrl = limesoft.url.login;
		this._logoutUrl = limesoft.url.logout;
	},

	getLoginUrl: function() {

		return this._loginUrl;
	},

	getLogoutUrl: function() {

		return this._logoutUrl;
	},

	login: function(username, password) {

		if(this._authService == null) {
			this._connectLoginService();
		}

		var self = this;
		this._authService.login(username, password)
			.addCallback(function(result) {
				if(result==true) {
					self.onLogin();
				}
			})
			.addErrback(function(result) {
				console.error(result);
			});
	},

	logout: function() {

		if(this._authService == null) {
			this._connectLoginService();
		}

		var self = this;
		this._authService.logout()
			.addCallback(function(result) {
				self.onLogout();
			})
			.addErrback(function(result) {
				console.error(result);
			});
	},

	onLogin: function() {

		window.location = limesoft.baseUrl;
	},

	onLogout: function() {
	},

	_connectLoginService: function() {

		this._authService = new dojox.rpc.Service(this._authUrl);
	}

});

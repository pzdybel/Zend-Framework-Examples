dojo.provide('limesoft.base');

dojo.require('limesoft.system');

(function() {

	// set base URL
	var end = dojo.baseUrl.indexOf('dojotoolkit');
	limesoft.baseUrl = dojo.baseUrl.substring(0, end);

	// set topics
	limesoft.topic = {
		ready: 'ready', // Dojo Toolkit has been loaded
		header: 'header', // limesoft.Header
		content: 'content', // limesoft.Content
		footer: 'footer', // limesoft.Footer
		login: 'login' // limesoft.Login
	};

	// set URL's
	limesoft.url = {
		home: limesoft.baseUrl,
		login: limesoft.baseUrl + 'authentication/login',
		logout: limesoft.baseUrl + 'authentication/logout',
		services: {
			authentication: limesoft.baseUrl + 'services/authentication'
		}
	};

	// run on load
	dojo.addOnLoad(function() {
		limesoft.system = new limesoft.system();
		limesoft.Login = new limesoft.Login();
	});

})();

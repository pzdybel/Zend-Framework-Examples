dojo.provide('limesoft._Widget');

dojo.require('dijit._Widget');

dojo.declare('limesoft._Widget', dijit._Widget, {

	topic: '',

	postCreate: function() {

		this.inherited(arguments);

		var self = this;
		dojo.subscribe(limesoft.topic.ready, function() {
			self.onReady();
		});
		dojo.subscribe(this.topic, function(message) {
			self.onMessage(message);
		});
	},

	onReady: function() {

		// This must remain empty.
	},

	onMessage: function(msg) {

		// This must remain empty.
	}

});

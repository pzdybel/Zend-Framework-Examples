dependencies = {

	layers: [
		{
			name: 'dojo.js',
			dependencies: [
				'dijit.layout.BorderContainer',
				'dijit.layout.ContentPane',
				'limesoft.base',
				'limesoft.Header',
				'limesoft.Content',
				'limesoft.Footer',
				'limesoft.Login'
			]
		}
	],

	prefixes: [
		[ 'dijit', '../dijit' ],
		[ 'dojox', '../dojox' ],
		[ 'limesoft', '../limesoft' ]
	]

};

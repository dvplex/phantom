let mix = require('laravel-mix');
mix.styles([__dirname+'/Resources/assets/css/*.css'],
	'public/css/Modules/Users/after.css'
)
	.combine([__dirname+'/Resources/assets/js/*.js'],
	'public/js/Modules/Users/after.js'
)

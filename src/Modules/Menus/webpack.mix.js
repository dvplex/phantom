let mix = require('laravel-mix');
mix.styles([__dirname+'/Resources/assets/css/*.css'],
	'public/css/Modules/Menus/after.css'
)
	.combine([__dirname+'/Resources/assets/js/*.js'],
	'public/js/Modules/Menus/after.js'
).vue()

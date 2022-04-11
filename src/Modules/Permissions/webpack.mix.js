let mix = require('laravel-mix');
mix.styles([__dirname+'/Resources/assets/css/*.css'],
	'public/css/Modules/Permissions/after.css'
)
	.combine([__dirname+'/Resources/assets/js/*.js'],
	'public/js/Modules/Permissions/after.js'
).vue()

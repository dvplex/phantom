let mix = require('laravel-mix');
mix.styles([__dirname+'/Resources/assets/css/*.css'],
	'public/css/Modules/Roles/after.css'
)
	.combine([__dirname+'/Resources/assets/js/*.js'],
	'public/js/Modules/Roles/after.js'
).vue()

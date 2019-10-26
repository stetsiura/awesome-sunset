<h1>Настройка темы</h1>
<?php settings_errors(); ?>

<form method="post" action="options.php" class="sunset-general-form">
	<?php settings_fields( 'sunset-theme-support' ); ?>
	<?php do_settings_sections( 'awesome_sunset_theme' ); ?>
	<?php submit_button(); ?>
</form>
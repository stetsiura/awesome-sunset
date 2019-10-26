<?php

/*
	
@package sunsettheme
	
	========================
		ADMIN PAGE
	========================
*/

function sunset_add_admin_page() {
	
	//Generate Sunset Admin Page
	add_menu_page( 'Sunset Theme Options', 'Sunset', 'manage_options', 'awesome_sunset', 'sunset_theme_create_page', get_template_directory_uri() . '/img/sunset-icon.png', 110 );
	
	//Generate Sunset Admin Sub Pages
	add_submenu_page( 'awesome_sunset', 'Боковая панель', 'Боковая панель', 'manage_options', 'awesome_sunset', 'sunset_theme_create_page' );
	add_submenu_page( 'awesome_sunset', 'Настройки темы', 'Настройки темы', 'manage_options', 'awesome_sunset_theme', 'sunset_theme_support_page' );
	add_submenu_page( 'awesome_sunset', 'Контактная форма', 'Контактная форма', 'manage_options', 'awesome_sunset_theme_contact', 'sunset_contact_form_page' );
	add_submenu_page( 'awesome_sunset', 'Настройки CSS', 'Настройки CSS', 'manage_options', 'awesome_sunset_css', 'sunset_theme_settings_page');
	
}
add_action( 'admin_menu', 'sunset_add_admin_page' );

//Activate custom settings
add_action( 'admin_init', 'sunset_custom_settings' );

function sunset_custom_settings() {
	//Sidebar Options
	register_setting( 'sunset-settings-group', 'profile_picture' );
	register_setting( 'sunset-settings-group', 'first_name' );
	register_setting( 'sunset-settings-group', 'last_name' );
	register_setting( 'sunset-settings-group', 'user_description' );
	register_setting( 'sunset-settings-group', 'twitter_handler', 'sunset_sanitize_twitter_handler' );
	register_setting( 'sunset-settings-group', 'facebook_handler' );
	register_setting( 'sunset-settings-group', 'gplus_handler' );
	
	add_settings_section( 'sunset-sidebar-options', 'Боковая панель', 'sunset_sidebar_options', 'awesome_sunset');
	
	add_settings_field( 'sidebar-profile-picture', 'Аватарка', 'sunset_sidebar_profile', 'awesome_sunset', 'sunset-sidebar-options');
	add_settings_field( 'sidebar-name', 'Имя и фамилия', 'sunset_sidebar_name', 'awesome_sunset', 'sunset-sidebar-options');
	add_settings_field( 'sidebar-description', 'Описание', 'sunset_sidebar_description', 'awesome_sunset', 'sunset-sidebar-options');
	add_settings_field( 'sidebar-twitter', 'Twitter', 'sunset_sidebar_twitter', 'awesome_sunset', 'sunset-sidebar-options');
	add_settings_field( 'sidebar-facebook', 'Facebook', 'sunset_sidebar_facebook', 'awesome_sunset', 'sunset-sidebar-options');
	//add_settings_field( 'sidebar-gplus', 'Google+ handler', 'sunset_sidebar_gplus', 'awesome_sunset', 'sunset-sidebar-options');
	
	//Theme Support Options
	register_setting( 'sunset-theme-support', 'post_formats' );
	register_setting( 'sunset-theme-support', 'custom_header' );
	register_setting( 'sunset-theme-support', 'custom_background' );
	
	add_settings_section( 'sunset-theme-options', 'Настройки темы', 'sunset_theme_options', 'awesome_sunset_theme' );
	
	add_settings_field( 'post-formats', 'Форматы записей', 'sunset_post_formats', 'awesome_sunset_theme', 'sunset-theme-options' );
	add_settings_field( 'custom-header', 'Пользовательский заголовок', 'sunset_custom_header', 'awesome_sunset_theme', 'sunset-theme-options' );
	add_settings_field( 'custom-background', 'Пользовательский фон', 'sunset_custom_background', 'awesome_sunset_theme', 'sunset-theme-options' );
	
	//Contact Form Options
	register_setting( 'sunset-contact-options', 'activate_contact' );
	
	add_settings_section( 'sunset-contact-section', 'Контактная форма', 'sunset_contact_section', 'awesome_sunset_theme_contact');
	
	add_settings_field( 'activate-form', 'Активировать контактную форму', 'sunset_activate_contact', 'awesome_sunset_theme_contact', 'sunset-contact-section' );
	
	//Custom CSS Options
	register_setting( 'sunset-custom-css-options', 'sunset_css', 'sunset_sanitize_custom_css' );
	
	add_settings_section( 'sunset-custom-css-section', 'Настройки CSS', 'sunset_custom_css_section_callback', 'awesome_sunset_css' );
	
	add_settings_field( 'custom-css', 'Добавьте свои првила CSS', 'sunset_custom_css_callback', 'awesome_sunset_css', 'sunset-custom-css-section' );
	
}

function sunset_custom_css_section_callback() {
	echo 'Настройте тему с добавлением пользовательского CSS';
}

function sunset_custom_css_callback() {
	$css = get_option( 'sunset_css' );
	$css = ( empty($css) ? '/* Sunset Theme Custom CSS */' : $css );
	echo '<div id="customCss">'.$css.'</div><textarea id="sunset_css" name="sunset_css" style="display:none;visibility:hidden;">'.$css.'</textarea>';
}

function sunset_theme_options() {
	echo 'Активация и деактивация возможностей темы';
}

function sunset_contact_section() {
	echo 'Активация и деактивация контактной формы';
}

function sunset_activate_contact() {
	$options = get_option( 'activate_contact' );
	$checked = ( @$options == 1 ? 'checked' : '' );
	echo '<label><input type="checkbox" id="activate_contact" name="activate_contact" value="1" '.$checked.' /></label>';
}

function sunset_post_formats() {
	$options = get_option( 'post_formats' );
	$formats = array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' );
	$output = '';
	foreach ( $formats as $format ){
		$checked = ( @$options[$format] == 1 ? 'checked' : '' );
		$output .= '<label><input type="checkbox" id="'.$format.'" name="post_formats['.$format.']" value="1" '.$checked.' /> '.$format.'</label><br>';
	}
	echo $output;
}

function sunset_custom_header() {
	$options = get_option( 'custom_header' );
	$checked = ( @$options == 1 ? 'checked' : '' );
	echo '<label><input type="checkbox" id="custom_header" name="custom_header" value="1" '.$checked.' /> Активировать пользовательский заголовок</label>';
}

function sunset_custom_background() {
	$options = get_option( 'custom_background' );
	$checked = ( @$options == 1 ? 'checked' : '' );
	echo '<label><input type="checkbox" id="custom_background" name="custom_background" value="1" '.$checked.' /> Активировать пользовательский фон</label>';
}

// Sidebar Options Functions
function sunset_sidebar_options() {
	echo 'Настройте информацию на боковой панели';
}

function sunset_sidebar_profile() {
	$picture = esc_attr( get_option( 'profile_picture' ) );
	if( empty($picture) ){
		echo '<button type="button" class="button button-secondary" value="Загрузить фотографию" id="upload-button"><span class="sunset-icon-button dashicons-before dashicons-format-image"></span> Загрузить фотографию</button><input type="hidden" id="profile-picture" name="profile_picture" value="" />';
	} else {
		echo '<button type="button" class="button button-secondary" value="Заменить фотографию" id="upload-button"><span class="sunset-icon-button dashicons-before dashicons-format-image"></span> Заменить фотографию</button><input type="hidden" id="profile-picture" name="profile_picture" value="'.$picture.'" /> <button type="button" class="button button-secondary" value="Удалить" id="remove-picture"><span class="sunset-icon-button dashicons-before dashicons-no"></span> Удалить</button>';
	}
	
}
function sunset_sidebar_name() {
	$firstName = esc_attr( get_option( 'first_name' ) );
	$lastName = esc_attr( get_option( 'last_name' ) );
	echo '<input type="text" name="first_name" value="'.$firstName.'" placeholder="First Name" /> <input type="text" name="last_name" value="'.$lastName.'" placeholder="Last Name" />';
}
function sunset_sidebar_description() {
	$description = esc_attr( get_option( 'user_description' ) );
	echo '<input type="text" name="user_description" value="'.$description.'" placeholder="Description" /><p class="description">Напишите что-то интересное.</p>';
}
function sunset_sidebar_twitter() {
	$twitter = esc_attr( get_option( 'twitter_handler' ) );
	echo '<input type="text" name="twitter_handler" value="'.$twitter.'" placeholder="Twitter handler" /><p class="description">Введите Ваш логин Twitter без символа @.</p>';
}
function sunset_sidebar_facebook() {
	$facebook = esc_attr( get_option( 'facebook_handler' ) );
	echo '<input type="text" name="facebook_handler" value="'.$facebook.'" placeholder="Facebook handler" />';
}
function sunset_sidebar_gplus() {
	$gplus = esc_attr( get_option( 'gplus_handler' ) );
	echo '<input type="text" name="gplus_handler" value="'.$gplus.'" placeholder="Google+ handler" />';
}

//Sanitization settings
function sunset_sanitize_twitter_handler( $input ){
	$output = sanitize_text_field( $input );
	$output = str_replace('@', '', $output);
	return $output;
}

function sunset_sanitize_custom_css( $input ){
	$output = esc_textarea( $input );
	return $output;
}

//Template submenu functions
function sunset_theme_create_page() {
	require_once( get_template_directory() . '/inc/templates/sunset-admin.php' );
}

function sunset_theme_support_page() {
	require_once( get_template_directory() . '/inc/templates/sunset-theme-support.php' );
}

function sunset_contact_form_page() {
	require_once( get_template_directory() . '/inc/templates/sunset-contact-form.php' );
}

function sunset_theme_settings_page() {
	require_once( get_template_directory() . '/inc/templates/sunset-custom-css.php' );
}



















<?php
 /* 
 * Retrieve this value with:
 * $_wrabbitc_settings = get_option( 'wrabbitc_connection_settings' ); 		// Array of All Options
 * $checkbox = $_wrabbitc_settings['checkbox']; 							// checkbox
 * $queue_name = $_wrabbitc_settings['queue_name']; 						// queue_name
 * $exange_name = $_wrabbitc_settings['exange_name']; 						// exange_name
 * $routing_key = $_wrabbitc_settings['routing_key'];						// routing_key
 * $host = $_wrabbitc_settings['host']; 									// host
 * $vhost = $_wrabbitc_settings['vhost']; 									// vhost
 * $port = $_wrabbitc_settings['port']; 									// port
 * $user = $_wrabbitc_settings['user']; 									// user
 * $password = $_wrabbitc_settings['password']; 							// password
 * $amqp_uri = $_wrabbitc_settings['amqp_uri']; 							// amqp_uri
 */

class WrabbitcSettings {
	private $_wrabbitc_settings;
	/**
	 * Costruttore che aggiunge delle chiamate a funzione per un determinato hook di wordpress.
	 * gli hook sostanziamente sono delle callback (defenite in wordpress ma posso essere estese)
	 * al verificarsi delle quali verrà eseguita la funzione che ci abbiamo registrato.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'wrabbit_register_settings_page' ) );
		add_action( 'admin_init', array( $this, 'wrabbit_register_settings_fields' ) );		
	}
	/**
	 * Metodo che tramite hook 'admin_menu' registra una pagina nella sezione amministrazione ed 
	 * eventuali sotto pagine
	 */
	public function wrabbit_register_settings_page() {
		add_menu_page(
			'WRabbitC', 														// page_title
			'WRabbitC', 														// menu_title
			'manage_options', 													// capability
			'wrabbitc-settings', 												// menu_slug
			array( $this, 'main_page' ), 										// function
			'dashicons-carrot', 												// icon_url
			100 																// position
		);

		add_submenu_page( 
			'wrabbitc-settings', 												// parent menu_slug
			'WRabbitC Connection Settings', 									//Submenu Page Title
			'Connection Settings', 												//Menu subsection Title
			'manage_options', 													//capability
			'wrabbitc-connection-settings', 									//this menu-slug
			array($this, 'connection_page')										//funcrion optional
		);
		/*add_submenu_page( 'wrabbitc-settings', 'WRabbitC Sender', 'Messages Sender', 
		'manage_options', 'wrabbitc-producer', array($this, 'sender_page'));*/
	}

	public function main_page()
	{
		$plugin_info =get_plugin_data(plugin_dir_path( __FILE__ ).'wrabbitc.php');

		echo '
		<div class="wp-caption aligncenter">
			<h3 class"align-center">Welcome to '.$plugin_info['Name'].',</h3>
			<div>
				<img src="'.plugins_url('wrabbitc/img/',__DIR__).'rabbit_chair.gif" width="200" height="200" align="left">
				<img src="'.plugins_url('wrabbitc/img/',__DIR__).'butterfly.gif" width="150" align="right">
				<p>this plugin, allows sending data to a RabbitMQ broker. <br>
				At the moment data sending is supported through a pre-set form that can be obtained 
				by adding the shortcode [wrabbitc-sc] in any page or article.
				</p><hr>
				<h3>some info on the project:</h3>
				WordPress RabbitMQ Connector is a plugin developed during my degree thesis in Computer Science, 
				as part of a larger project called "Project Alice" whose goal is to automate the work of the "boys" 
				of the BioInformatics laboratory of Salerno.<br>
				At present ( v '.$plugin_info['Version'].' ) , due to time constraints, the plugin only supports the sending of data and not the reception, 
				which in any case I intend to implement in the future. <br>
				It should be noted that as a projective choice in order to create the lowest possible code coupling, 
				<b>the producer sends the data to an Exange</b> 
				(in the code there is a commented section that also allows the direct sending on a queue, 
				left to help those wishing to extend my work) through a static form created following for the laboratory request, 
				in the design phase I followed the idea of ​​being able to extend this form in the future and 
				make it customizable by the web master who will install my plugin. Among my future goals is 
				the complete drafting of the code which will lead to a total two-way communication with RabbitMQ, 
				preserving the asynchronous nature of the amqp protocol and still releasing the source code under the GNU GPL v3 license.
				Anyone wishing to help or contact me, can do it at the project\'s <a href="https://github.com/pasmimmo/WRabbitC">Github repo</a>.<hr>
				I conclude this lengthy introduction by thanking the whole team of the BioInformatics Laboratory, 
				whose precious collaboration has made me grow so much from a professional point of view, 
				the people who have reported me bugs helping me to make my code less disgusting, 
				and the friends of all time who supported me during this time.
				Thanks from <b>Pasmimmo</b>.</p>
			</div>
		<div>';
	}

	public function connection_page() {
		/* Otteniamo i valori dal database qualora ce ne fossero */
		$this->_wrabbitc_settings = get_option( 'wrabbitc_connection_settings' );
		/* aggiungiamo il nostro codice css e javascript con le funzioni wp_equeue_syle() e wp_enqueue_script*/
		wp_enqueue_style('settings_css' , plugins_url().'/wrabbitc/css/settings.css' );
		wp_enqueue_script('settings_script' , plugins_url().'/wrabbitc/js/wrabbitc_settings_script.js' );
		?>

		<div class="wrap">
			<?php 
			settings_errors();
			?>
			
			<form method="post" action="options.php">
				<?php
					settings_fields( 'wrabbitc_connection_settings' );
					do_settings_sections( 'wrabbitc-connection-settings' );
				?>
				<div id="wrabbitc_manual_setting">
				<?php do_settings_sections( 'wrabbitc-manual-connection-settings' ); ?>
				</div>
				<div id="wrabbitc_amqp_uri" style="display: none;">
				<?php do_settings_sections( 'wrabbitc-amqp-connection-settings' ); ?>
				</div>
				<?php submit_button();?>
			</form>

		<?php 
	}

	public function sender_page(){
		echo '
		<div class="wp-caption">
		<img src="'.plugins_url('wrabbitc/img/',__DIR__).'rabbit_chair.gif" width="200" height="200" align="right">
		<p>We are sorry but at the moment sending messages is allowed only through preconfigured form,
		you can use it inserting the shortcode [wrabbitc-sc] on any page or article.<p>
		</div>
		';
	}

	public function connection_section_general(){
		echo '	<div class="wp-caption">
					You can use following fields to setUp your Connection
				</div>
		';
	}

	public function connection_section_manual(){/*NOOP Callback */}

	public function connection_section_amqp_uri(){/*NOOP Callback */}

	public function wrabbit_register_settings_fields() {
		register_setting(
			'wrabbitc_connection_settings',							// option_group
			'wrabbitc_connection_settings',							// option_name
			array( $this, 'wrabbitc_settings_sanitize' ) 			// sanitize_callback
		);
		//General Connection Section
		add_settings_section(
			'wrabbitc_connection', 									// id
			'WRabbitC Connection Settings', 						// title
			array( $this, 'connection_section_general' ), 			// callback
			'wrabbitc-connection-settings' 							// page
		);
		/*
		add_settings_field(
			'checkbox', 											// id
			'use Exange instead of queue', 							// title
			array( $this, 'checkbox_callback' ), 					// callback
			'wrabbitc-connection-settings', 						// page
			'wrabbitc_connection'	 								// section
		);

		add_settings_field(
			'queue_name', 											// id
			'Queue Name: ', 										// title
			array( $this, 'queue_name_callback' ), 					// callback
			'wrabbitc-connection-settings', 						// page
			'wrabbitc_connection'									// section
		);*/

		add_settings_field(
			'exange_name', 											// id
			'Exange Name: ', 										// title
			array( $this, 'exange_name_callback' ), 				// callback
			'wrabbitc-connection-settings', 						// page
			'wrabbitc_connection'									// section
		);

		add_settings_field(
			'routing_key', 											// id
			'Routing key: ', 										// title
			array( $this, 'routing_key_callback' ), 				// callback
			'wrabbitc-connection-settings', 						// page
			'wrabbitc_connection'									// section
		);
		// Manual URL Section
		add_settings_section(
			'wrabbitc_manual_url_settings', 						// id
			'Manual Settings', 										// title
			array( $this, 'connection_section_manual' ), 			// callback
			'wrabbitc-manual-connection-settings' 					// page
		);

		add_settings_field(
			'host', 												// id
			'Host: ', 												// title
			array( $this, 'host_callback' ), 						// callback
			'wrabbitc-manual-connection-settings', 					// page
			'wrabbitc_manual_url_settings' 							// section
		);

		add_settings_field(
			'vhost', 												// id
			'VHost: ', 												// title
			array( $this, 'vhost_callback' ), 						// callback
			'wrabbitc-manual-connection-settings', 					// page
			'wrabbitc_manual_url_settings' 							// section
		);

		add_settings_field(
			'port', 												// id
			'Port: ', 												// title
			array( $this, 'port_callback' ), 						// callback
			'wrabbitc-manual-connection-settings', 					// page
			'wrabbitc_manual_url_settings' 							// section
		);


		add_settings_field(
			'user', 												// id
			'User: ',												// title
			array( $this, 'user_callback' ), 						// callback
			'wrabbitc-manual-connection-settings', 					// page
			'wrabbitc_manual_url_settings' 							// section
		);

		add_settings_field(
			'password', 											// id
			'Password: ', 											// title
			array( $this, 'password_callback' ), 					// callback
			'wrabbitc-manual-connection-settings', 					// page
			'wrabbitc_manual_url_settings' 							// section
		);
		//AMQP URI Section
		/*add_settings_section(
			'wrabbitc_amqp_uri_settings', 							// id
			'AMQP URI Settings', 									// title
			array( $this, 'connection_section_amqp_uri' ), 			// callback
			'wrabbitc-amqp-connection-settings' 					// page
		);

		add_settings_field(
			'amqp_uri', 											// id
			'AMQP URI: ', 											// title
			array( $this, 'amqp_callback' ), 						// callback
			'wrabbitc-amqp-connection-settings', 					// page
			'wrabbitc_amqp_uri_settings' 							// section
		);*/

	}

	public function wrabbitc_settings_sanitize($input) {
		$sanitary_values = array();
		/*General Section
		if ( isset( $input['checkbox'] ) ) {
			$sanitary_values['checkbox'] = $input['checkbox'];
		}

		if ( isset( $input['queue_name'] ) ) {
			$sanitary_values['queue_name'] = sanitize_text_field( $input['queue_name'] );
		}*/

		if ( isset( $input['exange_name'] ) ) {
			$sanitary_values['exange_name'] = sanitize_text_field( $input['exange_name'] );
		}

		if ( isset( $input['routing_key'] ) ) {
			$sanitary_values['routing_key'] = sanitize_text_field( $input['routing_key'] );
		}

		//Manual Section
		if ( isset( $input['host'] ) ) {
			$sanitary_values['host'] = sanitize_text_field( $input['host'] );
		}

		if ( isset( $input['vhost'] ) ) {
			$sanitary_values['vhost'] = sanitize_text_field( $input['vhost'] );
		}

		if ( isset( $input['port'] ) ) {
			$sanitary_values['port'] = sanitize_text_field( $input['port'] );
		}

		if ( isset( $input['user'] ) ) {
			$sanitary_values['user'] = sanitize_text_field( $input['user'] );
		}

		if ( isset( $input['password'] ) ) {
			$sanitary_values['password'] = sanitize_text_field( $input['password'] );
		}

		/*AMQP URI Section
		if ( isset( $input['amqp_uri'] ) ) {
			$sanitary_values['amqp_uri'] = esc_url_raw( $input['amqp_uri'] );
		}*/

		return $sanitary_values;
	}
	//Forms Callback
/*
	public function checkbox_callback() {
		printf(
			'<label class="switch">
			<input type="checkbox" name="wrabbitc_connection_settings[checkbox]" id="checkbox" value="checkbox" %s> 
			<span class="slider round" id="slider_round" onclick="uriSelector()"></span>
			</label>',
			( isset( $this->_wrabbitc_settings['checkbox'] ) && $this->_wrabbitc_settings['checkbox'] === 'checkbox' ) ? 'checked' : ''
		);
	}

	public function queue_name_callback() {
		printf(
			'<input class="regular-text" type="text" name="wrabbitc_connection_settings[queue_name]" id="queue_name" value="%s" placeholder="es myQueue">',
			isset( $this->_wrabbitc_settings['queue_name'] ) ? esc_attr( $this->_wrabbitc_settings['queue_name']) : ''
		);
	}*/

	public function exange_name_callback() {
		printf(
			'<input class="regular-text" type="text" name="wrabbitc_connection_settings[exange_name]" id="exange_name" value="%s" placeholder="usually same as queue name">',
			isset( $this->_wrabbitc_settings['exange_name'] ) ? esc_attr( $this->_wrabbitc_settings['exange_name']) : ''
		);
	}

	public function routing_key_callback() {
		printf(
			'<input class="regular-text" type="text" name="wrabbitc_connection_settings[routing_key]" id="routing_key" value="%s" placeholder="leave blank for default">',
			isset( $this->_wrabbitc_settings['routing_key'] ) ? esc_attr( $this->_wrabbitc_settings['routing_key']) : ''
		);
	}

	public function host_callback() {
		printf(
			'<input class="regular-text" type="text" name="wrabbitc_connection_settings[host]" id="host" value="%s" placeholder="es myhost.provider.com">',
			isset( $this->_wrabbitc_settings['host'] ) ? esc_attr( $this->_wrabbitc_settings['host']) : ''
		);
	}

	public function vhost_callback() {
		printf(
			'<input class="regular-text" type="text" name="wrabbitc_connection_settings[vhost]" id="host" value="%s" placeholder="your vHost">',
			isset( $this->_wrabbitc_settings['vhost'] ) ? esc_attr( $this->_wrabbitc_settings['vhost']) : ''
		);
	}

	public function port_callback() {
		printf(
			'<input class="regular-text" type="number" name="wrabbitc_connection_settings[port]" id="port" value="%s" placeholder="es 5672">',
			isset( $this->_wrabbitc_settings['port'] ) ? esc_attr( $this->_wrabbitc_settings['port']) : ''
		);
	}

	public function user_callback() {
		printf(
			'<input class="regular-text" type="text" name="wrabbitc_connection_settings[user]" id="user" value="%s" placeholder="your username">',
			isset( $this->_wrabbitc_settings['user'] ) ? esc_attr( $this->_wrabbitc_settings['user']) : ''
		);
	}

	public function password_callback() {
		printf(
			'<input class="regular-text" type="text" name="wrabbitc_connection_settings[password]" id="password" value="%s" placeholder="your password">',
			isset( $this->_wrabbitc_settings['password'] ) ? esc_attr( $this->_wrabbitc_settings['password']) : ''
		);
	}
/*
	public function amqp_callback(){
		printf(
			'<input class="regular-text" type="text" name="wrabbitc_connection_settings[amqp_uri]" id="amqp_uri" value="%s" placeholder="something like amqp://user:pass@host:10000/vhost">',
			isset( $this->_wrabbitc_settings['amqp_uri'] ) ? esc_attr( $this->_wrabbitc_settings['amqp_uri']) : ''
		);
	}

	Onestamente non ho capito a che serve per cui la lascio commentata
	public function wrabbitc_settings_link( $links ) {
		$links[] = '<a href="' .
			admin_url( 'options-general.php?page=wrabbitc-settings' ) .
			'">' . __('Settings') . '</a>';
		return $links;
	}*/

}

?>
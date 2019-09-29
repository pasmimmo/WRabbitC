<?php
class ShortCodes{
    public function __construct() {
        //carico gli script
        add_action( 'wp_enqueue_scripts', array($this,'script_loader') );
        //aggiungo lo shortcode
        add_shortcode( 'wrabbitc-sc', array( $this, 'wrabbit_form_shortcode' ) );
        add_action('wp_footer',array($this, 'loading_sc'));
    }

    public function loading_sc(){
        echo '<div class="modal"><!-- Place at bottom of page --></div>';
    }

    public function script_loader() {
        wp_enqueue_style('loading' , plugins_url().'/wrabbitc/css/loading.css' );
        $jsdir = plugins_url('js/',__DIR__);
        //carico gli script
        wp_enqueue_script( 'wrabbitc_formvalidation', $jsdir.'wrabbitc_formvalidation.js', array('jquery'),'1.0.0', true  );
        wp_enqueue_script( 'wrabbitc_elaboration_request', $jsdir.'wrabbitc_wp_ajaxcall.js', array('jquery'), '1.0.0', true );
        //passo i parametri nel namespace del secondo
        wp_localize_script( 'wrabbitc_elaboration_request', 'Wrabbit', array(
            // URL to wp-admin/admin-ajax.php to process the request
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            // generate a nonce with a unique ID "Wrabbit-post-comment-nonce"
            // so that you can check it later when an AJAX request is sent
            'security' => wp_create_nonce( 'my-special-string' )
        ));
    }
    
    public function wrabbit_form_shortcode(){
        return '
        <form id="wrabbit_request_form">
            <table>
                <tr>
                <td><Label>Name: </Label> <input id="wrabbitc_name" type="text" size="82" required></td></tr>
                <tr>
                <td><Label>e-mail: </label> <input type="email" id="wrabbitc_email" size="82" required></tr>
                <tr>
                <td><Label>PDBs: <input type="text" id="wrabbitc_proteins" size="82" placeholder="use add PDBS button" disabled required></tr>
            </table>
            <input type="button" id="btn"  onclick="aggiungiCodici();" value="ADD PDBs"/>
            <input type="submit" value="Send" />
        </form>';
    }
}
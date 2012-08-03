<?php

class SGProMetaboxHelper extends SGProPlugin {

    var $name = 'Metabox';

    function SGProMetaboxHelper() {
        $url = explode("&", $_SERVER['REQUEST_URI']);
        $this->url = $url[0];
    }

    function settings_submit() {
        $this->render('metaboxes' . DS . 'settings-submit', false, true, 'admin');
    }

    function settings_general() {
        $this->render('metaboxes' . DS . 'settings-general', false, true, 'admin');
    }

    function settings_linksimages() {
        $this->render('metaboxes' . DS . 'settings-linksimages', false, true, 'admin');
    }

    function settings_styles() {
        $this->render('metaboxes' . DS . 'settings-styles', false, true, 'admin');
    }

    function settings_pro() {
        $this->render('metaboxes' . DS . 'settings-pro', false, true, 'admin');
    }

}

?>
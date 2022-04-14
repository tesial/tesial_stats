<?php

class Tesial_Stats extends Module
{

    public function __construct()
    {
        $this->name = 'tesial_stats';
        $this->author = 'Tesial';
        $this->version = '1.0.0';
        $this->tab = 'administration';

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = 'Statistics';
        $this->description = 'Statistics for Tesial';
        $this->ps_versions_compliancy = ['min' => '1.6.0.0', 'max' => _PS_VERSION_];
    }

    public function install()
    {
        $this->subscribe();

        return parent::install();
    }

    private function subscribe()
    {
        require_once 'api/Curl.php';

        $api = new Curl();
        $url = Tools::getShopDomainSsl(Tools::usingSecureMode());
        $response = $api->get($url);

        if (false === $response) {
            $data = ['name' => Configuration::get('PS_SHOP_NAME'), 'url' => $url];
            $api->post($data);
        }

    }

}

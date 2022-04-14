<?php
/**
 * 2007-2020 PrestaShop and Contributors.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

class Curl
{
    protected $apiKey;
    protected $ch;
    private $url;

    public function __construct()
    {
        $this->url = 'http://sandbox-debian10.tesial-tech.be/api/websites';

        $this->ch = curl_init($this->url);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    }

    public function post($data)
    {
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($this->ch);

        return $response;
    }

    public function get($websiteUrl)
    {
        $url = 'http://sandbox-debian10.tesial-tech.be/api/websites?pagination=false&url='.$websiteUrl;

        $this->ch = curl_init($url);
        curl_setopt($this->ch, CURLOPT_HTTPGET, true);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($this->ch);
        $httpcode = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);

        if ($httpcode === 404) {
            return false;
        }

        $response = json_decode($response, true);

        if ($response['hydra:totalItems'] === 0) {
            return false;
        }

        return $response;
    }
}

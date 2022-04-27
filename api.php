<?php

require_once __DIR__.'/../../config/config.inc.php';

function getSalesCountByCountry()
{
    $db = Db::getInstance();

    return $db->executeS('
        SELECT c.iso_code, SUM(o.total_paid_real) as total
        FROM '._DB_PREFIX_.'orders o
        LEFT JOIN '._DB_PREFIX_.'address ad ON (o.id_address_delivery = ad.id_address)
        LEFT JOIN '._DB_PREFIX_.'country c USING (id_country)
        WHERE o.valid = 1
        GROUP BY c.id_country
    ');
}

$data = [
    'prestabob' => [
        'version' => _PS_VERSION_,
        'majorVersion' => substr(_PS_VERSION_, 0, 3),
    ],
    'modules' => [
        'payment' => array_values(array_filter(array_column(PaymentModule::getInstalledPaymentModules(), 'name'),
            static function ($moduleName) {
                return strpos($moduleName, 'wpk') !== 0;
            })),
        'carrier' => array_column(CarrierCore::getCarriers(Language::getIdByIso('fr'), true), 'name'),
    ],
    'sales' => getSalesCountByCountry(),
    'server' => [
        'software' => $_SERVER['SERVER_SOFTWARE'],
        'version' => phpversion(),
    ],
];

$data = json_encode($data);

die($data);

<?php
/**
 * PayPal Setting & API Credentials
 * Created by Raza Mehdi <srmk@outlook.com>.
 */

return [
    'client_id' => 'Aa_aQvcVNFGrSCBTNt23PzBt0sVP2KzHJAZz6Z_aUcmLzyBHX6hYxyL0ahVwPVAm1xE_bHTxH5-SoZgm',
	'secret' => 'EA_TVXxBU11AhO2mCmTGoatlHSTA1Pz7PwTryh7kAErZGhc-HovDvDMq-qe5kLcwIiUMjwAkRyJFBmKs',
    'settings' => array(
        'mode' => 'sandbox',
        'http.ConnectionTimeOut' => 45,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        'log.LogLevel' => 'FINE'
    ),
];

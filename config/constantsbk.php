<?php

	define("VISA_DEVELOPMENT", true);

	// Desarrollo Visa
    define('VISA_DEV_MERCHANT_ID', '522591303');
    define('VISA_DEV_USER', 'integraciones.visanet@necomplus.com');
    define('VISA_DEV_PWD', 'd5e7nk$M');
    define('VISA_DEV_URL_SECURITY', 'https://apitestenv.vnforapps.com/api.security/v1/security');
    define('VISA_DEV_URL_SESSION', 'https://apitestenv.vnforapps.com/api.ecommerce/v2/ecommerce/token/session/'.VISA_DEV_MERCHANT_ID);
    define('VISA_DEV_URL_JS', 'https://static-content-qas.vnforapps.com/v2/js/checkout.js?qa=true');
    define('VISA_DEV_URL_AUTHORIZATION', 'https://apitestenv.vnforapps.com/api.authorization/v3/authorization/ecommerce/'.VISA_DEV_MERCHANT_ID);
    
    // Producción Visa
    define('VISA_PRD_MERCHANT_ID', '522591303');
    define('VISA_PRD_USER', 'integraciones.visanet@necomplus.com');
    define('VISA_PRD_PWD', 'd5e7nk$M');
    define('VISA_PRD_URL_SECURITY', 'https://apiprod.vnforapps.com/api.security/v1/security');
    define('VISA_PRD_URL_SESSION', 'https://apiprod.vnforapps.com/api.ecommerce/v2/ecommerce/token/session/'.VISA_PRD_MERCHANT_ID);
    define('VISA_PRD_URL_JS', 'https://static-content.vnforapps.com/v2/js/checkout.js');
    define('VISA_PRD_URL_AUTHORIZATION', 'https://apiprod.vnforapps.com/api.authorization/v3/authorization/ecommerce/'.VISA_PRD_MERCHANT_ID);

	return [
        'SERVICES' => 'https://servicios.munisjl.gob.pe/Services/index.php?wsdl',
		'VISA_MERCHANT_ID' => VISA_DEVELOPMENT ? VISA_DEV_MERCHANT_ID : VISA_PRD_MERCHANT_ID,
		'VISA_USER' => VISA_DEVELOPMENT ? VISA_DEV_USER : VISA_PRD_USER,
		'VISA_PWD' => VISA_DEVELOPMENT ? VISA_DEV_PWD : VISA_PRD_PWD,
		'VISA_URL_SECURITY' => VISA_DEVELOPMENT ? VISA_DEV_URL_SECURITY : VISA_PRD_URL_SECURITY,
		'VISA_URL_SESSION' => VISA_DEVELOPMENT ? VISA_DEV_URL_SESSION : VISA_PRD_URL_SESSION,
		'VISA_URL_JS' => VISA_DEVELOPMENT ? VISA_DEV_URL_JS : VISA_PRD_URL_JS,
		'VISA_URL_AUTHORIZATION' => VISA_DEVELOPMENT ? VISA_DEV_URL_AUTHORIZATION : VISA_PRD_URL_AUTHORIZATION,
	];
?>

<?php

    define("VISA_DEVELOPMENT", true);
    define("OPENPAY_DEVELOPMENT", false);

    // Desarrollo Visa
    define('VISA_DEV_MERCHANT_ID', '522591303');
    define('VISA_DEV_USER', 'integraciones.visanet@necomplus.com');
    define('VISA_DEV_PWD', 'd5e7nk$M');
    define('VISA_DEV_URL_SECURITY', 'https://apitestenv.vnforapps.com/api.security/v1/security');
    define('VISA_DEV_URL_SESSION', 'https://apitestenv.vnforapps.com/api.ecommerce/v2/ecommerce/token/session/'.VISA_DEV_MERCHANT_ID);
    define('VISA_DEV_URL_JS', 'https://static-content-qas.vnforapps.com/v2/js/checkout.js?qa=true');
    define('VISA_DEV_URL_AUTHORIZATION', 'https://apitestenv.vnforapps.com/api.authorization/v3/authorization/ecommerce/'.VISA_DEV_MERCHANT_ID);

    define('OPENPAY_DEV_URL', 'http://localhost:5124/api');
    define('OPENPAY_DEV_PS_LOGIN', OPENPAY_DEV_URL. '/Autenticacion/ps_login');
    define('OPENPAY_DEV_PS_CONTRIBUYENTE', OPENPAY_DEV_URL. '/Contribuyente/ps_contribuyente');
    define('OPENPAY_DEV_PS_CTACTE', OPENPAY_DEV_URL. '/Ctacorriente/ps_ctacte');
    define('OPENPAY_DEV_PS_RECIBOPAGADO', OPENPAY_DEV_URL. '/Caja/ps_recibopagado');
    define('OPENPAY_DEV_PS_REPORTERECIBOPAGO', OPENPAY_DEV_URL. '/Caja/ps_reporterecibopago');
    
    // Producción Visa
    define('VISA_PRD_MERCHANT_ID', '522591303');
    define('VISA_PRD_USER', 'integraciones.visanet@necomplus.com');
    define('VISA_PRD_PWD', 'd5e7nk$M');
    define('VISA_PRD_URL_SECURITY', 'https://apiprod.vnforapps.com/api.security/v1/security');
    define('VISA_PRD_URL_SESSION', 'https://apiprod.vnforapps.com/api.ecommerce/v2/ecommerce/token/session/'.VISA_PRD_MERCHANT_ID);
    define('VISA_PRD_URL_JS', 'https://static-content.vnforapps.com/v2/js/checkout.js');
    define('VISA_PRD_URL_AUTHORIZATION', 'https://apiprod.vnforapps.com/api.authorization/v3/authorization/ecommerce/'.VISA_PRD_MERCHANT_ID);

    define('OPENPAY_PRD_URL', 'http://161.132.169.229:8080/api');
    define('OPENPAY_PRD_PS_LOGIN', OPENPAY_PRD_URL. '/Autenticacion/ps_login');
    define('OPENPAY_PRD_PS_CONTRIBUYENTE', OPENPAY_PRD_URL. '/Contribuyente/ps_contribuyente');
    define('OPENPAY_PRD_PS_CTACTE', OPENPAY_PRD_URL. '/Ctacorriente/ps_ctacte');
    define('OPENPAY_PRD_PS_RECIBOPAGADO', OPENPAY_PRD_URL. '/Caja/ps_recibopagado');
    define('OPENPAY_PRD_PS_REPORTERECIBOPAGO', OPENPAY_PRD_URL. '/Caja/ps_reporterecibopago');

    return [
        'SERVICES' => 'https://servicios.munisjl.gob.pe/Services/index.php?wsdl',
        'PS_LOGIN' => OPENPAY_DEVELOPMENT ? OPENPAY_DEV_PS_LOGIN : OPENPAY_PRD_PS_LOGIN,
        'PS_CONTRIBUYENTE' => OPENPAY_DEVELOPMENT ? OPENPAY_DEV_PS_CONTRIBUYENTE : OPENPAY_PRD_PS_CONTRIBUYENTE,
        'PS_CTACTE' => OPENPAY_DEVELOPMENT ? OPENPAY_DEV_PS_CTACTE : OPENPAY_PRD_PS_CTACTE,
        'PS_RECIBOPAGADO' => OPENPAY_DEVELOPMENT ? OPENPAY_DEV_PS_RECIBOPAGADO : OPENPAY_PRD_PS_RECIBOPAGADO,
        'PS_REPORTERECIBOPAGO' => OPENPAY_DEVELOPMENT ? OPENPAY_DEV_PS_REPORTERECIBOPAGO : OPENPAY_PRD_PS_REPORTERECIBOPAGO,
    ];
?>
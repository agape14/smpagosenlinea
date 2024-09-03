<?php

    define("API_DEVELOPMENT", false);
    define("OPENPAY_DEVELOPMENT", true);

    // Desarrollo OpenPay
    define('OPENPAY_DEV_KEY_ID', 'm0wsltfqgtjt7grkt7tf');
    define('OPENPAY_DEV_KEY_SECRET_USERNAME', 'sk_cfc241cab3684c20ab467baa4d0ccc75');
    define('OPENPAY_DEV_KEY_SECRET_PASSWORD', '');
    define('OPENPAY_DEV_KEY_PUBLIC', 'pk_f8f552394c354c6bbeeb467efc8ade96');
    define('OPENPAY_DEV_URL_BASE', '');
    define('OPENPAY_DEV_URL_CHARGES', 'https://sandbox-api.openpay.pe/v1/'.OPENPAY_DEV_KEY_ID.'/charges');

    // Desarrollo Apis
    define('OPENPAY_DEV_URL', 'http://localhost:5124/api');
    define('OPENPAY_DEV_PS_LOGIN', OPENPAY_DEV_URL. '/Autenticacion/ps_login');
    define('OPENPAY_DEV_PS_CONTRIBUYENTE', OPENPAY_DEV_URL. '/Contribuyente/ps_contribuyente');
    define('OPENPAY_DEV_PS_CTACTE', OPENPAY_DEV_URL. '/Ctacorriente/ps_ctacte');
    define('OPENPAY_DEV_PS_RECIBOPAGADO', OPENPAY_DEV_URL. '/Caja/ps_recibopagado');
    define('OPENPAY_DEV_PS_REPORTERECIBOPAGO', OPENPAY_DEV_URL. '/Caja/ps_reporterecibopago');
    define('OPENPAY_DEV_PI_LIQUIDACION', OPENPAY_DEV_URL. '/Liquidacion/pi_liquidacion');
    define('OPENPAY_DEV_PS_LIQUIDACION', OPENPAY_DEV_URL. '/Liquidacion/ps_liquidacion');
    define('OPENPAY_DEV_PI_PAGOWEB', OPENPAY_DEV_URL. '/Caja/pi_pagoweb');
    define('OPENPAY_DEV_PS_RESUMENPAGOS_REPORTE', OPENPAY_DEV_URL. '/Contribuyente/ps_resumenpagos_reporte');
    define('OPENPAY_DEV_PS_RESUMENPAGOS', OPENPAY_DEV_URL. '/Contribuyente/ps_resumenpagos');
    define('OPENPAY_DEV_PU_CAMBIARPASSWORD', OPENPAY_DEV_URL. '/Contribuyente/pu_cambiarpassword');
    define('OPENPAY_DEV_PS_LIQUIDACIONDETALLE', OPENPAY_DEV_URL. '/Caja/ps_liquidaciondetalle');

    // Producción OpenPay
    define('OPENPAY_PRD_KEY_ID', 'm0wsltfqgtjt7grkt7tf');
    define('OPENPAY_PRD_KEY_SECRET_USERNAME', 'sk_cfc241cab3684c20ab467baa4d0ccc75');
    define('OPENPAY_PRD_KEY_SECRET_PASSWORD', '');
    define('OPENPAY_PRD_KEY_PUBLIC', 'pk_f8f552394c354c6bbeeb467efc8ade96');
    define('OPENPAY_PRD_URL_BASE', '');
    define('OPENPAY_PRD_URL_CHARGES', 'https://sandbox-api.openpay.pe/v1/'.OPENPAY_PRD_KEY_ID.'/charges');

    // Producción Apis
    define('OPENPAY_PRD_URL', 'http://172.50.1.64:8080/api'); //http://161.132.169.229:8080/api
    define('OPENPAY_PRD_PS_LOGIN', OPENPAY_PRD_URL. '/Autenticacion/ps_login');
    define('OPENPAY_PRD_PS_CONTRIBUYENTE', OPENPAY_PRD_URL. '/Contribuyente/ps_contribuyente');
    define('OPENPAY_PRD_PS_CTACTE', OPENPAY_PRD_URL. '/Ctacorriente/ps_ctacte');
    define('OPENPAY_PRD_PS_RECIBOPAGADO', OPENPAY_PRD_URL. '/Caja/ps_recibopagado');
    define('OPENPAY_PRD_PS_REPORTERECIBOPAGO', OPENPAY_PRD_URL. '/Caja/ps_reporterecibopago');
    define('OPENPAY_PRD_PI_LIQUIDACION', OPENPAY_PRD_URL. '/Liquidacion/pi_liquidacion');
    define('OPENPAY_PRD_PS_LIQUIDACION', OPENPAY_PRD_URL. '/Liquidacion/ps_liquidacion');
    define('OPENPAY_PRD_PI_PAGOWEB', OPENPAY_PRD_URL. '/Caja/pi_pagoweb');
    define('OPENPAY_PRD_PS_RESUMENPAGOS_REPORTE', OPENPAY_PRD_URL. '/Contribuyente/ps_resumenpagos_reporte');
    define('OPENPAY_PRD_PS_RESUMENPAGOS', OPENPAY_PRD_URL. '/Contribuyente/ps_resumenpagos');
    define('OPENPAY_PRD_PU_CAMBIARPASSWORD', OPENPAY_PRD_URL. '/Contribuyente/pu_cambiarpassword');
    define('OPENPAY_PRD_PS_LIQUIDACIONDETALLE', OPENPAY_PRD_URL. '/Caja/ps_liquidaciondetalle');

    return [
        'PS_LOGIN' => API_DEVELOPMENT ? OPENPAY_DEV_PS_LOGIN : OPENPAY_PRD_PS_LOGIN,
        'PS_CONTRIBUYENTE' => API_DEVELOPMENT ? OPENPAY_DEV_PS_CONTRIBUYENTE : OPENPAY_PRD_PS_CONTRIBUYENTE,
        'PS_CTACTE' => API_DEVELOPMENT ? OPENPAY_DEV_PS_CTACTE : OPENPAY_PRD_PS_CTACTE,
        'PS_RECIBOPAGADO' => API_DEVELOPMENT ? OPENPAY_DEV_PS_RECIBOPAGADO : OPENPAY_PRD_PS_RECIBOPAGADO,
        'PS_REPORTERECIBOPAGO' => API_DEVELOPMENT ? OPENPAY_DEV_PS_REPORTERECIBOPAGO : OPENPAY_PRD_PS_REPORTERECIBOPAGO,
        'PI_LIQUIDACION' => API_DEVELOPMENT ? OPENPAY_DEV_PI_LIQUIDACION : OPENPAY_PRD_PI_LIQUIDACION,
        'PS_LIQUIDACION' => API_DEVELOPMENT ? OPENPAY_DEV_PS_LIQUIDACION : OPENPAY_PRD_PS_LIQUIDACION,
        'PS_PAGOWEB' => API_DEVELOPMENT ? OPENPAY_DEV_PI_PAGOWEB : OPENPAY_PRD_PI_PAGOWEB,
        'PS_RESUMENPAGOS_REPORTE' => API_DEVELOPMENT ? OPENPAY_DEV_PS_RESUMENPAGOS_REPORTE : OPENPAY_PRD_PS_RESUMENPAGOS_REPORTE,
        'PS_RESUMENPAGOS' => API_DEVELOPMENT ? OPENPAY_DEV_PS_RESUMENPAGOS : OPENPAY_PRD_PS_RESUMENPAGOS,
        'PU_CAMBIARPASSWORD' => API_DEVELOPMENT ? OPENPAY_DEV_PU_CAMBIARPASSWORD : OPENPAY_PRD_PU_CAMBIARPASSWORD,
        'PS_LIQUIDACIONDETALLE' => API_DEVELOPMENT ? OPENPAY_DEV_PS_LIQUIDACIONDETALLE : OPENPAY_PRD_PS_LIQUIDACIONDETALLE,

        'OPENPAY_KEY_ID' => OPENPAY_DEVELOPMENT ? OPENPAY_DEV_KEY_ID: OPENPAY_PRD_KEY_ID,
        'OPENPAY_KEY_SECRET_USERNAME' => OPENPAY_DEVELOPMENT ? OPENPAY_DEV_KEY_SECRET_USERNAME: OPENPAY_PRD_KEY_SECRET_USERNAME,
        'OPENPAY_KEY_SECRET_PASSWORD' => OPENPAY_DEVELOPMENT ? OPENPAY_DEV_KEY_SECRET_USERNAME: OPENPAY_PRD_KEY_SECRET_PASSWORD,
        'OPENPAY_KEY_PUBLIC' => OPENPAY_DEVELOPMENT ? OPENPAY_DEV_KEY_PUBLIC: OPENPAY_PRD_KEY_PUBLIC,
        'OPENPAY_URL_BASE' => OPENPAY_DEVELOPMENT ? OPENPAY_DEV_URL_BASE: OPENPAY_PRD_URL_BASE,
        'OPENPAY_CHARGES' => OPENPAY_DEVELOPMENT ? OPENPAY_DEV_URL_CHARGES: OPENPAY_PRD_URL_CHARGES,
    ];
?>
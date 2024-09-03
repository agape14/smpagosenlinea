<?php

    function createToken(Request $request)
    {
        $response = Http::withBasicAuth(config('constants.OPENPAY_PRIVATE_KEY'), '')
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post('https://sandbox-api.openpay.pe/v1/' . config('constants.OPENPAY_MERCHANT_ID') . '/tokens', [
                'card_number' => '4111111111111111',
                'holder_name' => 'Juan Perez Ramirez',
                'expiration_year' => '20',
                'expiration_month' => '12',
                'cvv2' => '110',
                'address' => [
                    'city' => 'Querétaro',
                    'country_code' => 'PE',
                    'postal_code' => '76900',
                    'line1' => 'Av 5 de Febrero',
                    'line2' => 'Roble 207',
                    'line3' => 'col carrillo',
                    'state' => 'Queretaro',
                ],
            ]);

        if ($response->successful()) {
            $data = $response->json();
            // Manejar la respuesta exitosa
            return response()->json($data);
        } else {
            // Manejar errores
            return response()->json(['error' => $response->body()], $response->status());
        }
    }

    function createCharge(Request $request)
    {
        $response = Http::withBasicAuth(config('constants.OPENPAY_PRIVATE_KEY'), '')
            ->withHeaders([
                'Content-Type' => 'application/json',
                'X-Forwarded-For' => '175.50.1.81',
            ])
            ->post('https://sandbox-api.openpay.pe/v1/' . config('constants.OPENPAY_MERCHANT_ID') . '/charges', [
                'source_id' => 'kqgykn96i7bcs1wwhvgw',
                'method' => 'card',
                'amount' => 100,
                'currency' => 'PEN',
                'description' => 'Cargo inicial a mi cuenta',
                'order_id' => 'oid-00051',
                'device_session_id' => 'kR1MiQhz2otdIuUlQkbEyitIqVMiI16f',
                'customer' => [
                    'name' => 'Juan',
                    'last_name' => 'Vazquez Juarez',
                    'phone_number' => '4423456723',
                    'email' => 'juan.vazquez@empresa.com.pe',
                ],
            ]);

        if ($response->successful()) {
            $data = $response->json();
            // Manejar la respuesta exitosa
            return response()->json($data);
        } else {
            // Manejar errores
            return response()->json(['error' => $response->body()], $response->status());
        }
    }

    function generateToken() 
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => config('constants.VISA_URL_SECURITY'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_SSLVERSION => 6,
            CURLOPT_HTTPHEADER => array(
            "Accept: */*",
            'Authorization: '.'Basic '.base64_encode(config('constants.VISA_USER').":".config('constants.VISA_PWD'))
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    function generateSesion($amount, $token) 
    {
        $session = array(
            'amount' => $amount,
            'antifraud' => array(
                'clientIp' => $_SERVER['REMOTE_ADDR'],
                'merchantDefineData' => array(
                    'MDD4' => Auth::user()->email,
                    'MDD32' => Auth::user()->code,
                    'MDD63' => Auth::user()->typedoc,
                    'MDD75' => "Registrado",
                    'MDD77' => Auth::user()->days,
                ),
            ),
            'channel' => 'web',
        );
        $json = json_encode($session);
        $response = json_decode(postRequest(config('constants.VISA_URL_SESSION'), $json, $token));
        //var_export($amount); die();
        return $response->sessionKey;
    }

    function generateAuthorization($amount, $purchaseNumber, $transactionToken, $token) 
    {
        $data = array(
            'antifraud' => null,
            'captureType' => 'manual',
            'channel' => 'web',
            'countable' => true,
            'order' => array(
                'amount' => $amount,
                'currency' => 'PEN',
                'purchaseNumber' => $purchaseNumber,
                'tokenId' => $transactionToken
            ),
            'recurrenceMaxAmount' => null,
            'sponsored' => null
        );
        $json = json_encode($data);
        $session = json_decode(postRequest(config('constants.VISA_URL_AUTHORIZATION'), $json, $token));
        return $session;
    }

    function postRequest($url, $postData, $token) 
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                'Authorization: '.$token,
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => $postData
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    function generatePurchaseNumber()
    {
        $archivo = "assets/purchaseNumber.txt"; 
        $purchaseNumber = 225;
        $fp = fopen($archivo,"r"); 
        $purchaseNumber = fgets($fp, 100);
        fclose($fp); 
        ++$purchaseNumber; 
        $fp = fopen($archivo,"w+"); 
        fwrite($fp, $purchaseNumber, 100); 
        fclose($fp);
        return $purchaseNumber;
    }
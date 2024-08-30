<?php

namespace App\Traits;

use App\Models\api\TB_TokenApi;

trait OTPRequests
{
    /**
     * Get users by roles
     *
     * @param int $phoneNumber
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function sendOTP($phoneNumber, $extraData)
    {
        if (!is_array($extraData)) {
            $extraData = array($extraData);
        }

        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://portal-otp.smsmkt.com/api/otp-send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "api_key:38190534d50f977ba76009f48ded4ab9",
                    "secret_key:N7RpstthwXKOq2GZ",
                ),
                CURLOPT_POSTFIELDS => json_encode(
                    array(
                        "phone" => $phoneNumber,
                        "project_key" => "6cc3c3eac2",
                    )
                ),
            )
        );
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public function verifyOTP($token, $otp_code, $ref_code)
    {
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://portal-otp.smsmkt.com/api/otp-validate',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "api_key:38190534d50f977ba76009f48ded4ab9",
                    "secret_key:N7RpstthwXKOq2GZ",
                ),
                CURLOPT_POSTFIELDS => json_encode(
                    array(
                        "token" => $token,
                        "otp_code" => $otp_code,
                        "ref_code" => $ref_code,
                    )
                ),
            )
        );
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;

    }

    public function sendMassages($phoneNumber)
    {
        $tokenKey = TB_TokenApi::where('token_name', 'otp')->first();

        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://portal-otp.smsmkt.com/api/send-message',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "api_key:" . $tokenKey->token_id,
                    "secret_key:" . $tokenKey->secret_key,
                ),
                CURLOPT_POSTFIELDS => json_encode(
                    array(
                        "message" => "chookiat otp : 12345",
                        "phone" => "0937702324",
                        "sender" => "Chookiat",
                        "expire" => "00:05",
                    )
                ),
            )
        );
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
<?php

// namespace App\Helpers;

function myGlobalFunction($param) {
    return "Ini adalah fungsi global dengan parameter: " . $param;
}
function signatureToken($dataSign, $sig)
// -----BEGIN PUBLIC KEY-----
// MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA1NCYhqbPoZvzuZvosh/cz+VYzN5vJXOOSJSZ70p8tDzE43z539263oamvtnYFscYfVlnx9GetGTrgdut9BXzSnqmotvbyjoHpJrdjkcj0i3Zz/AhVigQjFZcnvd/8NR1u/wb/iwKT+wH3XKiGRfParieMdd3oKcxbjF9qoi+TpwNnc1zCXP+r8SXUzCv+obBCQKPGZSy+AtofM3ZPPBrV1w8l3iKnW7ZIC1keV/X44X3++obpfj9uIvC9GWixPxqN7bCvkkCQR11QASVyZwb8tS2/eVqyxhLf+Y0SDVaASZTnXvhGbtaBBENewc09Zqfj/Zs87wzktHf2cV1JaHtEQIDAQAB
// -----END PUBLIC KEY-----
{
        $pub = <<<EOD
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAy0Zp0IR/NSPAOTPKkZAWxkivsqlwhnDytFSelBxHeNp8Gcug8a0pUNXSiJBc5ZuRBty3Fpz4NYWCcRLyFI7bv7cCRkRgNPjD5PF1d62pJm+0bASxYvrxD+XbbuDaI7jE3gqZKcoLtbT1oDdLxf5o3+8SmI6I9RmSHKkuDWNSXW2fuFjYYJ5TPlgcvuwFoD6MLcPui6bx/6+djhxKFLLgzpxps/ty8j5rWRmIyCFZ/YUlPd8fQkoxBLCftMeg++k3QAz+eEBKp2CNM8ioG17ZZBRkU4Rn3gH8hSID4wnQAcYX0enmfdKmoFDJ+K1MA7z1h05zeGqiAjOJTHKVMeKk/wIDAQAB
-----END PUBLIC KEY-----
EOD;

        $verifier = openssl_verify($dataSign, $sig, $pub, OPENSSL_ALGO_SHA256);
        return $verifier;
}
function token()
{
    $data = [
        'exp' => time() + 900, 
        'nbf' => time(), 
        'iss' => 'ASHDDQ', 
        'iat' => time()
    ];
    $token = base64_encode(json_encode($data));
    return $token;
}

if (!function_exists('dokuApiRequest')) {

    function dokuApiRequest(
        array $body,
        string $targetPath,

    ) {

        $clientId = env('DOKU_CLIENT_ID');
        $secretKey = env('DOKU_SECRET_KEY');
        $getUrl = env('DOKU_BASE_URL');
        $requestId = (string) Str::uuid();
        $timestamp = gmdate('Y-m-d\TH:i:s\Z');

        $digest = base64_encode(
            hash('sha256', json_encode($body), true)
        );

        $stringToSign =
            "Client-Id:$clientId\n" .
            "Request-Id:$requestId\n" .
            "Request-Timestamp:$timestamp\n" .
            "Request-Target:$targetPath\n" .
            "Digest:$digest";

        $signature = "HMACSHA256=" . base64_encode(
            hash_hmac(
                'sha256',
                $stringToSign,
                $secretKey,
                true
            )
        );
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Client-Id' => $clientId,
            'Request-Id' => $requestId,
            'Request-Timestamp' => $timestamp,
            'Signature' => $signature,
        ])->post(
            $getUrl.$targetPath,
            $body
        );
        return $response;
    }
}
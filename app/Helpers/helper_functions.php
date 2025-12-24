<?php

// namespace App\Helpers;

function myGlobalFunction($param) {
    return "Ini adalah fungsi global dengan parameter: " . $param;
}
function signatureToken($dataSign, $sig)
// -----BEGIN PUBLIC KEY-----
// MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAy0Zp0IR/NSPAOTPKkZAW
// xkivsqlwhnDytFSelBxHeNp8Gcug8a0pUNXSiJBc5ZuRBty3Fpz4NYWCcRLyFI7b
// v7cCRkRgNPjD5PF1d62pJm+0bASxYvrxD+XbbuDaI7jE3gqZKcoLtbT1oDdLxf5o
// 3+8SmI6I9RmSHKkuDWNSXW2fuFjYYJ5TPlgcvuwFoD6MLcPui6bx/6+djhxKFLLg
// zpxps/ty8j5rWRmIyCFZ/YUlPd8fQkoxBLCftMeg++k3QAz+eEBKp2CNM8ioG17Z
// ZBRkU4Rn3gH8hSID4wnQAcYX0enmfdKmoFDJ+K1MA7z1h05zeGqiAjOJTHKVMeKk
// /wIDAQAB
// -----END PUBLIC KEY-----
{
        $pub = <<<EOD
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAoeLzhYn15aS8yH9vLS48vEdX9ZxCZ/wpCkfoFAqV+kORZCfG4jIdXkdTe+0mG9VVxtmkA4JLDMWrYTrR4PmVn99xU8doQR61aLNw3GjViUXwz5v5wI18F/8XXPJ5PwhKooDsxWDjF3baKW/eqyZFifhrL2eX88z5Gn08Zg6e6FPvVzv4HH0Nhlqe2cn1fvXeHcth2hjqrbOeapwzjjRQ2S27jGE58KeA3S9rYwOblHMKA7EiIrDTqYo7+cDkfABxC/50HF/xS5be8DCE1xFxAqpfo4BDpHTZHbHhodYfu0amTMgBfGYDb2O2DphYN1qqP+MhN9VyQb8gm05Ynh34PQIDAQAB
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
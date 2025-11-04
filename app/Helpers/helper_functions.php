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
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEArvd/19qzkkJ/8V6NkILNDfqaB4unWyDkYdUUCB6WGTBVFa7a/M3W3tN1QacEez71r4o+gtl3nh8ZL4VCPV/b3xRG2M/ddZrG4uqNxzUWCBWg3DoVJK+IB+tW5mtxCpGTUzwvGEkOQgIbdPxHuAF0cp7AsN6LRJNJk+d55sXX/zvu04gRMsMzsvlynNRhDdnSL6EyDjWLlpXHsDu+2z/0tNG8uCna0g/LNtjS3RyBBKsU6V0wqE2JC0ZodHCRwoMEV3CY8ln6XcqbDfOKQ8T1ERLJH8wGbwDGZ2LDawKQMkqi+AxC68DXDnG0tkzS7dYeaMlX/KDozcuBbTvqfj7z8wIDAQAB
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
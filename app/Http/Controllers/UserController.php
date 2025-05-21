<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use PhpParser\Node\Expr\Cast\String_;

class UserController extends Controller
{
    public function show(): View
    {
        $data = [
            'title' => 'judul',
            'nama' => 'rafik'
        ];
        return view('user.profile', $data);
    }

    public function b2bToken(){
        $dateTime = gmdate("Y-m-d H:i:s");
        $isoDateTime = date(DateTime::ATOM, strtotime($dateTime));
        $dateTimeFinal = substr($isoDateTime, 0, 19) . "Z";
        $clientId = "BRN-0225-1714113997400";
        $dataSign = $clientId."|".$dateTimeFinal;
        signatureToken($dataSign);
        $Body = array(
            'responseCode' => '2007300',
            'responseMessage' => 'Successful',
            'accessToken' => token(),
            'tokenType' => 'Bearer',
            'expiresIn' => 900
        );

        header("X-CLIENT-KEY:". $clientId );
        header("X-TIMESTAMP:".$dateTimeFinal );
        echo json_encode($Body);
        echo $dateTimeFinal;
    }
    private function signatureToken($dataSign): String
    {
        $priv = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIIEoQIBAAKCAQBQgk1fSALHZAKB/WPxLKbu8icnHlk3Ws/CCqk2m2J6QFRtGGmN
kC137W5J0YoGSY9f0owNjfVz70A9LxhAbGVevYyGuRGF0JPyM9T6Tm+qS5s8YVTC
w1JfCHx/eX1rWW8+WRFPxy/ATR02ggRWtpx/T81Gk53XpTWk33I9SA0dkLJjmq1N
532cC+gGNpjdG2jRsS4AAMpmQiNU/TkUxQh5VdSZBPS9SjDjrmxd8sk8wtoFW7f+
eQOM7rQhfjkVpdhWPFM6Rurx1gcy/y1+5rtMFnHf0Yemn4f1bKmP0nGyFdLR7jM0
VcNP56+AtF13mGjSnE4DhHJc+ljVAx/pn28fAgMBAAECggEAJb3gDbHRc63DqzKh
npcjLtMgXatRgay1xq5+wxW25b6wlXAjU3Tqi9Unpb1waiAj8XTfqR8KmS3ovIYO
ZW0rXG2ZqjKqL0QnhxybVDhfCsNk47pxJNiyDdEJpCzNCf0kNGNGxVKIZSsBbeMn
q4rx9JDxl4tuLIDLlB4YDPhxBZGfVFcY9OKw210npPQQn0ZcRRiCnLhRrygu/DQe
K0CAxMed6cxWuYdatBvC+ZLCPw1mBJG4vTW1yRQ2qwSIR8MXzrvuvpqExVyWXHZG
oZeZkLeZyqr7Ls20yMl2cU8rJ0pv3jcw6O/L51qW3GnBzMT3jTeImeqN2WY9f92s
cH19SQKBgQCgPg+iczclcChZndRhV+EJDYF6SQGCZz0/TLA45JBEkoh4wmo8d1D6
i40bL+I8Wmg9uCtQxpmazK5k12911d3lkq+WQ4EFmakJ20wzV2Rj/Kjg8vXmCYvM
YhyXIVoQ0CYnJOic9gzTjC8VWWW7MFELBzGOp5gvvPWC2YjRuqaZXQKBgQCAnpgs
BrIhNa3z/zaIc4vrf7hIY9sbPP05QRPlFn6kJNwNMUj7VaVzrROI0DndTYvjdAMw
OWTQF7e5pMWq1zrVE5gXZG9kkx3zpKLlBi97LdrZ6FOyIWPclbPAhDRl3JCttj7U
i2NeYKKPlF3J+n8d2WxZTpTLtkp8/Xni4D0WqwKBgHMIemLNQS5gGKdU1SzYUFUW
W/e0RyAdCuvRGsSM2EBRzSSbtHYZ1Yk2+yIkOs3GvQRpnLbNC2IEQ8FiosI9uKDg
r6o4ZXvmtmG8CzTkLM5Wh8mMwRfVjIU5fXrE14owUuNQ7KgZPlXzUa2K0qwRYGyB
SoM1Ltw+UyUPEtg0nPqFAoGASa0PVCDdxuI97AfkkBNIMjVuNaFlsFumXjamE9Nn
5dTrbG8v9DDiXrnk97j3fIpgOIGLFgO6eO0tJB170VoK7GWV+MhiesU/IgLMAM8j
QbdJpwtLbj1sO75RQlU4wqSvB6LeqNfTqwtF82M0um9Qg6O5SgsWdv7L+n8kY865
j5MCgYAPwxYMQXlEBv/wI30kEpRXMP0Fp4AAVqO+HfnZChDC1YdPkfZcxi6zuXyD
oKe7by6GVpRMtToB5zOeeV9FHxeygko95Fi8EWrBrxsCPp4LZ0MODhglAGiUwCC/
Sw5RDayTtfRW/IKEliGl8BqZvkViW3zKhaMfAImuZT/RbJP3jA==
-----END RSA PRIVATE KEY-----
EOD;
        $algo = "SHA256";
        $binary_signature = "";
        openssl_sign($dataSign, $binary_signature, $priv, $algo);
        $signature = base64_encode($binary_signature);
        return $signature;
    }
    private function token():string
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
}

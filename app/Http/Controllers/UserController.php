<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use PhpParser\Node\Expr\Cast\String_;
use App\Helpers\myGlobalFunction; 
use App\Helpers\signatureToken;
use App\Helpers\token;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

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

    public function getthreeds(Request $request){
        dd($request->all());
    }

    public function charge(Request $request){
        $clientId = 'BRN-0242-1763721186902';
        $secretKey = 'SK-k0Sklx8ZZCqlZpOyPDq7';
        // $clientId = 'BRN-0225-1714113997400';
        // $secretKey = 'SK-r6gc3JZOyf6g9INSIMe4';

        $requestId = (string) Str::uuid();
        $timestamp = gmdate('Y-m-d\TH:i:s\Z');

        $body = [
            "order" => [
                "invoice_number" => "INV-" . time(),
                "amount" => $request->amount
                // "amount" => (int) $request->amount
            ],
            "payment" => [
                "type" => $request->transactionType
            ],
            "customer" => [
                "name" => $request->card_holder
            ],
            "card" => [
                "number" => preg_replace('/\s+/', '', $request->card_number),
                // "expiry_month" => substr($request->expiry, 0, 2),
                // "expiry_year" => '20' . substr($request->expiry, -2),
                "expiry" => $request->expiry,
                "cvv" => $request->cvv
            ]
        ];

        // $requestBody = json_encode($body, JSON_UNESCAPED_SLASHES);
        $digestValue = base64_encode(hash('sha256', json_encode($body), true));
        $targetPath = '/credit-card/charge';

        /**
         * Sesuaikan formula signature dengan dokumentasi DOKU yang diberikan untuk merchant Anda.
         */
        $stringToSign =
            "Client-Id:" . $clientId . "\n" .
            "Request-Id:" . $requestId . "\n" .
            "Request-Timestamp:" . $timestamp . "\n" .
            "Request-Target:".$targetPath ."\n".
            "Digest:".$digestValue;

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
            'https://api.doku.com/credit-card/charge',
            // 'https://api-sandbox.doku.com/credit-card/charge',
            $body
        );

        $responseData = $response->json();

        if (isset($responseData['error'])) {

            return view('user.result', [
                'is_error' => true,
                'error_code' => $responseData['error']['code'] ?? '',
                'error_message' => $responseData['error']['message'] ?? '',
                'error_type' => $responseData['error']['type'] ?? ''
            ]);
        }
        return view('user.result', [
            'is_error' => false,
            'status' => $responseData['payment']['status'] ?? 'FAILED',
            'response_code' => $responseData['payment']['response_code'] ?? '',
            'card' => $responseData['card']['masked'] ?? '',
            'amount' => $responseData['order']['amount'] ?? '',
            'invoice_number' => $responseData['order']['invoice_number'] ?? '',
            'response_message' => $responseData['payment']['response_message'] ?? ''
        ]);

        // return response()->json([
        //     'request_header' => [
        //         'Client-Id' => $clientId,
        //         'Request-Id' => $requestId,
        //         'Request-Timestamp' => $timestamp,
        //         'Signature' => $signature
        //     ],
        //     'request_body' => $body,
        //     'response' => $response->json()
        // ]);
    }

    public function b2bToken(){
        
        $notificationHeader = getallheaders();
        $notificationBody = file_get_contents('php://input');
            // dd($notificationHeader);
        $dateTimel = $notificationHeader['X-Timestamp'];
        // $clientId = "BRN-0289-1728962045839";
        // $clientId = "BRN-0225-1714113997400";
        $clientId =  $notificationHeader['X-Client-Key'];
        $dataSign = $clientId."|".$dateTimel;

        $signature = base64_decode($notificationHeader['X-Signature']);
        
        $sig = signatureToken($dataSign, $signature);
        // echo "hasil : ".$sig;
        if($sig){
            $dateTime = gmdate("Y-m-d H:i:s");
            $isoDateTime = date(DATE_ISO8601, strtotime($dateTime));
            $dateTimeFinal = substr($isoDateTime, 0, 19) . "Z";

            $Body = ['responseCode' => '2007300',
                'responseMessage' => 'Successful',
                'accessToken' => token(),
                'tokenType' => 'Bearer',
                'expiresIn' => 900]
                ;

            header("X-CLIENT-KEY:". $clientId );
            header("X-TIMESTAMP:".$dateTimeFinal );
            echo json_encode($Body);
            // echo $Body;
        }else{
            echo "Signature not match";
        }
    }
    public function virtualAccount(){
        $order = gmdate("YmdHis");
        $notificationHeader = getallheaders();
        $notificationBody = file_get_contents('php://input');
        $dateTimel = $notificationHeader['X-Timestamp'];
        $sig = $notificationHeader['X-Signature'];
        $client = $notificationHeader['X-Partner-Id'];

        $partner_serviceId = json_decode($notificationBody)->{'partnerServiceId'};
        $cust_no = json_decode($notificationBody)->{'customerNo'};
        $va_number = json_decode($notificationBody)->{'virtualAccountNo'};
        $channel = json_decode($notificationBody)->{'additionalInfo'}->{'channel'};
        


        $Body = ['responseCode' => '2002400',
                    'responseMessage' => 'Successful',
                    'virtualAccountData' => [
                        'partnerServiceId' => $partner_serviceId,
                        'customerNo' => $cust_no,
                        'virtualAccountNo' => $va_number,
                        'virtualAccountName' => 'test',
                        'totalAmount' => [
                            'value' => '0.00',
                            'currency' => 'IDR'
                        ],
                        'virtualAccountTrxType' => 'O',
                        'inquiryRequestId' => 'ord-'.$order
                    ],
                    'additionalInfo' => [
                        'channel' => $channel,
                        'trxId' => 'inv-'.$order
                    ]
                ]
                ;
        // $Body = ['responseCode' => '4042412',
        //             'responseMessage' => 'Bill not found'
        //         ]
        //         ;
        echo json_encode($Body);
    }
}

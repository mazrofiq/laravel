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
    // private $clientId;
    // private $baseUrl;

    // public function __construct()
    // {
    //     $this->clientId = env('DOKU_CLIENT_ID');
    //     $this->baseUrl = env('DOKU_BASE_URL');
    // }
    private function renderPaymentResult(array $responseData, string $invoiceNumber = '')
    {
        if (
            isset($responseData['error']) &&
            !isset($responseData['payment']['response_code'])
        ) {

            return view('user.result', [
                'is_error' => true,
                'invoice_number' => $invoiceNumber,
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
    }

    // private function processCharge(
    //     $invoiceNumber, 
    //     $authenticationId,
    //     $customerName,
    //     $type,
    //     $cvv,
    //     $amount
    //     ){
    //     session()->flush();
    //     $targetPath = '/credit-card/charge';

    //     $body = [
    //         "order" => [
    //             "invoice_number" => $invoiceNumber,
    //             "amount" => $amount
    //         ],
    //         "payment" => [
    //             "type" => $type
    //         ],
    //         "customer" => [
    //             "name" => $customerName
    //         ],
    //         "three_dsecure" => [
    //             "authentication_id" => $authenticationId
    //         ],
    //         "card" => [
    //             "cvv" => $cvv
    //         ]
    //     ];

    //     $signData = dokuApiRequest(
    //         $body,
    //         $targetPath
    //     );
    //     $responseData = $signData->json();

    //     return $this->renderPaymentResult(
    //         $responseData,
    //         $invoiceNumber
    //     );
    // }
    public function show(): View
    {
        $data = [
            'title' => 'judul',
            'nama' => 'rafik'
        ];
        return view('user.profile', $data);
    }

    // public function getthreeds(Request $request){
    //     $targetPath = '/credit-card/check-three-d-secure';
    //     $invoiceNumber = "INV-" . time();

    //     $body = [
    //         "order" => [
    //             "amount" => $request->amount
    //         ],
    //         "invoice_number" => $invoiceNumber,
    //         "payment" => [
    //             "type" => $request->transactionType
    //         ],
    //         "three_dsecure" => [
    //             "callback_url_success" =>  url('/payment/charge/'. $invoiceNumber),
    //             "callback_url_failed" =>  url('/payment/failed/'. $invoiceNumber),
    //         ],
    //         "card" => [
    //             "number" => preg_replace('/\s+/', '', $request->card_number),
    //             "expiry" => $request->expiry
    //         ]
    //     ];

    //     $signData = dokuApiRequest(
    //         $body,
    //         $targetPath
    //     );
        
    //     $responseData = $signData->json();
    //     // return $signData()->json([
    //     //     'request_header' => [
    //     //         'Client-Id' => $clientId,
    //     //         'Request-Id' => $requestId,
    //     //         'Request-Timestamp' => $timestamp,
    //     //         'Signature' => $signature
    //     //     ],
    //     //     'request_body' => $body,
    //     //     'response' => $response->json()
    //     // ]);
    //     if (isset($responseData['error']) && !isset($responseData['payment']['response_code'])) {

    //             return $this->renderPaymentResult(
    //             $responseData,
    //             $invoiceNumber
    //         );
    //     }
        
    //     $authenticationUrl = $responseData['three_dsecure']['authentication_url'];
    //     session([
    //                 'authentication_id' =>$responseData['three_dsecure']['authentication_id'],
    //                 'type' => $request->transactionType,
    //                 'cvv' => $request->cvv,
    //                 'amount' => $request->amount,
    //                 'customerName' => $request->card_holder
    //             ]);
        
    //     return redirect()->away($authenticationUrl);
    // }
    // public function paymentCharge($invoice){
    //         $data = [
    //                 'authentication_id' => session('authentication_id'),
    //                 'type' => session('type'),
    //                 'cvv' => session('cvv'),
    //                 'amount' => session('amount'),
    //                 'customerName' => session('customerName'),
    //             ];
    //         return $this->processCharge(
    //             $invoice,
    //             $data['authentication_id'],
    //             $data['customerName'],
    //             $data['type'],
    //             $data['cvv'],
    //             $data['amount']
    //         );
    // }
    // public function paymentFailed($invoice){
    //     $data = [
    //                 'amount' => session('amount')
    //             ];
    //     return view('user.threeDSfailed', [
    //         'amount' => $data['amount'] ?? '',
    //         'invoice_number' => $invoice ?? ''
    //     ]);
    // }

    public function charge(Request $request){
        // $clientId = 'BRN-0242-1763721186902xx';
        // $secretKey = 'SK-k0Sklx8ZZCqlZpOyPDq7';
        // $clientId = 'BRN-0118-1780559864110
        // $secretKey = SK-ln85qKqxFQ6QYmqH2Uc0
        dd($request->all());
        $invoiceNumber = "INV-" . time();
        $targetPath = '/credit-card/charge';

        $body = [
            "order" => [
                "invoice_number" => $invoiceNumber,
                "amount" => $request->amount
            ],
            "payment" => [
                "type" => $request->transactionType
            ],
            "customer" => [
                "name" => $request->card_holder
            ],
            "card" => [
                "number" => preg_replace('/\s+/', '', $request->card_number),
                "expiry" => $request->expiry,
                "cvv" => $request->cvv
            ]
        ];

        $signData = dokuApiRequest(
            $body,
            $targetPath
        );

        $responseData = $signData->json();
        // dd($responseData);
        return $this->renderPaymentResult(
            $responseData,
            $invoiceNumber
        );

    }

    public function b2bToken(){
        $notificationHeader = getallheaders();
        $notificationBody = file_get_contents('php://input');
        $dateTimel = $notificationHeader['X-Timestamp'];
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

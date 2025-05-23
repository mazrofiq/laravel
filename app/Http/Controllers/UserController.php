<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use PhpParser\Node\Expr\Cast\String_;
use App\Helpers\myGlobalFunction; 
use App\Helpers\signatureToken;
use App\Helpers\token;

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
        echo "Signature not match";
        // $notificationHeader = getallheaders();
        // $notificationBody = file_get_contents('php://input');
        // $dateTimel = $notificationHeader['X-TIMESTAMP'];
        // $clientId = "BRN-0225-1714113997400";
        // $dataSign = $clientId."|".$dateTimel;
        // $signature = base64_decode($notificationHeader['X-SIGNATURE']);
        
        // $sig = signatureToken($dataSign, $signature);
        // if($sig){
        //     $dateTime = gmdate("Y-m-d H:i:s");
        //     $isoDateTime = date(DATE_ISO8601, strtotime($dateTime));
        //     $dateTimeFinal = substr($isoDateTime, 0, 19) . "Z";
        //     $Body = array(
        //         'responseCode' => '2007300',
        //         'responseMessage' => 'Successful',
        //         'accessToken' => token(),
        //         'tokenType' => 'Bearer',
        //         'expiresIn' => 900
        //     );

        //     header("X-CLIENT-KEY:". $clientId );
        //     header("X-TIMESTAMP:".$dateTimeFinal );
        //     echo json_encode($Body);
        // }else{
        //     echo "Signature not match";
        // }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{

    public function show($text) {

        if (isset($_GET['embed']))
            return response(
                '<img src="data:image/png;base64, ' .
                    base64_encode(QrCode::format('png')->generate($text)) .
                '"></img>'
            );
        return response(QrCode::encoding('UTF-8')->format('png')->size(510)->generate($text))->header('Content-Type', 'image/png');
    }

    public function index() {
        if (isset($_GET['text'])) {
            return $this->show($_GET['text']);
        }
        abort(404);
    }
}

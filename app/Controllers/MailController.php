<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\admMail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailController extends Controller
{
    public function index(){

    }

    public function mailCancelamento(){
        Mail::to('evandrocortiano@gmail.com')->send(new admMail());
        return "OK";
    }

}

<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use App\Models\EventlogModel;

class UserLogin extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        if(session()->get('userData')) {
            return redirect()->to("/home");
        } else {
            return view('pages/visitor_home');
        }
    }

    public function home()
    {
        date_default_timezone_set('Asia/Taipei');
        $data1['date'] = date('Y-m-d H:i:s');

        $data1['userData'] = session()->userData;

        $eventlogModel = new EventlogModel();
        $data1['the_week_log_count'] = $eventlogModel->getRangeLogCount($data1['userData']['u_id'], date('Y-m-d', strtotime("monday -1 week")), date('Y-m-d', strtotime("sunday 0 week")));

        return view('pages/user_home', $data1);
    }

    public function login()
    {
        $request = \Config\Services::request();
        $data = $request->getPost();

        $userModel = new UserModel();
        $userData = $userModel->where("email", $data['email'])->first();

        if (password_verify($data['password'], $userData['password_hash'])) {
            session()->set("userData", $userData);
            return $this->response->setStatusCode(200)->setJSON("OK");
        } else {
            return $this->response->setStatusCode(400)->setJSON("帳號密碼錯誤");
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to("/");
    }
}

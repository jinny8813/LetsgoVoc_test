<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class UserRegister extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        if(session()->get('userData')) {
            return redirect()->to("/home");
        } else {
            date_default_timezone_set('Asia/Taipei');
            $date = date('Y-m-d H:i:s');

            $request = \Config\Services::request();
            $data = $request->getPost();

            if($data['password'] != $data['cpassword']) {
                return $this->response->setStatusCode(400)->setJSON("密碼驗證錯誤");
            }

            $userModel = new UserModel();
            $temp = $userModel->where('email', $data['email'])->first();

            if($temp != null) {
                return $this->response->setStatusCode(400)->setJSON("帳號已被註冊");
            }

            $values = [
                'email'=>$data['email'],
                'password_hash'=> password_hash( $data['password'], PASSWORD_DEFAULT),
                'nickname'=>$data['nickname'],
                'create_at'=>$date,
                'uuidv4'=> $this->guidv4(),
                'goal'=> 0,
                'lasting'=> 30,
            ];
            $userModel->insert($values);

            return $this->response->setStatusCode(200)->setJSON("OK");
        }
    }
}

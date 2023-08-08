<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class MemberManage extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return view('pages/user_home', $this->session->get('userData'));
    }
}

<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\BookModel;
use App\Models\FlashcardModel;

class Quizlets extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return view('pages/quizmolds_list');
    }

    public function create()
    {
        $userData = session()->userData;

        $bookModel=new BookModel();
        $data['books'] = $bookModel->where('u_id', $userData['u_id'])->findAll();
        return view('pages/quizmolds_create', $data);
    }

    public function store()
    {
        
    }

    public function generateQuiz()
    {
        date_default_timezone_set('Asia/Taipei');
        $date = date('Y-m-d H:i:s');

        $request = \Config\Services::request();
        $data = $request->getPost();

        $userData = session()->userData;

        $flashcardModel=new FlashcardModel();
        if($data['main_way'] == "self"){
            $data1['cards'] = $flashcardModel->getSelfQuiz($date,$data['select_book'],$data['select_old'],$data['select_wrong'],$data['select_state'],$data['select_amount']);
        }else{
            $data1['cards'] = $flashcardModel->getSystemQuiz($userData['u_id'], $data['select_book'], $data['select_amount']);
        }

        if (count($data1['cards'])==0){
            $this->response->setStatusCode(200)->setJSON("OK");
        }else{
            session()->set("quizData", $data1);
            $this->response->setStatusCode(200)->setJSON("OK");
        }
    }

    public function runQuiz()
    {
        $data1 = session()->quizData;
        return view('pages/quiz_flashcard',$data1);
    }
}

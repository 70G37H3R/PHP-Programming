<?php

namespace App\Controllers;

use App\Models\Contact;
use App\SessionGuard as Guard;

class ContactsController extends Controller
{
    public function __construct()
    {
        // Nếu người dùng chưa đăng nhập thì chuyển hướng đến đăng nhập
        if (!Guard::checkLogin()) {
            redirect('/login');
        }

        parent::__construct();
    }

    public function index()
    {
        // Thu thập dữ liệu cho view
        $data = [
            'contacts' => Contact::where('user_id', Guard::user()->id)->get()
        ];

        // Tạo và hiển thị view
        echo $this->view->render('contacts/home', $data);
    }

    // Add contact
    public function add()
    {
        $data = [
            // Đọc giá trị $_SESSION['errors']
            'errors' => session_get_once('errors'),
            // Đọc giá trị $_SESSION['form']
            'old' => session_get_once('form')
        ];
        echo $this->view->render('contacts/add', $data);
    }

    public function create()
    {
        $data = $this->getContactData();
        $contact = new Contact();
        if ($contact->validate($data)) {
            $contact->fill($data);
            $contact->user_id = Guard::user()->id;
            $contact->save();
            $_SESSION['success']="Add Contact Successfully";
            redirect('/');
        }
        // Lưu các giá trị của form vào $_SESSION['form']
        $this->saveFormValues();
        redirect('/contacts/add', ['errors' => $contact->getErrors()]);
    }

    // Lưu các thông báo lỗi vào $_SESSION['errors']
    protected function getContactData()
    {
        return [
            'name' => filter_var($_POST['name'], FILTER_SANITIZE_STRING), 'phone' => preg_replace('/[^0-9]+/', '', $_POST['phone']), 'notes' => filter_var($_POST['notes'], FILTER_SANITIZE_STRING)
        ];
    }

    // Edit contact
    public function edit($contactId)
    {
        $contact = Contact::find($contactId);
        if (!$contact || ($contact->user_id !== Guard::user()->id)) {
            $this->notFound();
        }

        $formValues = session_get_once('form');
        $data = [
            'errors' => session_get_once('errors'), 'contact' => (is_countable($formValues) && count($formValues) > 0) ?
                array_merge($formValues, ['id' => $contact->id]) : $contact->toArray()
        ];
        echo $this->view->render('contacts/edit', $data);
    }


    public function update($contactId)
    {
        $contact = Contact::find($contactId);
        if (!$contact || ($contact->user_id !== Guard::user()->id)) {
            $this->notFound();
        }

        
        $data = $this->getContactData();
        if ($contact->validate($data)) {
            $contact->fill($data)->save();
            $_SESSION['success']="Update Contact Successfully";
            redirect('/');
        }
        $this->saveFormValues();
        redirect('/contacts/edit/' . $contactId, ['errors' => $contact->getErrors()]);
    }

    // Delete contact
    public function delete($contactId)
    {
        $contact = Contact::find($contactId);
        if (!$contact || ($contact->user_id !== Guard::user()->id)) {
            $this->notFound();
        }
        $contact->delete();
        $_SESSION['success']="Delete Contact Successfully";
        redirect('/');
    }
}

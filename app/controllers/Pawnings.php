<?php
    class Pawnings extends Controller {
        public function __construct() {
            if(!isLoggedIn()) {
                redirect('employees');
            }

            $this->pawningModel = $this->model('Pawning');
        }

        public function pawned_items() {
            // Get pawned items
            $pawned_items = $this->pawningModel->getPawnedItems();

            $data = [
                'pawned_items' => $pawned_items
            ];

            $this->view('PawnOfficer/pawnedItems', $data);
        }

        public function payment_details($id) {
            // Get pawned item
            $pawned_item = $this->pawningModel->getPawnItemById($id);

            $data = [
                'pawn_item' => $pawned_item
            ];

            $this->view('PawnOfficer/payment_details', $data);
        }

        public function make_payments($id) {
            // Get pawned item
            $pawned_item = $this->pawningModel->getPawnItemById($id);

            $data = [
                'pawn_item' => $pawned_item
            ];

            $this->view('PawnOfficer/make_payments', $data);
        }

        public function release_pawn($id) {
            // Get pawned item
            $pawned_item = $this->pawningModel->getPawnItemById($id);

            $data = [
                'pawn_item' => $pawned_item
            ];

            $this->view('PawnOfficer/release_pawn', $data);
        }

        public function renew_pawn($id) {
            // Get pawned item
            $pawned_item = $this->pawningModel->getPawnItemById($id);

            $data = [
                'pawn_item' => $pawned_item
            ];

            $this->view('PawnOfficer/renew_pawn', $data);
        }

        public function new_pawning() {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Process form

                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                $data = [
                    'nic' => trim($_POST['nic']),
                    'email' => trim($_POST['email']),
                    'type' => trim($_POST['type']),
                    'image' => trim($_POST['image']),
                    'customer' => '',
                    'pawn_officer' => $_SESSION['user_id'],
                    'type_err' => '',
                    'image_err' => '',
                    'nic_err' => '',
                    'email_err' => ''
                ];

                

                if(empty($data['nic'])) {
                    $data['nic_err'] = 'Please enter customer NIC';
                } else {
                    $customer = $this->pawningModel->getCustomerByNIC($data['nic']);

                    if($customer) {
                        if(($customer->email) != ($data['email'])) {
                            $data['email_err'] = 'Customer does not have an account for this email';
                        } else {
                            $data['customer'] = $customer->UserId;
                        }
                    } else {
                        $data['nic_err'] = 'A customer with this NIC has not registered with us'; 
                    }
                }

                if(empty($data['email'])) {
                    $data['email_err'] = 'Please enter customer email';
                }

                if(empty($data['type'])) {
                    $data['type_err'] = 'Please choose a type';
                }

                if(empty($data['image'])) {
                    $data['image_err'] = 'Please insert the article image';
                }

                if(empty($data['type_err']) && empty($data['image_err']) && empty($data['nic_err']) && empty($data['email_err'])) {
                    $success = $this->pawningModel->addArticle($data);

                    if($success) {
                        // Redirect to successful message                        
                        flash('register', 'Article added successfully', 'success');
                        redirect('/pawnings/new_pawning');
                        // $this->view('PawnOfficer/register_customer', $data);
                    } else {
                        flash('register', 'Something went wrong', 'invalid');
                        $this->view('PawnOfficer/new_pawning', $data);                        
                    }
                } else {
                    $this->view('PawnOfficer/new_pawning', $data);
                }

            } else {
                //Init data
                $data = [
                    'nic' => '',
                    'email' => '',
                    'type' => '',
                    'image' => '',
                    'customer' => '',
                    'pawn_officer' => '',
                    'type_err' => '',
                    'image_err' => '',
                    'nic_err' => '',
                    'email_err' => ''
                ];

                // Load view
                $this->view('PawnOfficer/new_pawning', $data);
            }
        }        
    }
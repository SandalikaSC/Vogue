<?php
    class Admin extends Controller {
        public function __construct(){
            if(!isLoggedIn()) {
                redirect('employees');
            }
        }

        public function AdminDash(){
            $gold_rates = $this->model('adminModel')->getGoldRates();
            $interest = $this->model('adminModel')->getInterestRates();

            $data = [
                'title' => 'Dashboard',
                'gold_rates' => $gold_rates,
                'interest' => $interest
            ];

            $this->view('Admin/adminDash_1', $data);
        }

        public function pawned_items() {
            // Get pawned items
            $pawned_items = $this->model('adminModel')->getPawnedItems();

            $data = [
                'pawned_items' => $pawned_items
            ];

            $this->view('Admin/pawnedItems_Admin', $data);
        }

        public function pawnedItems_payments($id) {
            // Get pawned item
            $pawned_item = $this->model('adminModel')->getPawnItemById($id);

            $data = [
                'pawn_item' => $pawned_item
            ];

            $this->view('Admin/view_pawned_items', $data);
        }

        public function view_staff() {
            $data = [];

            $this->view('Admin/staff', $data);
        }

        public function view_gold_market() {
            $data = [];

            $this->view('Admin/gold_market', $data);
        }
    }
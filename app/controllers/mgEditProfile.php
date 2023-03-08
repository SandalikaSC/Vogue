<?php
class mgEditProfile extends controller
{
    public function __construct()
   {
     flashMessage();
   }

    public function index($alert = null)
    {

        isLoggedIn();
        $staffMem = $this->model("staffModel");
        $alert = $staffMem->viewStaffMember($_SESSION['user_id']);
        $this->view("/Manager/edit-profile", $alert);
    }


    public function editProfileDetails($alert = null)
    {
        isLoggedIn();
        $staffMem = $this->model("staffModel");
        $data = $staffMem->viewStaffMember($_SESSION['user_id']);
        $this->view("/Manager/edit-profile-details", array($alert, $data));
    }

    public function userChangePassword()
    {

        $currentPwd = $_POST["curr-password"];
        $confirmPwd = $_POST["confirm-password"];
        $newPwd = $_POST["new-password"];
        $staffmem = $this->model("staffModel");
        $passwd = $staffmem->getUserPassword($_SESSION['user_email']);
        if (password_verify($currentPwd, $passwd->password)) {
            if ($newPwd == $confirmPwd) {
                $userModel = $this->model("userModel");
                $hash = password_hash($newPwd, PASSWORD_BCRYPT);
                $userModel->resetPassword($_SESSION["user_email"], $hash);
                echo json_encode(array("msg" => 1));
            } else {
                echo json_encode(array("msg" => "fail"));
            }
        } else {
            echo json_encode(array("msg" => "fail"));
        }
    }
    //to generate a OTP number
    private function randomPassword()
    {
        $alphabet = '1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 6; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function sendOTP()
    {
        $_SESSION['otp'] = $this->randomPassword();
        $abc = sendMail($_SESSION['user_email'], 'OTP', $_SESSION['otp'], 'Vogue');
        header("Content-Type: application/json");
        if ($abc == null) {
            echo json_encode(array("msg" => "fail"));
        } else {
            echo json_encode(array("msg" => "ok"));
        }
    }

    public function verifyOtpAndPassword()
    {

        $password = $_POST['password'];
        $otp = $_POST['otp'];
        $staffmem = $this->model("staffModel");
        $DBPassword = $staffmem->getUserPassword($_SESSION['user_email']);
        if (password_verify($password, $DBPassword->password) and $otp == $_SESSION['otp']) {
            echo json_encode(array("msg" => "ok"));
            unset($_SESSION['otp']);
        } else {
            echo json_encode(array("msg" => "fail"));
            unset($_SESSION['otp']);
        }
    }

    public function manualSetEmail()
    {
        if (isset($_POST["new_email"]) and isset($_POST["confirm_email"])) {
            $newEmail = $_POST["new_email"];
            $confirmEmail = $_POST["confirm_email"];
            $staffmem = $this->model("staffModel");
            $isEmailExist = $staffmem->emailExist($newEmail);
            if ($newEmail == $confirmEmail and !$isEmailExist) {
                $userModel = $this->model("userModel");
                $userModel->resetEmail($_SESSION["user_email"], $newEmail);
                $_SESSION['user_email'] = $newEmail;
                flashMessage("Email Updated");
                redirect("/mgEditProfile");
            } else if ($isEmailExist) {
                flashMessage("Email already exists");
                redirect("/mgEditProfile");
            }
        } else {
            flashMessage("Some Error Occured..Try Again");
            redirect("/mgEditProfile");
        }
    }

    public function setPersonalDetails()
    {
        isLoggedIn();
        $staffMem = $this->model("staffModel");
        $result = $staffMem->setPersonalInfo($_SESSION['user_id'], $_POST['fName'], $_POST['lName'], $_POST['gender'], $_POST['lane1'], $_POST['lane2'], $_POST['lane3'], $_POST['mob-no'], $_POST['mob-no2'], $_POST['image']);

        if ($result) {
            echo "done";
            flashMessage("Personal Details Updated");
            
        } else {
            echo "fail";
            flashMessage("Personal Details not Updated");
            
        }
    }
}

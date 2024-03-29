<?php

use LDAP\Result;

class staffModel extends Database
{
    //to load the Pawning Officers,vault keepers,gold appraisers
    public function getStaffMember()
    {
        $sql = 'select UserId,concat(First_Name," ",Last_Name) as Name, type as Role, Created_date as Date from user where UserId not like "MG%"  AND UserId not like "CU%" AND UserId not like "AD%" AND UserId not like "OW%"';
        $this->query($sql);
        $result = $this->resultSet();
        if ($this->rowCount() > 0) {
            return $result;
        } else {
            return 0;
        }
    }

    //to calculate the next user id
    public function getStaffId($role)
    {
        $sql = "select UserId from user where type=? order by UserId desc limit 1";
        $this->query($sql);
        $this->bind(1, $role);
        $result = $this->single();


        if (empty($result)) {
            switch ($role) {
                case 'Pawning Officer':
                    return 'PO000';
                    break;

                case 'Vault Keeper':
                    return 'VK000';
                    break;

                case 'Gold Appraiser':
                    return 'GA000';
                    break;
            }
        } else {
            return $result->UserId;
        }
    }

    //to check whether a email already exists or not
    public function emailExist($email, $userId = null)
    {
        if (!empty($userId)) {
            $sql = 'select email from user where email=? and userId != ?';
            $this->query($sql);
            $this->bind(1, $email);
            $this->bind(2, $userId);
            $result1 = $this->single();
            if ($this->rowCount()) {
                return true;
            } else {
                return false;
            }
        } else {
            $sql1 = 'select email from user where email=?';
            $this->query($sql1);
            $this->bind(1, $email);
            $result1 = $this->single();

            if ($this->rowCount()) {
                return true;
            } else {
                return false;
            }
        }
    }

    //to check whether NIC already exist or not
    public function nicExist($nic, $userId = null)
    {
        if (!empty($userId)) {
            $sql1 = 'select NIC from user where NIC=? and userId != ?';

            $this->query($sql1);
            $this->bind(1, $nic);
            $this->bind(2, $userId);
            $result1 = $this->single();

            if ($this->rowCount()) {
                return true;
            } else {
                return false;
            }
        } else {

            $sql1 = 'select NIC from user where NIC=?';

            $this->query($sql1);
            $this->bind(1, $nic);

            $result1 = $this->single();

            if ($this->rowCount()) {
                return true;
            } else {
                return false;
            }
        }
    }

    //to check whether the phone number already exist or not
    public function phoneExist($phone, $userId = null)
    {
        if (!empty($userId)) {
            $sql1 = 'select phone from phone where phone=? and userId != ?';
            $this->query($sql1);
            $this->bind(1, $phone);
            $this->bind(2, $userId);
            $result1 = $this->single();

            if ($this->rowCount()) {
                return true;
            } else {
                return false;
            }
        } else {
            $sql1 = 'select phone from phone where phone=?';

            $this->query($sql1);
            $this->bind(1, $phone);

            $result1 = $this->single();

            if ($this->rowCount()) {
                return true;
            } else {
                return false;
            }
        }
    }


    //create new staff member
    public function addStaffMember($id, $fName, $lName, $gender, $nic, $dob, $line1, $line2, $line3, $mob, $mob2, $email, $role, $image, $hash)
    {

        $sql = 'insert into user(UserId,email,password,type,verification_status,First_Name, Last_Name, Gender, NIC, DOB, Line1, Line2, Line3, image, Status,Created_By) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';

        $this->query($sql);

        $this->bind(1, $id);
        $this->bind(2, $email);
        $this->bind(3, $hash);
        $this->bind(4, $role);
        $this->bind(5, 1);
        $this->bind(6, $fName);
        $this->bind(7, $lName);
        $this->bind(8, $gender);
        $this->bind(9, $nic);
        $this->bind(10, $dob);

        if ($line1 == "") {
            $this->bind(11, NULL);
        } else {
            $this->bind(11, $line1);
        }

        if ($line2 == "") {
            $this->bind(12, NULL);
        } else {
            $this->bind(12, $line2);
        }

        if ($line3 == "") {
            $this->bind(13, NULL);
        } else {
            $this->bind(13, $line3);
        }

        $this->bind(14, $image);
        $this->bind(15, 1);
        $this->bind(16, $_SESSION['user_id']);
        $result = $this->execute();
        if ($result) {
            $result1 = '';
            if (!empty($mob2)) {
                $sql1 = 'insert into phone (userId,phone) values (:userId,:mobile),(:userId,:home);';
                $this->query($sql1);

                $this->bind(":userId", $id);
                $this->bind(":mobile", $mob);
                $this->bind(":home", $mob2);
                $result1 = $this->execute();
            } else {
                $sql1 = 'insert into phone (userId,phone) values (:userId,:mobile);';
                $this->query($sql1);

                $this->bind(":userId", $id);
                $this->bind(":mobile", $mob);
                $result1 = $this->execute();
            }
            if ($result1) {
                return $result and $result1;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


// to view a staff member. getting all staff member details
    public function viewStaffMember($id)
    {
        $sql = "select user.UserId, user.First_Name, user.Last_Name, user.Gender, user.NIC, user.DOB, user.Line1, user.Line2, user.Line3, user.email, user.image, user.type, user.Created_date,user.Created_By,user.last_edit, phone.phone from user inner join phone on user.UserId=phone.userId where user.UserId=? ;";
        $this->query($sql);
        $this->bind(1, $id);
        $result = $this->resultSet();

        return $result;
    }


    //delete staff member
    public function deleteStaffMember($id)
    {

        $sql2 = "delete from phone where userId= ?";
        $this->query($sql2);
        $this->bind(1, $id);
        $result2 = $this->execute();

        $sql = "delete from user where UserId=?";
        $this->query($sql);
        $this->bind(1, $id);
        $result1 = $this->execute();

        return $result1 and $result2;
    }

   //to load a profile picture
    public function loadProfilePicture($email)
    {
        $sql = 'select image, concat(First_Name," ",Last_Name) as Name from user where email=? limit 1';
        $this->query($sql);
        $this->bind(1, $email);
        $result = $this->single();
        return $result;
    }

    //to get all passwords except given user
    public function getPasswords($userId)
    {

        $sql = "select password from user where userId != ?";
        $this->query($sql);
        $this->bind(1, $userId);
        $passwords = $this->resultSet();
        return $passwords;
    }

//to get all passwords
    public function getUserPassword($email)
    {
        $sql = 'select password from user where email= ? limit 1';
        $this->query($sql);
        $this->bind(1, $email);
        $result = $this->single();
        return $result;
    }

    //to get phone numbers of given user
    public function getUserPhoneNumbers($userId)
    {
        $sql = 'select userId,phone from phone where userId=?';
        $this->query($sql);
        $this->bind(1, $userId);
        $phoneNumbers = $this->resultSet();
        if ($phoneNumbers) {
            return $phoneNumbers;
        } else {
            return 0;
        }
    }

    //to update personal details
    public function setPersonalInfo($id, $fName, $lName, $gender, $line1, $line2, $line3, $mob2, $image, $curr_mob = null, $curr_mob2 = null)
    {
        $sql = 'update user set First_Name=?,Last_Name=?,Gender=?,Line1=?,Line2=?,Line3=?,image=?,last_edit=? where userId=?';
        $this->query($sql);

        $this->bind(9, $id);
        $this->bind(1, $fName);
        $this->bind(2, $lName);
        $this->bind(3, $gender);


        if ($line1 == "") {
            $this->bind(4, NULL);
        } else {
            $this->bind(4, $line1);
        }

        if ($line2 == "") {
            $this->bind(5, NULL);
        } else {
            $this->bind(5, $line2);
        }

        if ($line3 == "") {
            $this->bind(6, NULL);
        } else {
            $this->bind(6, $line3);
        }

        $this->bind(7, $image);
        $_SESSION['image']=$image;
        // Set the timezone to Sri Lanka
        date_default_timezone_set('Asia/Colombo');

        // Get the current timestamp in Sri Lanka
        $current_timestamp = time();

        // Format the timestamp into a readable string
        $formatted_timestamp = date('Y-m-d H:i:s', $current_timestamp);

        $this->bind(8, $formatted_timestamp);

        $result = $this->execute();

        if ($result) {
            $result1 = '';

            if ($curr_mob2 == null) {
                $sql = 'insert into phone (userId,phone) values (?,?)';
                $this->query($sql);
                $this->bind(1, $id);
                $this->bind(2, $mob2);
                $this->execute();
                $result1 = '1';
            } else if ($curr_mob2 == "empty") {
                $sql1 = 'update phone set phone=? where userId=? and phone=?';
                $this->query($sql1);
                $this->bind(1, $mob2);
                $this->bind(2, $id);
                $this->bind(3, "");
                $this->execute();
                $result1 = '1';
            } else {
                $sql1 = 'update phone set phone=? where userId=? and phone=?';
                $this->query($sql1);
                $this->bind(1, $mob2);
                $this->bind(2, $id);
                $this->bind(3, $curr_mob);
                $this->execute();
                $result1 = '1';
            }
            $result1 = '1';

            if ($result1) {
                return $result and $result1;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

//to reset the email
    public function resetEmail($newemail,$UserId){
        $sql='update user set email=? where UserId=?';
        $this->query($sql);
        $this->bind(1,$newemail);
        $this->bind(2,$UserId);
        $this->execute();
    }

  //to reset the password
    public function resetPassword($UserId, $password)
    {
        $sql = 'update user set password=? where UserId=?';
        $this->query($sql);
        $this->bind(1, $password);
        $this->bind(2, $UserId);
        $this->execute();
    }

    //to get user email
    public function getUserEmail($id)
    {
        $sql = 'select email from user where UserId=?';
        $this->query($sql);
        $this->bind(1, $id);
        $result = $this->single();
        return $result;
    }

 //to delete complaint
    public function deleteComplaint($cid)
    {
        $sql = 'delete from complaint where CID=?';
        $this->query($sql);
        $this->bind(1, $cid);
        $result = $this->execute();
        return $result;
    }
}

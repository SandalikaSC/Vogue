<?php
class mgPawnArticles extends controller
{
   public function __construct()
   {
      flashMessage();
   }

   //to compare the date
   public function dateCompare($date, $days_to_add = 0)
   {
      $currentDate = new DateTime(date('Y-m-d'));

      $givenDate = new DateTime($date);
      $givenDate->modify("+$days_to_add day"); // Add days to the starting date

      if ($currentDate > $givenDate) {
         return false;
      } else {
         return true;
      }
   }

   //to display all pawned articles
   public function index()
   {
      isLoggedIn();
      $pawn = $this->model("pawnArticleModel");
      $result = $pawn->loadPawnArticles();
      if ($result) {  
         $count = 0;
         foreach ($result as $row) {    //to count no of articles which are to be added to the Auction.
            if (!($this->dateCompare($row->End_Date, 14)) and $row->Status == "Pawned") {
               $count++;
            }
         }

         $noOfEmails = 0;
         foreach ($result as $row) {  //to count no of warning emails.
            if ($this->dateCompareForEmail($row->End_Date, 30) and $row->WarningOne == 0) {
               $noOfEmails++;
            } else if ($this->dateCompareForEmail($row->End_Date, 0) and $row->WarningTwo == 0) {
               $noOfEmails++;
            }
         }

         $this->view("/Manager/pawnArticle_Dashboard", array($result, $count, $noOfEmails));
      } else {
         $result = 0;
         $this->view("/Manager/pawnArticle_Dashboard", array($result, 0, 0));
      }
   }

  //date compare for warning emails.
   public function dateCompareForEmail($date, $days_to_sub = 0)
   {
      $currentDate = new DateTime(date('Y-m-d'));

      $givenDate = new DateTime($date);
      $givenDate->modify("-$days_to_sub day"); // substract days to the starting date


      if ($currentDate == $givenDate) {
         return true;
      } else {
         return false;
      }
   }

//to view pawned article details
   public function viewPawnedItem($id)
   {

      isLoggedIn();

      $pawn = $this->model("pawnArticleModel");
      $result = $pawn->viewPawnArticle($id);
      $sum = 0;
      foreach ($result[1] as $row) {
         $sum = $sum + $row->Amount;
      }
      $result[] = $sum;

      $this->view("/Manager/viewPawnedItem", $result);
   }

//to send warning emails at once
   public function sendWarningEmails()
   {
      $pawn = $this->model("pawnArticleModel");
      $result = $pawn->loadPawnArticles();

      if ($result) {
         $flag = 0;
         foreach ($result as $row) {
            if ($this->dateCompareForEmail($row->End_Date, 30) and $row->WarningOne == 0) {
               $useremail = $this->model("pawnArticleModel");  //set email details
               $email = $useremail->findUserEmail($row->userId);
               $sms = "Note: Only One Month Left";
               $useremail = null;

               $abc = sendMail($email->email, "warning", $sms, "V O G U E");  //send warning mails
               if ($abc == null) {  //if network issue
                  $flag = 1;
                  flashMessage("Network Error Occurd..", 0);
                  echo "Done";
                  break;
               } else {
                  $warning = $this->model("pawnArticleModel")->updateStatus($row->Pawn_Id, 30);
               }
            } else if ($this->dateCompareForEmail($row->End_Date, 0) and $row->WarningTwo == 0) {
               $useremail = $this->model("pawnArticleModel");   //set email details
               $email = $useremail->findUserEmail($row->userId);
               $sms = "Note: Today is the End Date For Your Pawn";
               $useremail = null;

               $abc = sendMail($email->email, "warning", $sms, "V O G U E");  //send warning mails
               if ($abc == null) {   //if network issue
                  $flag = 1;
                  flashMessage("Network Error Occurd..", 0);
                  echo "DONE";
                  break;
               } else {
                  $warning = $this->model("pawnArticleModel")->updateStatus($row->Pawn_Id, 0);
               }
            }
         }
         if (!$flag) {
            echo "DONE";
            flashMessage("Warnings Sent Successfully", 1);
         }
      } else {
         echo "DONE";
         flashMessage("No Articles Pawned to send emails", 0);
      }
   }


//to add to the auction at once.
   public function addToAuction()
   {
      $pawn = $this->model("pawnArticleModel");
      $result = $pawn->loadPawnArticles();
      if ($result) {
         $flag = 0;
         foreach ($result as $row) {
            if (!($this->dateCompare($row->End_Date, 14))) {
               $useremail = $this->model("pawnArticleModel");
               $email = $useremail->findUserEmail($row->userId);  //set email details
               $sms = "Your Article was added to Auction";
               $useremail = null;

               if (sendMail($email->email, "pawn_to_auction", $sms, "V O G U E")) {
                  date_default_timezone_set('Asia/Colombo');
                  $current_timestamp = date('H:i:s');  //derive the current date
                  $auction_date = date('Y-m-d H:i:s');
                  $auction = $this->model("pawnArticleModel");
                  $row = $auction->pawnToAuction($row->Pawn_Id, $auction_date, $current_timestamp);
                  $auction = null;
               } else {
                  $flag = 1;
                  flashMessage("Network Error Occurd..", 0);
                  echo "DONE";
                  break;
               }
            }
         }
         if (!$flag) {
            echo "DONE";
            flashMessage("Added to Auction Successfully", 1);
         }
         
      } else {
         echo "DONE";
         flashMessage("No Articles Pawned to add Auction", 0);
      }
   }




//to add to the auction one by one
   public function addOneByOneToAuction($pawnid, $End_Date, $userId)
   {

      $isComplete = $this->model("pawnArticleModel")->isCompleted($pawnid);  //to check whether pawning time period is completed
      if (!($this->dateCompare($End_Date, 14)) and !$isComplete) {
         $pawn1 = $this->model("pawnArticleModel")->checkStatus($pawnid);
         if ($pawn1) {
            echo "DONE";
            flashMessage("Already In Auction", 0);
         } else {
            $useremail = $this->model("pawnArticleModel");
            $email = $useremail->findUserEmail($userId);  //find the user email
            $sms = "Your Article was added to Auction";
            $sms = "Your Article was added to Auction";
            if (sendMail($email->email, "pawn_to_auction", $sms, "V O G U E")) {
               date_default_timezone_set('Asia/Colombo');  //derive the current date
               $current_timestamp = date('H:i:s');
               $auction_date = date('Y-m-d H:i:s');
               $pawn2 = $this->model("pawnArticleModel")->pawnToAuction($pawnid, $auction_date, $current_timestamp);
               echo "DONE";
               flashMessage("Added to Auction Successfully", 1);
            } else {
               echo "fail";
               flashMessage("Network Error Occurd..", 0);
            }
         }
      }
   }

//to send warning emails one by one
   public function sendOneByOneWarning($userId, $End_Date, $pawnid, $warning1, $warning2)
   {
      if ($this->dateCompareForEmail($End_Date, 0) and $warning2 == 0) {  //today is the end date
         $useremail = $this->model("pawnArticleModel");
         $email = $useremail->findUserEmail($userId);

         $sms = "Note: Today is the End Date For Your Pawn";
         $abc = sendMail($email->email, "warning", $sms, "V O G U E");
         if ($abc == null) {
            flashMessage("Network Error Occurd..", 0);
            echo "DONE";
         } else {
            $warning = $this->model("pawnArticleModel")->updateStatus($pawnid, 0);
            echo "DONE";
            flashMessage("Warning Sent Successfully", 1);
         }
      } else if ($this->dateCompareForEmail($End_Date, 30) and $warning1 == 0) { //before one month from the end date
         $useremail = $this->model("pawnArticleModel");
         $email = $useremail->findUserEmail($userId);
         $sms = "Note: Only One Month Left";


         $abc = sendMail($email->email, "warning", $sms, "V O G U E");
         if ($abc == null) {
            flashMessage("Network Error Occurd..", 0);
            echo "DONE";
         } else {
            $warning = $this->model("pawnArticleModel")->updateStatus($pawnid, 30);
            echo "DONE";
            flashMessage("Warning Sent Successfully", 1);
         }
      }
   }

//to filter the articles
   public function filter()
   {

      $minPrice = isset($_POST['min-price']) ? $_POST['min-price'] : '';
      $maxPrice = isset($_POST['max-price']) ? $_POST['max-price'] :  '';
      $createdDate = isset($_POST['created-date']) ? $_POST['created-date'] : '';
      $endDate = isset($_POST['end-date']) ? $_POST['end-date'] : '';
      $karatage = isset($_POST['karatage']) ? $_POST['karatage'] : '';
      $type = isset($_POST['type']) ? $_POST['type'] : '';
      $minWeight = isset($_POST['min-weight']) ? floatval($_POST['min-weight']) : '';
      $maxWeight = isset($_POST['max-weight']) ? floatval($_POST['max-weight']) : '';

      $pawn = $this->model("pawnArticleModel");
      $res = $pawn->filter($minPrice, $maxPrice, $createdDate, $endDate, $karatage, $type, $minWeight, $maxWeight);

      if ($res) {
         isLoggedIn();
         $pawn = $this->model("pawnArticleModel");
         $result = $pawn->loadPawnArticles();

         $count = 0;
         foreach ($result as $row) {
            if (!($this->dateCompare($row->End_Date, 14)) and $row->Status == "Pawned") {
               $count++;
            }
         }

         $noOfEmails = 0;
         foreach ($result as $row) {
            if ($this->dateCompareForEmail($row->End_Date, 30) and $row->WarningOne == 0) {
               $noOfEmails++;
            } else if ($this->dateCompareForEmail($row->End_Date, 0) and $row->WarningTwo == 0) {
               $noOfEmails++;
            }
         }

         $this->view("/Manager/pawnArticle_Dashboard", array($res, $count, $noOfEmails));
      } else {
         $this->view("/Manager/pawnArticle_Dashboard", array($res, 0, 0));
      }
   }

   public function generatePawnReport($article_id)
   {
      isLoggedIn();
      $pawn = $this->model("pawnArticleModel");
      $result = $pawn->viewPawnArticle($article_id);
      $sum = 0;
      foreach ($result[1] as $row) {
         $sum = $sum + $row->Amount;
      }
      $result[] = $sum;
      // var_dump($result);
      $this->view("/pages/pawnArticleReceipt", $result);
   }
}

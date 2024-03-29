<?php
class mgAuction extends controller
{

   //to load all auctioned articles
   public function index()
   {
      isLoggedIn();
      $auction = $this->model("auctionArticleModel");
      $result = $auction->getAuctionArticles();
      $this->view("/Manager/auction_dashboard", $result);
   }

   //to view auction article
   public function viewAuctionItem($article_id)
   {
      isLoggedIn();
      $auction = $this->model("auctionArticleModel");
      $result = $auction->viewAuctionArticle($article_id);
      $sum = 0;
      foreach ($result[1] as $row) { //to calculate paid amount
         $sum = $sum + $row->Amount;
      }
      $result[] = $sum;
      $this->view("/Manager/viewAuctionItem", $result);
   }


   //to filter the articles in auction dashboard
   public function filter()
   {
      $auctionDate=isset($_POST['auction-date']) ? $_POST['auction-date'] : '';
      $firstDate = isset($_POST['created-date']) ? $_POST['created-date'] : '';
      $secondDate = isset($_POST['end-date']) ? $_POST['end-date'] : '';
      $karatage = isset($_POST['karatage']) ? $_POST['karatage'] : '';
      $type = isset($_POST['type']) ? $_POST['type'] : '';
      $minWeight = isset($_POST['min-weight']) ? floatval($_POST['min-weight']) : '';
      $maxWeight = isset($_POST['max-weight']) ? floatval($_POST['max-weight']) : '';

      $auction = $this->model("auctionArticleModel");
      $res = $auction->filter($auctionDate, $firstDate, $secondDate,  $karatage,  $type,$minWeight,$maxWeight);

      if($res){
         isLoggedIn();
         $this->view("/Manager/auction_dashboard", $res);

      }else{
         $this->view("/Manager/auction_dashboard", 0);
      }
      
   }


   //to generate a report, all details when an article is clicked is sent to 'pawnArticleReceipt' User Interface
   public function generateAuctionReport($article_id)
   {
      isLoggedIn();
      $auction = $this->model("auctionArticleModel");
      $result = $auction->viewAuctionArticle($article_id);
      $sum = 0;
      foreach ($result[1] as $row) {
         $sum = $sum + $row->Amount;
      }
      $result[] = $sum;
      $this->view("/pages/pawnArticleReceipt", $result);
   }
}

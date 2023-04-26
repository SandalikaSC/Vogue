<?php
class pawnArticleModel extends Database
{
    public function loadPawnArticles()
    {
        $sql = 'select a.Article_Id,a.Estimated_Value,a.Karatage,a.Weight,a.Type,a.image,p.Pawn_Id,p.Pawn_Date,p.Redeemed_Date,p.End_Date,p.Article_Id,p.userId from article a inner join pawn p on a.Article_Id = p.Article_Id where p.Status like "p%" AND  p.Status like "P%"';
        $this->query($sql);
        $result = $this->resultSet();

        if ($this->rowCount() > 0) {
            return $result;
        } else {
            return 0;
        }
    }

    public function viewPawnArticle($id)
    {

        $sql = 'select Article_Id,Estimated_Value,Karatage,Weight,Type,image from article where Article_Id=?';
        $this->query($sql);
        $this->bind(1, $id);
        $result = $this->single();

        $sql1 = 'select Pawn_Id,Pawn_Date,Redeemed_Date,End_Date,Article_Id,userId,Appraiser_Id,Officer_Id,auctioned_date from pawn where Article_Id=?';
        $this->query($sql1);
        $this->bind(1, $id);
        $result1 = $this->single();

        $sql2 = 'select PID,Amount,Type,Date,Remarks,Pawn_Id,allocate_Id from payment where Pawn_Id in(select Pawn_Id from pawn where Article_Id=?)';
        // $sql1 ='select p.Pawn_Id,p.Status,p.Pawn_Date,p.Redeemed_Date,p.End_Date,p.Article_Id,p.userId,p.Appraiser_Id,p.Officer_Id,pt.PID,pt.Amount,pt.Type,pt.Date,pt.Remarks,pt.Pawn_Id,pt.allocate_Id from pawn p left join payment pt on p.Pawn_Id=pt.Pawn_Id where p.Article_Id=?';
        $this->query($sql2);
        $this->bind(1, $id);
        $result2 = $this->resultSet();


        return array($result, $result1, $result2);
    }

    public function pawnToAuction($pawnid,$auction_date)
    {
        $sql = 'update pawn set Status=?,auctioned_date=? where Pawn_Id=?';
        $this->query($sql);
        $this->bind(1, "Auction");
        $this->bind(2, $auction_date);
        $this->bind(3, $pawnid);
        $result = $this->execute();
    }

    public function findUserEmail($userid)
    {
        $sql = 'select email from user where UserId=?';
        $this->query($sql);
        $this->bind(1, $userid);
        $result = $this->single();
        if ($result) return $result;
        else return 0;
    }

    public function checkStatus($pawnid)
    {
        $sql = 'select Status from pawn where Pawn_Id=?';
        $this->query($sql);
        $this->bind(1, $pawnid);
        $result = $this->single();

        if ($result->Status == "Auction" || $result->Status == "auction") {
            return true;
        } else {
            return false;
        }
    }

    public function filter($min_price, $max_price, $created_date, $end_date, $karatage, $type, $minWeight, $maxWeight)
    {

        $sql = 'SELECT a.Article_Id, a.Estimated_Value, a.Karatage, a.Weight, a.Type, a.image, p.Pawn_Id, p.Pawn_Date, p.Redeemed_Date, p.End_Date, p.userId 
        FROM article a 
        INNER JOIN pawn p 
        ON a.Article_Id = p.Article_Id 
        WHERE p.Status LIKE "p%" 
        AND p.Status LIKE "P%"'; 

        if ($min_price) {
            $sql .= " AND a.Estimated_Value >= " . intval($min_price); // sanitize input and add to the query
        }

        if ($max_price) {
            $sql .= " AND a.Estimated_Value <= " . intval($max_price); // sanitize input and add to the query
        }

        if ($created_date) {
            $sql .= " AND p.Pawn_Date >= '" . $created_date . "'"; // sanitize input and add to the query
        }

        if ($end_date) {
            $sql .= " AND  p.End_Date <= '" . $end_date . "'"; // sanitize input and add to the query
        }

        if (!empty($karatage)) {
            $sql .= " AND a.Karatage = '$karatage'";
        }

        if (!empty($type)) {
            $sql .= " AND a.Type = '$type'";
        }

        if (!empty($minWeight)) {

            $sql .= " AND a.Weight >= $minWeight";
        }

        if (!empty($maxWeight)) {

            $sql .= " AND a.Weight <= $maxWeight";
        }


        $this->query($sql);

        $result = $this->resultSet();
        if (!empty($result)) {
            return $result;
        } else {
            return 0;
        }
    }



}
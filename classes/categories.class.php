<?php

class Categories extends Dbh{

    private $catUid;
    private $catName;
    
    public function getEveryCategories(){

        $conn = $this->connect();
        $command = "SELECT * FROM categories";
        $result = $conn->query($command);
        $numRows = $result->num_rows;
        if($numRows > 0)
        {
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }
        

        
    }

    public function getCategoryNameById($id){
        $conn = $this->connect();
        $command = "SELECT * FROM categories WHERE categoryUid = ?";
        $stmt = $conn->prepare($command);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $numRows = $result->num_rows;
        if($numRows > 0){
            while($row = $result->fetch_assoc()){
                $data = $row['categoryName'];
            }
            return $data;
        }
    }

    public function getCategoryIdByName($categoryName){
        $conn = $this->connect();
        $command = "SELECT * FROM categories WHERE categoryName= ?";
        $stmt = $conn->prepare($command);
        $stmt->bind_param('s', $categoryName);
        $stmt->execute();
        $result = $stmt->get_result();
        $numRows = $result->num_rows;
        if($numRows > 0){
            while($row = $result->fetch_assoc()){
                $data = $row['categoryUid'];
            }
            return $data;
        }
    }
}
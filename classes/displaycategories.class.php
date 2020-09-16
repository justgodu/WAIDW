<?php

class DisplayCategories extends Categories{

    private $catUid;
    private $catName;
    
    public function displayEveryCategories($HOSTNAME){
        $categories = $this->getEveryCategories();
        
        for($i = 0; $i < count($categories); $i++){ ?>
            <a href="<?php echo $HOSTNAME ?>c/<?php echo $categories[$i]['categoryName']   ?>" ><h3 class="category-title"><?php echo $categories[$i]['categoryName'] ?></h3></a>

        <?php } ?>

        <?php
    }

   
}
?>
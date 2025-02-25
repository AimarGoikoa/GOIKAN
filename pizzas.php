<?php
include "cabecera.php";
?>


    <div class="galeria">
    <?php
    foreach ($pizzas as $pizza) {
        echo "".$pizza['post_title']."  <img src=".$pizza['image_url'].">";
    }
     ?>
    </div>

<?php
include "pie.php"
?>
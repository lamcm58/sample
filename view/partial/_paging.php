<ul class="pagination">
    <?php if ($page>1){ ?>
        <li>
            <a href="index.php?page=<?php echo $page-1;?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
    <?php } ?>
    <?php
    for ($i=1; $i<=$total_page; $i++){
        ?>
        <li <?php if ($i==$page){echo "class='active'";} ?>><a href="index.php?page=<?php echo $i;?>"><?php echo $i;?></a></li>
    <?php } ?>
    <?php if ($page<$total_page){ ?>
        <li>
            <a href="index.php?page=<?php echo $page+1;?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    <?php } ?>
</ul>
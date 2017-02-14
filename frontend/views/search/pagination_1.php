<!--<ul class="pagination pagination-lg">
    <li class="page-item first">
        <a class="page-link" href="#" aria-label="Previous">
            <span aria-hidden="true">Previous</span>
            <span class="sr-only">Previous</span>
        </a>
    </li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">4</a></li>
    <li class="page-item"><a class="page-link" href="#">5</a></li>
    <li class="page-item"><a class="page-link" href="#">6</a></li>
    <li class="page-item"><a class="page-link" href="#">...</a></li>
    <li class="page-item last">
        <a class="page-link" href="#" aria-label="Next">
            <span aria-hidden="true">Next</span>
            <span class="sr-only">Next</span>
        </a>
    </li>
</ul>
-->
<?php
$URL = Yii::$app->request->url;
$Page += 1;
$URL = str_replace("&page=" . $Page, '', $URL);
$total = ceil($TotalRecords / $Limit);
$id = $Page;
if (1) {
    #if($Page ==0)

    $cur_page = $Page;
    $Page -= 1;
    $per_page = $Limit;
    $previous_btn = true;
    $next_btn = true;
    $first_btn = true;
    $last_btn = true;
    $start = $Page * $per_page;

    if ($TotalRecords > $Limit) {
        $no_of_paginations = ceil($TotalRecords / $per_page);
        /* ---------------Calculating the starting and endign values for the loop----------------------------------- */
        if ($cur_page >= 7) {
            $start_loop = $cur_page - 3;
            if ($no_of_paginations > $cur_page + 3)
                $end_loop = $cur_page + 3;
            else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
                $start_loop = $no_of_paginations - 6;
                $end_loop = $no_of_paginations;
            } else {
                $end_loop = $no_of_paginations;
            }
        } else {
            $start_loop = 1;
            if ($no_of_paginations > 7)
                $end_loop = 7;
            else
                $end_loop = $no_of_paginations;
        }
        /* ----------------------------------------------------------------------------------------------------------- */
        $msg .= '<ul class="pagination pagination-lg">';

        // FOR ENABLING THE FIRST BUTTON
        if ($first_btn && $cur_page > 1) {
            #$msg .= "<li p='1' class='active'>First</li>";
        } else if ($first_btn) {
            #$msg .= "<li p='1' class='inactive'>First</li>";
        }

// FOR ENABLING THE PREVIOUS BUTTON
        if ($previous_btn && $cur_page > 1) {
            $pre = $cur_page - 1;
            $msg .= '<li class="page-item first" p="' . $pre . '">
                        <a class="page-link" href="' . $URL . '&page=' . $pre . '" aria-label="Previous">
                            <span aria-hidden="true">Previous</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>';
        }
        for ($i = $start_loop; $i <= $end_loop; $i++) {
            if ($cur_page == $i)
                $msg .= '<li class="page-item active"><a class="page-link" href="' . $URL . '&page=' . $i . '">' . $i . '</a></li>';
            else
                $msg .= '<li class="page-item "><a class="page-link" href="' . $URL . '&page=' . $i . '">' . $i . '</a></li>';
        }

// TO ENABLE THE NEXT BUTTON
        if ($next_btn && $cur_page < $no_of_paginations) {
            $nex = $cur_page + 1;
            #$msg .= "<li p='$nex' class='active'>Next</li>";
            $msg .= '<li class="page-item last">
                                                <a class="page-link" href="' . $URL . '&page=' . $nex . '" aria-label="Next">
                                                    <span aria-hidden="true">Next</span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </li>';
        }
        /*// TO ENABLE THE END BUTTON
        if ($last_btn && $cur_page < $no_of_paginations) {
            $msg .= "<li p='$no_of_paginations' class='active'>Last</li>";
        } else if ($last_btn) {
            $msg .= "<li p='$no_of_paginations' class='inactive'>Last</li>";
        }*/
        #$goto = "<input type='text' class='goto' size='1' style='margin-top:-1px;margin-left:60px;'/><input type='button' id='go_btn' class='go_button' value='Go'/>";
        # $total_string = "<span class='total' a='$no_of_paginations'>Page <b>" . $cur_page . "</b> of <b>$no_of_paginations</b></span>";
        $msg = $msg . "</ul>" . $goto . $total_string . "";  // Content for pagination
    }
    echo $msg;
}







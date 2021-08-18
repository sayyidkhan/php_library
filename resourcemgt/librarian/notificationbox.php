<!-- messagebox setup -->
<?php

//borrow notification
function extendedNotification($extended_modal_id,$resource) {
  function diff_in_days($e,$l) {
      $earlier = new DateTime($e);
      $later = new DateTime($l);

      $abs_diff = $later->diff($earlier)->format("%a");
      return $abs_diff;
  }

  $return_url = RETURN_BOOK;
  $bookID = $resource->bookid;
  $total_regular_cost = number_format(diff_in_days($resource->startdate,$resource->enddate) * $resource->rcost, 2);

  $diff_between_enddate_and_extenddate = diff_in_days($resource->enddate,$resource->extenddate);
  $extend_cost = number_format(intval($diff_between_enddate_and_extenddate) * $resource->ecost, 2);
  $total_cost = number_format(floatval($extend_cost) + floatval($total_regular_cost), 2);

	$message =
	"
            <div id='$extended_modal_id' class='modal-window'>
              <div>
                <a href='#' title='Close' class='modal-close'>Close</a>
                <h2>Extended Borrowing Info 📖⏳⏳</h2>
                <div><b>Book No: </b> $resource->bookno</div>
                <div><b>ISBN: </b> $resource->isbn</div>
                <div><b>Title: </b> $resource->title</div>
                <div><b>Author: </b> $resource->author</div>
                <div><b>Publisher: </b> $resource->publisher</div>
                <div><b>Type: </b> $resource->type</div>
                <div><b>Status: </b> $resource->status</div>

                <div><small style='color: darkgrey;font-size: 15px;'>Cost </small></div>
                <div><b>Daily Cost: </b> $resource->rcost</div>
                <div><b>Overdue Cost:   </b> $resource->ecost</div>
                <br>

                <div><small style='color: darkgrey;font-size: 15px;'>Dates to take note of </small></div>
                <div><b>Start Date: </b> $resource->startdate</div>
                <div><b>End Date:   </b> $resource->enddate</div>
                <div><b>Regular Total Cost:   </b> $total_regular_cost</div>
                <br>

                <div><small style='color: darkgrey;font-size: 15px;'>Overdue Info </small></div>
                <div><b>Extended Date: </b> $resource->extenddate</div>
                <div><b>Extended Cost:   </b> $extend_cost</div>
                <div><b>Overall Cost:   </b> $total_cost</div>
                <br>

                <br>
               </div>
            </div>
	";
	return $message;
}

?>



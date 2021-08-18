<!-- messagebox setup -->
<?php

//borrow notification
function allNotification($all_modal_id,$resource) {
  function diff_in_days($e,$l) {
      $earlier = new DateTime($e);
      $later = new DateTime($l);

      $abs_diff = $later->diff($earlier)->format("%a");
      return $abs_diff;
  }

  function isEmpty($value) {
      return empty($value) ? "N/A" : $value;
  }

  function isZero($value) {
      return floatval($value) > 0 ? number_format($value,2) : '0';
  }

  $bookID = $resource->bookid;
  $total_regular_cost = isZero(number_format(diff_in_days($resource->startdate,$resource->enddate) * $resource->rcost, 2));

  $diff_between_enddate_and_extenddate = diff_in_days($resource->enddate,$resource->extenddate);
  $extend_cost = isZero(number_format(intval($diff_between_enddate_and_extenddate) * $resource->ecost, 2));
  $total_cost = isZero(number_format(floatval($extend_cost) + floatval($total_regular_cost), 2));

  $startdate = isEmpty($resource->startdate);
  $enddate = isEmpty($resource->enddate);
  $extenddate = isEmpty($resource->extenddate);

  $message =
	"
            <div id='$all_modal_id' class='modal-window'>
              <div>
                <a href='#' title='Close' class='modal-close'>Close</a>
                <h2>Book Info 📖</h2>
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
                <div><b>Start Date: </b> $startdate</div>
                <div><b>End Date:   </b> $enddate</div>
                <div><b>Regular Total Cost:   </b> $total_regular_cost</div>
                <br>

                <div><small style='color: darkgrey;font-size: 15px;'>Overdue Info </small></div>
                <div><b>Extended Date: </b> $extenddate</div>
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



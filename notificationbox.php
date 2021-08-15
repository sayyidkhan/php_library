<!-- messagebox setup -->
<?php

//borrow notification
function availableNotification($available_modal_id,$resource) {
	$message = 
	"
            <div id='$available_modal_id' class='modal-window'>
              <div>
                <a href='#' title='Close' class='modal-close'>Close</a>
                <h2>Borrow Book 📖</h2>
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
                <div><b>Start Date: </b> start_date</div>
                <div><b>End Date:   </b> end_date</div>
                <div><b>Total Cost for the period:   </b> total_cost</div>
                <br>

                <!-- eg link to borrow 2 weeks -->
                <!-- eg link to borrow 1 month -->
                <a href=\"$borrow_url?bookid=$bookID\" onClick=\"return confirm('Are you sure you want to borrow book ID: $bookID ?')\">👉 Borrow</a>
               </div>
            </div>
	";
	return $message;
}

//borrow notification
function borrowNotification($borrow_modal_id,$resource) {
	$message = 
	"
            <div id='$borrow_modal_id' class='modal-window'>
              <div>
                <a href='#' title='Close' class='modal-close'>Close</a>
                <h2>Extend Borrowing 📖⏳</h2>
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
                <div><b>Start Date: </b> start_date</div>
                <div><b>End Date:   </b> end_date</div>
                <div><b>Regular Total Cost:   </b> regular_cost</div>
                <br>

                <div><small style='color: darkgrey;font-size: 15px;'>Overdue Info </small></div>
                <div><b>New Extended Date: </b> extended_date</div>
                <div><b>Expected Overdue Cost:   </b> overdue_cost</div>
                <div><b>Exptected Overall Cost:   </b> total_cost</div>
                <br>

                <!-- eg link to extend 2 weeks -->
                <!-- eg link to extend 1 month -->
                <a href=\"$extend_url?bookid=$bookID\" onClick=\"return confirm('Are you sure you want to extend borrowing of book ID: $bookID ?')\">👉 Extend</a>
                <br>
                <a href=\"$return_url?bookid=$bookID\" onClick=\"return confirm('Are you sure you want to return book ID: $bookID ?')\">👉 Return</a>
               </div>
            </div>
	";
	return $message;
}

//borrow notification
function extendedNotification($extended_modal_id,$resource) {
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
                <div><b>Start Date: </b> start_date</div>
                <div><b>End Date:   </b> end_date</div>
                <div><b>Regular Total Cost:   </b> regular_cost</div>
                <br>

                <div><small style='color: darkgrey;font-size: 15px;'>Overdue Info </small></div>
                <div><b>New Extended Date: </b> extended_date</div>
                <div><b>Expected Overdue Cost:   </b> overdue_cost</div>
                <div><b>Exptected Overall Cost:   </b> total_cost</div>
                <br>

                <br>
                <a href=\"$return_url?bookid=$bookID\" onClick=\"return confirm('Are you sure you want to return book ID: $bookID ?')\">👉 Return</a>
               </div>
            </div>
	";
	return $message;
}

?>



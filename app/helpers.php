<?php

use Illuminate\Support\Facades\Session;

function myFlasherBuilder($message, $success = false, $failed = false)
{
    if ($success == true) {
        $status = "success";
        $logo = "check-circle-fill";
    } else if ($failed == true) {
        $status = "danger";
        $logo = "exclamation-triangle-fill";
    }

    Session::flash('message', '<div class="alert alert-' . $status . ' d-flex justify-content-between align-items-center mt-3" role="alert">
        <i class="bi bi-' . $logo . ' me-2" style="font-size:1.5rem"></i>
        <div>' . $message . '</div>
        <button type="button" class="btn-close ms-auto p-2 bd-highlight" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>');
}

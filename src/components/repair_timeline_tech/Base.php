<?php

function echoRequestCreated($ref_number, $start_date, $item_name, $repairDescription) {
    echo '<li style="--accent-color:#080a0d">';
    echo '    <div class="date">✔️ Request created!</div>';
    echo '    <div class="title">';
    echo '        <div style="margin-bottom: 20px;">REF No : ' . htmlspecialchars($ref_number) . '</div>';
    echo '        <div style="margin-bottom: 20px;">Date : ' . htmlspecialchars($start_date) . '</div>';
    echo '        <div style="margin-top: 10px; margin-bottom: 20px;">Item: ' . htmlspecialchars($item_name) . '</div>';
    echo '        <div style="word-wrap: break-word;" class="descr">Description: ' . htmlspecialchars($repairDescription) . '</div>';
    echo '    </div>';
    echo '</li>';
}


function echoTechnicianAssigned($tech_name, $tech_mobile, $tech_date) {
    echo '<li style="--accent-color:#080a0d">';
    echo '    <div class="date">✔️ Technician assigned!</div>';
    echo '    <div style="margin-bottom: 20px;"></div>'; 
    echo '    <div style="margin-bottom: 20px;">Technician Name : ' . htmlspecialchars($tech_name) . '</div>';
    echo '    <div style="margin-bottom: 20px;">Technician Mobile : ' . htmlspecialchars($tech_mobile) . '</div>';
    echo '    <div style="margin-bottom: 20px;">Date : ' . htmlspecialchars($tech_date) . '</div>';
    echo '    <div class="descr">A Technician has been assigned to the Job. Please get into contact</div>';
    echo '</li>';
}


function echoRepairCompleted($repair_start_date, $repair_completed_date) {
    echo '<li style="--accent-color:#080a0d">';
    echo '    <div class="date">✔️ Repair completed!</div>';
    echo '    <div style="margin-bottom: 20px;"></div>'; // If this div is not needed, it can be removed
    echo '    <div style="margin-bottom: 20px;">Repair Start Date : ' . htmlspecialchars($repair_start_date) . '</div>';
    echo '    <div style="margin-bottom: 20px;">Repair Completed Date : ' . htmlspecialchars($repair_completed_date) . '</div>';
    echo '    <div class="descr">Repair has been completed. The item is ready for collection.</div>';
    echo '</li>';
}

function echoPaymentMade($payment_done_date) {
    echo '<li style="--accent-color:#080a0d">';
    echo '    <div class="date">✔️ Payment made!</div>';
    echo '    <div style="margin-bottom: 20px;"></div>'; // If this div is not needed, you can remove it
    echo '    <div style="margin-bottom: 20px;">Date : ' . htmlspecialchars($payment_done_date) . '</div>';
    echo '    <div class="descr">Payment Made! Request completed.</div>';
    echo '</li>';
}




?>
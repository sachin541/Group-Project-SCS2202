<?php

function echoBuildRequestCreated($ref_number, $added_timestamp, $buildDescription) {
    echo '<li style="--accent-color:#080a0d">';
    echo '    <div class="date">✔️ Build request created!</div>';
    echo '    <div class="title">';
    echo '        <div style="margin-bottom: 20px;">REF No : ' . htmlspecialchars($ref_number) . '</div>';
    echo '        <div style="margin-bottom: 20px;">Date : ' . htmlspecialchars($added_timestamp) . '</div>';
    echo '        <div style="word-wrap: break-word;" class="descr">Comments: ' . htmlspecialchars($buildDescription) . '</div>';
    echo '    </div>';
    echo '</li>';
}

function echoTechnicianAssigned($tech_name, $tech_mobile, $tech_assigned_date) {
    echo '<li style="--accent-color:#080a0d">';
    echo '    <div class="date">✔️ Technician assigned!</div>';
    echo '    <div style="margin-bottom: 20px;"></div>'; // This empty div can be removed if it's not needed for spacing or styling
    echo '    <div style="margin-bottom: 20px;">Technician Name : ' . htmlspecialchars($tech_name) . '</div>';
    echo '    <div style="margin-bottom: 20px;">Technician Mobile : ' . htmlspecialchars($tech_mobile) . '</div>';
    echo '    <div style="margin-bottom: 20px;">Date : ' . htmlspecialchars($tech_assigned_date) . '</div>';
    echo '    <div class="descr">A Technician has been assigned to the Job. Please get into contact</div>';
    echo '</li>';
}

function echoBuildCompleted($build_start_date, $build_completed_date) {
    echo '<li style="--accent-color:#080a0d">';
    echo '    <div class="date">✔️ Build completed!</div>';
    echo '    <div style="margin-bottom: 20px;"></div>'; // If this div is not necessary, it can be removed.
    echo '    <div style="margin-bottom: 20px;">Build Start Date : ' . htmlspecialchars($build_start_date) . '</div>';
    echo '    <div style="margin-bottom: 20px;">Build Completed Date : ' . htmlspecialchars($build_completed_date) . '</div>';
    echo '    <div class="descr">The Build has been completed. The item is ready for collection.</div>';
    echo '</li>';
}

function echoPaymentMade($build_collected_date) {
    echo '<li style="--accent-color:#080a0d">';
    echo '    <div class="date">✔️ Payment made!</div>';
    echo '    <div class="title">';
    echo '        <div style="margin-bottom: 20px;"></div>'; // This empty div can be removed if it's not needed for spacing or styling
    echo '        <div style="margin-bottom: 20px;">Date : ' . htmlspecialchars($build_collected_date) . '</div>';
    echo '        <div class="descr">Payment Made! Request completed.</div>';
    echo '    </div>';
    echo '</li>';
}


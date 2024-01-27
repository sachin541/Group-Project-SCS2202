<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Toggle Pages</title>
    <style>
        /* Styling for the toggle switch */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input { 
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
</head>
<body>

<!-- Toggle Switch -->
<label class="switch">
    <input type="checkbox" id="pageToggle">
    <span class="slider round"></span>
</label>

<script>
    document.getElementById('pageToggle').addEventListener('change', function() {
        if (this.checked) {
            window.location.href = 'second_page.php';
        } else {
            window.location.href = 'first_page.php';
        }
    });
</script>

</body>
</html>



<?php 
//
$h1 = 7 ; 
$h2 = 7 ; 
echo $h1 <=> $h2 ; 

//
$var1 = "100";
$var2 = 100;
var_dump($var1 == $var2);
var_dump($var1 === $var2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Slider Value</title>
</head>
<body>
    <form action="handle_slider.php" method="get">
        <label for="amountSlider">Select Amount ($):</label>
        <input type="range" id="amountSlider" name="amount" min="0" max="1000" value="500" step="10">
        <span id="amountValue">$500</span>
        <button type="submit">Submit</button>
    </form>

    <script>
        const slider = document.getElementById('amountSlider');
        const output = document.getElementById('amountValue');

        slider.oninput = function() {
            output.textContent = '$' + this.value;
        }
    </script>
</body>
</html>

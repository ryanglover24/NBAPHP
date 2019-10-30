<?php

if (isset($_POST['submit'])){


    if(isset($_POST['fraction_1'])) {
        $fraction_1 = $_POST['fraction_1'];
        $fraction_2 = $_POST['fraction_2'];
        $fraction_to_percentage = ($fraction_2  / ($fraction_2 + $fraction_1));
        $convert_to_decimal = 1 / $fraction_to_percentage;

        if ($fraction_to_percentage > 0.5) {
            $convert_to_american = (-100 * $fraction_to_percentage) / (1 - $fraction_to_percentage);
           } else if ($fraction_to_percentage < 0.5) {
           $convert_to_american = (100 * (1 - $fraction_to_percentage)) / $fraction_to_percentage;
           }
        else {
           $convert_to_american = 0;
       }
    }

    if(isset($_POST['decimal'])) {
        $decimal = (float) $_POST['decimal'];
        $decimal_to_percentage = 100 / $decimal;

        if ($fraction_to_percentage > 0.5) {
            $convert_to_american = (-100 * $decimal_to_percentage) / (1 - $decimal_to_percentage);
           } else if ($fraction_to_percentage < 0.5) {
           $convert_to_american = (100 * (1 - $decimal_to_percentage)) / $decimal_to_percentage;
           }
        else {
            $decimal_to_percentage = 0;
       }

    //    function float2rat($n, $tolerance = 1.e-6) {
    //     $h1=1; $h2=0;
    //     $k1=0; $k2=1;
    //     $b = 1/$n;
    //     do {
    //         $b = 1/$b;
    //         $a = floor($b);
    //         $aux = $h1; $h1 = $a*$h1+$h2; $h2 = $aux;
    //         $aux = $k1; $k1 = $a*$k1+$k2; $k2 = $aux;
    //         $b = $b-$a;
    //     } while (abs($n-$h1/$k1) > $n*$tolerance);
    
    //     return "$h1/$k1";
    // }
    // $decimal_to_fraction = float2rat($decimal);
    // print_r($decimal_to_fraction);  
    }
    
    

    // $american = $_POST['american'];

    
    // $decimal_to_percentage = 100 / $decimal;
    // if ($american) {
    //     $american_to_percentage = (100  / (100 + $american)) *100;
    // } else {
    //     $american_to_percentage = ($american  / (100 + ($american * -1))) *-100;
    // }

    
}


?>


<section>
    <div class="card">
        <div class="card-content">
            <div class="odds-wrapper">
                <form method='POST'>
                    <label for="">Fraction</label>
                    <input type="number" name="fraction_1" value="">
                    <label for="">/</label>
                    <input type="number" name="fraction_2" value="">
                    <label for="">Decimal</label>
                    <input type="number" name="decimal" value="<?php echo $convert_to_decimal; ?>" step="0.01">
                    <label for="">American</label>
                    <input type="number" name="american" step="0.5" value="<?php echo $convert_to_american; ?>">

                    <input type="submit" name="submit" value="enter">
                </form>

                <div class="form-output">
                    <span></span>
                </div>
            </div>
        </div>
    </div>



</section>




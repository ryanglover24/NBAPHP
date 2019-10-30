<?php 

include ('config/db_connect.php');

if (isset($_POST['bet_win'])) {

    $id_of_bet = mysqli_real_escape_string($connect, $_POST['id_of_bet']);

    $sql = "SELECT * FROM betsmade WHERE id= $id_of_bet";

    $result = mysqli_query($connect, $sql);

    $bet = mysqli_fetch_assoc($result);

    $profit = ($bet['winnings'] - $bet['betsize']);

    $currentProfit = $bet['profit'] + $profit;

    $sql2 = "UPDATE betsmade SET profit= $currentProfit";

    mysqli_query($connect, $sql2);

    $sql3 = "UPDATE betsmade SET is_active= false WHERE id= $id_of_bet";

    mysqli_query($connect, $sql3);

    

} else if (isset($_POST['bet_loss'])) {

    $id_of_bet = mysqli_real_escape_string($connect, $_POST['id_of_bet']);

    $sql = "SELECT * FROM betsmade WHERE id= $id_of_bet";

    $result = mysqli_query($connect, $sql);

    $bet = mysqli_fetch_assoc($result);

    $profit =  -1* $bet['betsize'];

    $currentProfit = $bet['profit'] + $profit;

    $sql2 = "UPDATE betsmade SET profit= $currentProfit";

    mysqli_query($connect, $sql2);

    $sql3 = "UPDATE betsmade SET is_active= false WHERE id= $id_of_bet";

    mysqli_query($connect, $sql3);

    
    
} else {

    $currentProfit = 0;
    
}

if (isset($_POST['reset_profit'])) {
    $sql = "UPDATE betsmade SET profit= 0";

    mysqli_query($connect, $sql);
}

$sql = "SELECT id, teamone, teamtwo, odds, betsize, winnings, is_active FROM betsmade ORDER BY created_at";
//make query and get result
$result = mysqli_query($connect, $sql);

//collect all as arrays
$bets = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result);
mysqli_close($connect);


?>



<html>

    <?php include('display/Navbar.php'); ?>

    
    
    <span>Profit: £<?php echo $currentProfit;?></span>
    <form action="index.php" method="POST">
        <input type="submit" name="reset_profit" value="Reset">
    </form>

    <div class="container-fluid">
        
        <h4>Live Bets:</h4>
        <div class="row">
            <div class="col-8">
                <div class="container-fluid">
                    <div class="row">
                        <?php foreach($bets as $bet) : ?>
                            <?php if ($bet['is_active']) : ?>
                            <div class="col-6 order-1">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($bet['teamone']) . ' VS ' .  htmlspecialchars($bet['teamtwo']) ?></h5>
                                        <p class="card-text">Bet: <?php echo htmlspecialchars($bet['betsize']) . ' With Odds of : ' . htmlspecialchars($bet['odds']) ?></p>
                                        <p class="card-text">To Return: <?php echo htmlspecialchars($bet['winnings']) ?></p>
                                        <div class="card-footer card-footer-links">
                                            <form action="index.php" method="POST">
                                            <span class="card-link"><input type="hidden" name="id_of_bet" value="<?php echo $bet['id']; ?>" ><input type="submit" name="bet_win" value="&#10004;"></span>
                                            <span class="card-link"><input type="hidden" name="id_of_bet" value="<?php echo $bet['id']; ?>" ><input type="submit" name="bet_loss" value="&#10060;"></span>
                                            </form>

                                            <span class="card-link"><a href="info.php?id=<?php echo $bet['id'] ?>" class="info-link">Info/Delete</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <?php endif; ?>
                        <?php endforeach; ?>
                        </div>
                            </div>
                        <h4 class="order-1">Completed Bets:</h4>
                        <div class="container-fluid">
                            <div class="row">
                                <?php foreach($bets as $bet) : ?>
                                <?php if (!$bet['is_active']) : ?>
                                <div class="col-4 order-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo htmlspecialchars($bet['teamone']) . ' VS ' .  htmlspecialchars($bet['teamtwo']) ?></h5>
                                            <p class="card-text">Bet: <?php echo htmlspecialchars($bet['betsize']) . ' With Odds of : ' . htmlspecialchars($bet['odds']) ?></p>
                                            <p class="card-text">To Return: <?php echo htmlspecialchars($bet['winnings']) ?></p>
                                            <div class="card-footer card-footer-links">
                                                <span class="card-link"><a href="info.php?id=<?php echo $bet['id'] ?>" class="info-link">Info/Delete</a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; ?>



                    </div>
                </div>
            </div>
            <div class="col-4">
                <h3>Odds Transformer: (Enter One) </h3>

                <?php include('OddsConvertor.php'); ?>
            
            </div>
        </div>
    </div>    


  
    <?php include('display/Footer.php') ?>

</html>
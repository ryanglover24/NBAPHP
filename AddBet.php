<?php

    include ('config/db_connect.php');
    $teamss = json_decode(file_get_contents("teamsJson.json"), true);
    $teams = $teamss['teamz'];
   
    $odds = $betSize = '';
    $errors = ['odds' => '', 'bet-size' => ''];
    

    if (isset($_POST['submit'])) {

        //check odds aren't empty
        if(empty($_POST['odds'])) {
            $errors['odds'] = 'American Odds are required';
        }
        //check bet size isn't empty
        if(empty($_POST['bet-size'])) {
            $errors['bet-size'] = 'Bet size is required';
        }

        if (!array_filter($errors)) {
            $teamOne = $_POST['team-one'];
            $teamTwo = $_POST['team-two'];
            $odds = $_POST['odds'];
            $betSize = $_POST['bet-size'];
            $winnings;

            if($odds < 0) {
                $winnings = $betSize + ($betSize / (($odds * -1) /100));
            } else {
                $winnings = $betSize + ($betSize * ($odds /100));
            }
            


            //create sql
            $sql = "INSERT INTO betsmade(teamOne,teamTwo,odds,betSize, winnings) VALUES('$teamOne', '$teamTwo', '$odds', '$betSize', '$winnings')";

            //save to db and check

            if(mysqli_query($connect, $sql)) {
                //successful
                header('Location: index.php');
            } else {
                //error
                echo 'Query Error: ' . mysqli_error($connect);
            }
        } else {
            print_r($errors);
        }

    }

    
?>

<html>

    <?php include('display/Navbar.php'); ?>

        <section class="container">
            <h4>Add a bet: </h4>
            <form action="AddBet.php" method="POST">
                <label for="">Team one: </label>
                <select class="js-example-basic-single" name="team-one">
                    <?php foreach($teams as $team) : ?>
                        <option value="<?php echo $team['value']; ?>" ><?php echo $team['team']; ?></option>
                    <?php endforeach; ?>
                    
                </select>
                <label for="">Team Two: </label>
                <select class="js-example-basic-single" name="team-two">
                    <?php foreach ($teams as $team) : ?>
                        <option value="<?php echo $team['value']; ?>" ><?php echo $team['team']; ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="">American Odds: </label>
                <input type="number" name="odds" step="1">
                <label for="">Bet size: </label>
                <input type="number" name="bet-size" step="0.01" action="AddBet.php">

                
                <input type="submit" name="submit" value="submit">
                

            </form>
        </section>

    
    <?php include('display/Footer.php') ?>


</html>
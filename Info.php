<?php
include('config/db_connect.php');

if (isset($_GET['id'])) {

    $id = mysqli_real_escape_string($connect, $_GET['id']);

    $sql = "SELECT * FROM betsmade WHERE id= $id";

    $result = mysqli_query($connect, $sql);

    $bet = mysqli_fetch_assoc($result);

    mysqli_free_result($result);

    mysqli_close($connect);


}

if (isset($_POST['delete'])) {

    $id_to_delete = mysqli_real_escape_string($connect, $_POST['id_to_delete']);

    $sql = "DELETE FROM betsmade WHERE id= $id_to_delete";
 
    if (mysqli_query($connect, $sql)) {
        //query is successful redirect to index.php
        header('Location: index.php');
    } else {
        //query error
        echo 'Error In deletion: ' . mysqli_error($connect);
    }


}



?>



<html>

<?php include('display/Navbar.php'); ?>

    <div class="container">

        <?php if($bet) : ?>

            <h4><?php echo $bet['teamone'] . ' VS ' . $bet['teamtwo']; ?></h4>
            <p>This Bet was For a Total of: £<?php echo $bet['betsize']; ?></p>
            <p>The Odds Of this bet was: <?php echo $bet['odds'] . '<br />'; ?></p>
            <p>This will Return: £<?php echo $bet['winnings']; ?></p>
            
            <form action="Info.php" method="POST">
                <input type="hidden" name="id_to_delete" value="<?php echo $bet['id']; ?>">
                <input type="submit" name="delete" value="Delete Bet">
            </form>

        <?php else: ?>
            <h4>No Bet with this Id exists!</h4>
            

        <?php endif; ?>

    </div>




    </div>







<?php include('display/Footer.php') ?>

</html>
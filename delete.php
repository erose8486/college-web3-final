<?php # Script 3.4 - index.php

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $id = $_GET['id'];
}
require ('./includes/mysqli_connect.php');

$page_title = 'Delete Recipe';
include ('./includes/header.html');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $q = 'DELETE FROM recipes WHERE (recipe_id = '.$id.')';
    $r = @mysqli_query ($dbc, $q);
    if($r){
        echo "<h3 class='success'>Recipe deleted</h3> <a href='recipe_list.php'>Go back to list</a>";
    }else{
        // If it did not run OK.
        
        // Public message:
        echo '<h1>System Error</h1>
        <p class="error">Something went wrong. We apologize for any inconvenience.</p>'; 
        
        // Debugging message:
        echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
       
    }
    exit;
}
?>
<form action="delete.php" method="POST">
    <h3>Are you sure you want to delete this recipe?</h3>
    <p>This action is irreversible</p>
    <input type="hidden" name="id" value="<?= $id?>">
    <button type="submit" class="btn-primary">YES</button><a href="recipe_list.php">Cancel</a>
</form>
<?php
include ('./includes/footer.html');
?>
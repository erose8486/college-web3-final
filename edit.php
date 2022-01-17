<?php # Script 3.4 - index.php
require ('./includes/mysqli_connect.php');

$page_title = 'Edit Recipe';
include ('./includes/header.html');

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $id = $_GET['id'];
    $q = "SELECT recipe_id AS id, title AS title, author AS author, instructions AS instructions FROM recipes WHERE recipe_id = $id";		
    $r = @mysqli_query ($dbc, $q);
    if($r){
        $recipe = mysqli_fetch_array($r, MYSQLI_ASSOC);
        echo '<form method="POST" action="edit.php"><h3>'.$recipe['title'].'<br><small> Author: '.$recipe['author'].'</h3>';
        echo '<input type="hidden" name="id" value="'.$recipe['id'] .'">';
        
         // get ingredients for recipe.
        $q2 = "SELECT ingred_id AS ing_id, ingred_name AS ingredient, amt AS amount FROM ingredients WHERE recipe_id = $id";		
        $i = @mysqli_query ($dbc, $q2); // Run the query.
        if ($i) {
            echo '<h4>Ingredients:</h4>';
            while ($row = mysqli_fetch_array($i, MYSQLI_ASSOC)) {
                echo '<input name="ing['.$row['ing_id'] .'][amt]" value="'.$row['amount'] .'"> <input name="ing['.$row['ing_id'] .'][name]" value="'.$row['ingredient'] .'"><br>';
            }
        } else{
            // Public message:
            echo '<p>Something went wrong. We apologize for any inconvenience.</p>';
            
            // Debugging message:
            echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q2 . '</p>';
        }
        echo '<textarea name="instructions" cols="30" rows="10">'.$recipe['instructions'].'</textarea>';
        echo '<br><button type="submit" class="btn-primary">Save changes</button></form>';
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $instruct = mysqli_real_escape_string($dbc, trim($_POST['instructions']));
    $q = 'UPDATE recipes SET instructions = "'.$instruct.'" WHERE recipe_id = '.$id;
    $r = @mysqli_query ($dbc, $q);
    if($r){
        $ok = true;
        foreach ($_POST['ing'] as $iid=>$ing) {
            $q2 = 'UPDATE ingredients SET amt = "'.$ing['amt'].'", ingred_name = "'.$ing['name'].'" WHERE ingred_id = '.$iid;
            $r2 = @mysqli_query ($dbc, $q2);
            if(!$r2){
                $ok = false;
                $error = $q2;
            }
        }
        if($ok){
            echo "<h3 class='success'>Recipe updated</h3><a class='btn-secondary' href='view-recipe.php?id=".$id."'>Back to recipe</a>";
        }else{
            // If it did not run OK.
            
            // Public message:
            echo '<h1>System Error</h1>
            <p class="error">Something went wrong. We apologize for any inconvenience.</p>'; 
            
            // Debugging message:
            echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $error . '</p>';
        
        }
    }else{
        // If it did not run OK.
        
        // Public message:
        echo '<h1>System Error</h1>
        <p class="error">Something went wrong. We apologize for any inconvenience.</p>'; 
        
        // Debugging message:
        echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
       
    }
}
include ('./includes/footer.html');
?>
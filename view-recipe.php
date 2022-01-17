<?php # Script 3.4 - index.php

$id = $_GET['id'];
require ('./includes/mysqli_connect.php');

$page_title = 'Recipe '.$id;
include ('./includes/header.html');

$q = "SELECT recipe_id AS id, title AS title, author AS author, instructions AS instructions, DATE_FORMAT(date_added, '%M %d, %Y') AS d FROM recipes WHERE recipe_id = $id";		
$r = @mysqli_query ($dbc, $q); // Run the query.

if ($r) { // If it ran OK, display the record.
    $recipe = mysqli_fetch_array($r, MYSQLI_ASSOC);
    echo '<h3>'.$recipe['title'].'<br><small> Author: '.$recipe['author'].', Added on: '.$recipe['d'].' <a href="edit.php?id='.$recipe['id'].'"><i class="far fa-edit"></i> Edit</a></small>';

    $q2 = "SELECT ingred_name AS ingredient, amt AS amount FROM ingredients WHERE recipe_id = $id";		
    $i = @mysqli_query ($dbc, $q2); // Run the query.

    if ($i) { // get ingredients for recipe.
        echo '<h4>Ingredients:</h4><ul id="ingredients">';
        while ($row = mysqli_fetch_array($i, MYSQLI_ASSOC)) {
            echo '<li>'.$row['amount'] .' ' . $row['ingredient'].'</li>';
        }
        echo '</ul>';
    } else{
        // Public message:
        echo '<p>Something went wrong. We apologize for any inconvenience.</p>';
        
        // Debugging message:
        echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q2 . '</p>';
    }
    echo '<h4>Instructions:</h4> <p id="recipe-instructions">'.$recipe['instructions'].'</p>';
	
	mysqli_free_result ($r); // Free up the resources.	

} else { // If it did not run OK.

	// Public message:
	echo '<p>Something went wrong. We apologize for any inconvenience.</p>';
	
	// Debugging message:
	echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
	
} // End of if ($r) IF.

mysqli_close($dbc); // Close the database connection.
        

include ('./includes/footer.html');
?>
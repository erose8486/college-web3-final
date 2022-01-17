<?php # Script 3.4 - index.php
$page_title = 'Add recipe';
include ('./includes/header.html');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require ('./includes/mysqli_connect.php');

    $author = mysqli_real_escape_string($dbc, trim($_POST['author']));
    $title = mysqli_real_escape_string($dbc, trim($_POST['title']));
    $instruct = mysqli_real_escape_string($dbc, trim($_POST['instructions']));
    $ingredients = $_POST['ingredients'];


    $q = "INSERT INTO recipes (author, title, instructions, date_added) VALUES ('$author', '$title', '$instruct', NOW() )";		
    $r = @mysqli_query ($dbc, $q);
    if ($r) { // If it ran OK.
        $id = mysqli_insert_id($dbc);//get last added id
		foreach ($ingredients as $i) {//add ingredients
            $name = $i["iName"];
            $amt = $i["amt"];
            $q3 = "INSERT INTO ingredients (ingred_name, amt, recipe_id) VALUES ('$name', '$amt', '$id' )";		
            $i = @mysqli_query ($dbc, $q3);
        }
        // Print a message:
        echo '<h3 class="success">Recipe Added!</h3>';	
    
    } else { // If it did not run OK.
        
        // Public message:
        echo '<h1>System Error</h1>
        <p class="error">Something went wrong. We apologize for any inconvenience.</p>'; 
        
        // Debugging message:
        echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
                    
    } // End of if ($r) IF.
    
    mysqli_close($dbc); // Close the database connection.

}
?>

<form action="add.php" method="POST">
    <label>Recipe Name: </label> <input type="text" name="title"><br>
    <label>Author: </label> <input type="text" name="author"><br>
    <label>Ingredients: </label>
    <div id="ing">Amount: <input type="text" name="ingredients[0][amt]"> Ingredient: <input type="text" name="ingredients[0][iName]"> </div>
    <button type="button" onclick="addIng()" class="btn-secondary">add ingredient</button><br>
    <label>Instructions: </label> <br>
    <textarea name="instructions" cols="30" rows="10"></textarea><br>
    <button type="submit" class="btn-primary">ADD RECIPE</button>
</form>
<script>
    var num = 0;
    function addIng(){
        num++;
        $('#ing').append('<br>Amount: <input type="text" name="ingredients['+num+'][amt]"> Ingredient: <input type="text" name="ingredients['+num+'][iName]">')
    }
</script>
<?php
include ('./includes/footer.html');
?>
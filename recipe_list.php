<?php # Script 3.4 - index.php
$page_title = 'Recipes';
include ('./includes/header.html');
?>
<h3>Sort by: 
<a href="recipe_list.php?sort=date_added" class="btn-secondary">Date</a>
<a href="recipe_list.php?sort=author" class="btn-secondary">Author</a>
<a href="recipe_list.php?sort=title" class="btn-secondary">Name</a>
</h3>
<?php
require ('./includes/mysqli_connect.php'); // Connect to the db.

if (isset($_GET['sort'])){
    $sort = $_GET['sort'];
}else{
    $sort = 'title';
}
// Make the query:
$q = "SELECT recipe_id AS id, title AS title, author AS author, DATE_FORMAT(date_added, '%M %d, %Y') AS d FROM recipes ORDER BY ".$sort." ASC";		
$r = @mysqli_query ($dbc, $q); // Run the query.

if ($r) { // If it ran OK, display the records.

	// Table header.
	echo '<table>
	<tr><th>Recipe Name</th><th>Author</th><th>Date Added</th><th>Delete Recipe</th></tr>';
	
	// Fetch and print all the records:
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		echo '<tr><td><a href="view-recipe.php?id='. $row['id'] .'">' . $row['title'] . '</a></td><td>' . $row['author'] . '</td><td>' . $row['d'] . '</td><td><a class="error" href="delete.php?id='.$row['id'].'"><i class="fas fa-trash-alt"></i></a></td></tr>';
	}

	echo '</table>'; // Close the table.
	
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
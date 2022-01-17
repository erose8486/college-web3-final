CREATE TABLE recipes (
    recipe_id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(50) NOT NULL,
    author VARCHAR(50) NOT NULL,
    instructions VARCHAR(255) NOT NULL,
    date_added DATETIME NOT NULL,
    PRIMARY KEY (recipe_id)
);
CREATE TABLE ingredients (
    ingred_id INT NOT NULL AUTO_INCREMENT,
    recipe_id INT NOT NULL,
    ingred_name VARCHAR(20) NOT NULL,
    amt VARCHAR(20) NOT NULL,
    PRIMARY KEY (ingred_id),
    FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id)
);
<?php
    class Category
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function getId()
        {
            return $this->id;
        }

        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }

        function save() //takes category entered into the form and saves it into the to_do database inside the category table
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO categories (name) VALUES ('{$this->getName()}') RETURNING id;");
            //connects to database named in [''] and inserts into the column name in the table categories the name assigned to this object.Returns the id assigned by serial PRIMARY KEY.
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            //Calls the fetch method on everything stored in $statement (), creating an associative array with a key of "id" and an assigned value from the table.  All of this is stored in the variable $result.
            $this->setId($result['id']);
            //Put in whatever is in the key "id" in the $result array and run the setId method on it. Allows getId to access the "id" returned above.
        }

        static function getAll() //loops through each item in the table categories and grabs the name and id and makes a new instance of Category, which is pushed into array $categories and returned for use later.
        {
            $returned_categories = $GLOBALS['DB']->query("SELECT * FROM categories;");
            //takes everything from the table categories and stores it in $returned_categories
            $categories = array();
            //creates empty array to push into from the loop
            foreach($returned_categories as $category) {
                //loops through each item from the table categories (stored in $returned_categories)
                $name = $category['name'];
                //storing the value from the key 'name' to $name
                $id = $category['id'];
                //storing the value from the key 'id' to $id
                $new_category = new Category($name, $id);
                //creates new instance of Category with the arguments stored from name and id
                array_push($categories, $new_category);
                //pushes new instance into the empty array $categories
            }
            return $categories;
        }

        static function deleteAll()//removes all items from table categories in the database DB
        {
          $GLOBALS['DB']->exec("DELETE FROM categories *;");
        }

        static function find($search_id)// Takes number as argument and calls the getall method and loops throught the getAll array and if the search_id matches the id from any of the Category items, it assigns it to $found_category and returns it.  Otherwise will return null.
        {
            $found_category = null;
            // Creates a variable $found_category and makes it null.
            $categories = Category::getAll();
            //calls the getAll method on category and stores all returns (that are associative array)  into variable $categories
            foreach($categories as $category) {
                //loops though $categories
                $category_id = $category->getId();
                // calls getId on each item in Category and stores result in $category_id
                if ($category_id == $search_id) {

                // if the $category_id  is the same as the id entered to search for.
                  $found_category = $category;

                  // assigns in to $found_category
                }
            }

            return $found_category;
        }
    }
?>

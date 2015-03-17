<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Category.php";

    $DB = new PDO('pgsql:host=localhost;dbname=to_do_test');


    class CategoryTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown() // clears every test after it runs
        {
          Category::deleteAll();
        }

        function test_getName() // instantiates a new Category using the input assigned by $name and $id. calls getName method on it and checks to see if it returns the same name as assigned.
        {
            //Arrange
            $name = "Work stuff";
            $id = null;
            $test_Category = new Category($name, $id);

            //Act
            $result = $test_Category->getName();

            //Assert
            $this->assertEquals("Work stuff", $result);
        }

        function test_getId() // same as test_getName, but checks id instead
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_Category = new Category($name, $id);

            //Act
            $result = $test_Category->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function test_setId() // sets id and then calls getId to make sure it's the same
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_Category = new Category($name, $id);

            //Act
            $test_Category->setId(2);

            //Assert
            $result = $test_Category->getId();
            $this->assertEquals(2, $result);
        }

        function test_save() // instantiates a new Category using the input assigned and calls the save method on it. Then Calls the getAll method and compares the first object is equal to the      instantiated category.
        {
            //Arrange
            $name = "Work stuff";
            $id = null;
            $test_Category = new Category($name, $id);
            $test_Category->save();

            //Act
            $result = Category::getAll();

            //Assert
            $this->assertEquals($test_Category, $result[0]);
        }

        function test_getAll()  // instantiates two new instances of Category, calls the getAll method and checks to be sure the objects entered match those in getAll
        {
            //Arrange
            $name = "Work stuff";
            $id = null;
            $name2 = "Home stuff";
            $id2 = null;
            $test_Category = new Category($name, $id);
            $test_Category->save();
            $test_Category2 = new Category($name2, $id2);
            $test_Category2->save();

            //Act
            $result = Category::getAll();

            //Assert
            $this->assertEquals([$test_Category, $test_Category2], $result);
        }

        function test_deleteAll() // Adds new categories, calls the deleteAll method to remove them, then makes sure the result of getAll is empty
        {
            //Arrange
            $name = "Wash the dog";
            $id = null;
            $name2 = "Home stuff";
            $id2 = null;
            $test_Category = new Category($name, $id);
            $test_Category->save();
            $test_Category2 = new Category($name2, $id2);
            $test_Category2->save();

            //Act
            Category::deleteAll();
            $result = Category::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find() //Adds and saves new categories.  Then calls the find method on Category (by calling the getId method on the first Category object) and stores it in the variable $result.  Compares with inital instance of the Category ($test_Category)
        {
            //Arrange
            $name = "Wash the dog";
            $id = null;
            $name2 = "Home stuff";
            $id2 = 2;
            $test_Category = new Category($name, $id);
            $test_Category->save();
            $test_Category2 = new Category($name2, $id2);
            var_dump($test_Category2->save());

            //Act
            $id_to_find=$test_Category2->getId();
            $result = Category::find($id_to_find);
            var_dump($result);


            //Assert
            $this->assertEquals($test_Category2, $result);
        }
    }

?>

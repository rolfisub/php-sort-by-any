<?php
require_once "./src/Entity/SortInput.php";
require_once "./src/SortByAny.php";

use PHPUnit\Framework\TestCase;

/**
 *  Corresponding Class to test SortByAny class
 *
 *  For each class in your library, there should be a corresponding Unit-Test for it
 *  Unit-Tests should be as much as possible independent from other test going on.
 *
 * @author yourname
 */
class SortByAnyTest extends TestCase
{

    /**
     * Just check if the SortByAny has no syntax error
     *
     * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
     * any typo before you even use this library in a real project.
     *
     */
    public function testIsThereAnySyntaxError()
    {
        $var = new \Rolfisub\SortByAny\SortByAny();
        $this->assertTrue(is_object($var));
        unset($var);
    }

    public function testEmptyInputError()
    {
        try {
            $sba = new \Rolfisub\SortByAny\SortByAny();
            $sba->sortByAny([]);
            //fail the test
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertTrue(is_object($e));
        }
    }

    public function testMinimumArraySize()
    {
        $a = [1];
        $si = new \Rolfisub\SortByAny\Entity\SortInput(["test"]);
        $sba = new \Rolfisub\SortByAny\SortByAny($si);
        try{
            $sba->sortByAny($a);
            //fail the test
            $this->assertTrue(false);
        }catch (\Exception $e) {
            $this->assertTrue(is_object($e));
        }
    }
}

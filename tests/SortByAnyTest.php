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

    public function testMinimumArraySizeError()
    {
        $a = [1];
        $si = new \Rolfisub\SortByAny\Entity\SortInput(["test"]);
        $sba = new \Rolfisub\SortByAny\SortByAny($si);
        try {
            $sba->sortByAny($a);
            //fail the test
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertTrue(is_object($e));
        }
    }

    public function testSortOrder()
    {
        $si = new \Rolfisub\SortByAny\Entity\SortInput();
        $sba = new \Rolfisub\SortByAny\SortByAny();

        //test basic asc sort
        $a1 = [
            [
                "a" => 2
            ],
            [
                "a" => 1
            ]
        ];
        $e1 = [
            [
                "a" => 1
            ],
            [
                "a" => 2
            ]
        ];
        $e2 = [
            [
                "a" => 2
            ],
            [
                "a" => 1
            ]
        ];

        //test asc order
        $si->setFields(["a"])->setOrder("asc");
        $sba->setSortInput($si);
        $res1 = $sba->sortByAny($a1);
        $this->assertEquals($e1, $res1);

        //test desc order
        $si->setOrder("desc");
        $res2 = $sba->sortByAny($a1);
        $this->assertEquals($e2, $res2);

    }

    public function testAnyLevelSort()
    {
        $a1 = [
            [
                "a" => 9,
                [
                    "b" => 4,
                    [
                        "c" => 0
                    ]
                ]
            ],
            [
                "a" => 8,
                [
                    "b" => 2,
                    [
                        "c" => -8
                    ]
                ]
            ],
            [
                "a" => 30,
                [
                    "b" => 1,
                    [
                        "c" => 4
                    ]
                ]
            ],
        ];

        $e1 = [
            [
                "a" => 30,
                [
                    "b" => 1,
                    [
                        "c" => 4
                    ]
                ]
            ],
            [
                "a" => 8,
                [
                    "b" => 2,
                    [
                        "c" => -8
                    ]
                ]
            ],
            [
                "a" => 9,
                [
                    "b" => 4,
                    [
                        "c" => 0
                    ]
                ]
            ],
        ];
        $si = new \Rolfisub\SortByAny\Entity\SortInput();
        $sba = new \Rolfisub\SortByAny\SortByAny();
        //test level 1 asc order
        $si->setFields(["b"])->setOrder("asc");
        $sba->setSortInput($si);
        $res1 = $sba->sortByAny($a1);
        $this->assertEquals($e1, $res1);

        $e2 = [
            [
                "a" => 30,
                [
                    "b" => 1,
                    [
                        "c" => 4
                    ]
                ]
            ],
            [
                "a" => 9,
                [
                    "b" => 4,
                    [
                        "c" => 0
                    ]
                ]
            ],
            [
                "a" => 8,
                [
                    "b" => 2,
                    [
                        "c" => -8
                    ]
                ]
            ],
        ];

        //test level 2 desc order
        $si->setFields(["c"])->setOrder("desc");
        $sba->setSortInput($si);
        $res2 = $sba->sortByAny($a1);
        $this->assertEquals($e2, $res2);

    }

    public function testSecondaryField()
    {
        $si = new \Rolfisub\SortByAny\Entity\SortInput();
        $sba = new \Rolfisub\SortByAny\SortByAny();

        $a1 = [
            [
                "a" => 2,
                [
                    "b" => 2
                ]
            ],
            [
                "a" => 2,
                [
                    "b" => 1
                ]
            ]
        ];
        $e1 = [
            [
                "a" => 2,
                [
                    "b" => 1
                ]
            ],
            [
                "a" => 2,
                [
                    "b" => 2
                ]
            ],
        ];

        //test secondary field asc
        $si->setFields(["a", "b"]);
        $sba->setSortInput($si);
        $res1 = $sba->sortByAny($a1);
        $this->assertEquals($e1, $res1);

    }

    public function testExceptionSupportedFields()
    {
        $a1 = [
            [
                "a"=> 4,
                [
                    "b"=> 5,
                    "c"=> 4,
                    "d"=> 5,
                    "w"=> 6,
                    "o"=> 9
                ]
            ],
            [
                "a"=> 4,
                [
                    "b"=> 5,
                    "c"=> 4,
                    "d"=> 5,
                    "w"=> 6,
                    "o"=> 9
                ]
            ]
        ];
        $si = new \Rolfisub\SortByAny\Entity\SortInput();
        $sba = new \Rolfisub\SortByAny\SortByAny();
        $si->setFields(["a", "b", "c", "d", "w"]);
        $sba->setSortInput($si);

        try {
            $sba->sortByAny($a1);
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertTrue(is_object($e));
        }

    }

}

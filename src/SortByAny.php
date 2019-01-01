<?php

namespace Rolfisub\SortByAny;

use Rolfisub\SortByAny\Entity\SortInput;
use Rolfisub\ArrayFlatten\ArrayFlatten;

/**
 * Class SortByAny
 * @package Rolfisub\SortByAny
 * @author Rolf Bansbach rolfisub@gmail.com
 */
class SortByAny
{

    /**
     * @var SortInput
     */
    private $sortInput;

    /**
     * SortByAny constructor.
     * @param SortInput|null $sortInput
     */
    public function __construct(SortInput $sortInput = null)
    {
        if (is_object($sortInput)) {
            $this->setSortInput($sortInput);
        } else {
            $this->setSortInput(new SortInput());
        }
    }

    /**
     * @param SortInput $sortInput
     */
    public function setSortInput(SortInput $sortInput)
    {
        $this->sortInput = $sortInput;
    }

    /**
     * @param array $d
     * @return array
     */
    private function getFlattenedArray(array $d)
    {
        return array_map(function ($a) {
            return ArrayFlatten::flatten($a);
        }, $d);
    }

    /**
     * @param array $d
     * @return array
     * @throws \Exception
     */
    public function sortByAny(array $d)
    {
        $fields = $this->sortInput->getFields();

        if (sizeof($fields) < 1) {
            throw new \Exception("Need to sort at least by one field");
        }
        if (sizeof($d) < 2) {
            throw new \Exception("Array to be sorted needs to be contain at least 2 items.");
        }

        $fd = $this->getFlattenedArray($d);

        $order = $this->sortInput->getOrder() === 'asc' ? SORT_ASC : SORT_DESC;
        $args = [];

        foreach ($fields as $k => $f) {
            array_push($args, array_column($fd, $f));
            array_push($args, $order);
        }

        $argsCount = sizeof($args);
        /**
         * support up to 5 fields
         */
        switch ($argsCount) {
            case 2:
                {
                    array_multisort($args[0], $args[1], $d);
                    return $d;
                }
            case 4:
                {
                    array_multisort(
                        $args[0],
                        $args[1],
                        $args[2],
                        $args[3],
                        $d
                    );
                    return $d;
                }
            case 6:
                {
                    array_multisort(
                        $args[0],
                        $args[1],
                        $args[2],
                        $args[3],
                        $args[4],
                        $args[5],
                        $d
                    );
                    return $d;
                }
            case 8:
                {
                    array_multisort(
                        $args[0],
                        $args[1],
                        $args[2],
                        $args[3],
                        $args[4],
                        $args[5],
                        $args[6],
                        $args[7],
                        $d
                    );
                    return $d;
                }
            case 10:
                {
                    array_multisort(
                        $args[0],
                        $args[1],
                        $args[2],
                        $args[3],
                        $args[4],
                        $args[5],
                        $args[6],
                        $args[7],
                        $args[8],
                        $args[9],
                        $d
                    );
                    return $d;
                }
            default:
                {
                    throw new \Exception("invalid amount of arguments passed to sort function");
                }
        }
    }
}
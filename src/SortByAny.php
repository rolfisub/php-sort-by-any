<?php

namespace Rolfisub\SortByAny;


use Rolfisub\SortByAny\Entity\SortInput;

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
     * @param array $a
     * @return array
     */
    private function flattenArray(array $a)
    {
        $r = [];
        foreach ($a as $key => $value) {
            if (!is_array($value)) {
                $r[$key] = $value;
            } else {
                array_merge($r, $this->flattenArray($value));
            }
        }
        return $r;
    }


    /**
     * @param array $d
     * @return array
     */
    private function getFlattenedArray(array $d)
    {
        $r = [];
        foreach ($d as $key => $value) {
            array_push($r, $this->flattenArray($value));
        }
        return $r;
    }

    /**
     * @param array $d
     * @throws \Exception
     */
    public function sortByAny(array $d)
    {
        if (sizeof($this->sortInput->getFields()) < 1) {
            throw new \Exception("Need to sort at least by one field");
        }
        if (sizeof($d) < 2) {
            throw new \Exception("Array to be sorted needs to be contain at least 2 items.");
        }

        $fd = $this->getFlattenedArray($d);

        var_dump($fd);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: rolf
 * Date: 12/30/18
 * Time: 11:13 PM
 */

namespace Rolfisub\SortByAny\Entity;


class SortInput
{
    private $fields = [];
    private $order = "asc";

    public function __construct(array $fields = [], $order = 'asc')
    {
        $this->setFields($fields);
        $this->setOrder($order);
    }

    public function setFields(array $fields)
    {
        $this->fields = $fields;
        return $this;
    }

    public function addField($field)
    {
        array_push($this->fields, $field);
        return $this;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function setOrder($order)
    {
        if ($order === 'asc' || $order === 'desc') {
            $this->order = $order;
        }
        return $this;
    }

    public function getOrder()
    {
        return $this->order;
    }
}
<?php


class Discount extends Eloquent {

    protected $table = 'discounts';

    /**
     * This is force for primary key be different then id
     *
     * @var string
     */
    protected $primaryKey = 'code';

    protected $fillable = [];
}
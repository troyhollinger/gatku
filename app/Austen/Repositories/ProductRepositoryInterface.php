<?php 


namespace Austen\Repositories;


interface ProductRepositoryInterface {

	public function getAll();

	public function find($id);

	public function store($input);


}
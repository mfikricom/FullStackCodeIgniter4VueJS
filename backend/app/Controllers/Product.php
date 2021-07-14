<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModel;

class Product extends ResourceController
{
	/**
	 * Return an array of resource objects, themselves in array format
	 *
	 * @return mixed
	 */
	use ResponseTrait;
	public function index()
	{
		$model = new ProductModel();
		$data = $model->findAll();
		if(!$data) return $this->failNotFound('Data Tidak Ditemukan');
		return $this->respond($data);
	}

	/**
	 * Return the properties of a resource object
	 *
	 * @return mixed
	 */
	public function show($id = null)
	{
		$model = new ProductModel();
		$data = $model->find(['id' => $id]);
		if(!$data) return $this->failNotFound('Data Tidak Ditemukan');
		return $this->respond($data[0]);
	}


	/**
	 * Create a new resource object, from "posted" parameters
	 *
	 * @return mixed
	 */
	public function create()
	{
		$json = $this->request->getJSON();
		$data = [
			'title' => $json->title,
			'price' => $json->price
		];
		$model = new ProductModel();
		$product = $model->insert($data);
		if(!$product) return $this->fail('Gagal tersimpan', 400);
		return $this->respondCreated($product);
	}


	/**
	 * Add or update a model resource, from "posted" properties
	 *
	 * @return mixed
	 */
	public function update($id = null)
	{
		$json = $this->request->getJSON();
		$data = [
			'title' => $json->title,
			'price' => $json->price
		];
		$model = new ProductModel();
		$cekId = $model->find(['id' => $id]);
		if(!$cekId) return $this->fail('Data Tidak ditemukan', 404);
		$product = $model->update($id, $data);
		if(!$product) return $this->fail('Gagal terupdate', 400);
		return $this->respond($product);
	}

	/**
	 * Delete the designated resource object from the model
	 *
	 * @return mixed
	 */
	public function delete($id = null)
	{
		$model = new ProductModel();
		$cekId = $model->find(['id' => $id]);
		if(!$cekId) return $this->fail('Data Tidak ditemukan', 404);
		$product = $model->delete($id);
		if(!$product) return $this->fail('Gagal terhapus', 400);
		return $this->respondDeleted('Data Berhasil Terhapus');
	}
}

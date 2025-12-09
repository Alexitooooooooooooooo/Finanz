<?php
    
namespace App\Repositories;

use App\Models\Contact;

class ContactRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Contact();
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data): Contact
    {
        return $this->model->create($data);
    }

    public function find(int $id): ?Contact
    {
        return $this->model->find($id);
    }

    public function update(int $id, array $data): ?Contact
    {
        $contact = $this->find($id);
        if ($contact) {
            $contact->update($data);
        }
        return $contact;
    }

    public function delete(int $id): bool
    {
        $contact = $this->find($id);
        if ($contact) {
            return $contact->delete();
        }
        return false;
    }
}
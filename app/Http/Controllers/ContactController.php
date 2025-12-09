<?php

namespace App\Http\Controllers;

use App\Repositories\ContactRepository;
use Illuminate\Http\Request;
use App\Http\Request\Contact\ContactCreateRequest;
use App\Http\Request\Contact\ContactUpdateRequest;
use App\Http\Resources\ContactResource;

class ContactController extends Controller
{
    protected $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function index()
    {
        $contacts = $this->contactRepository->all();
        return ContactResource::collection($contacts);
    }

    public function store(ContactCreateRequest $request)
    {
        $contact = $this->contactRepository->create($request->validated());
        return new ContactResource($contact);
    }

    public function show($id)
    {
        $contact = $this->contactRepository->find($id);
        return new ContactResource($contact);
    }

    public function update(ContactUpdateRequest $request, $id)
    {
        $contact = $this->contactRepository->update($id, $request->validated());
        return new ContactResource($contact);
    }

    public function destroy($id)
    {
        $contact = $this->contactRepository->delete($id);
        return response()->json($contact);
    }
}

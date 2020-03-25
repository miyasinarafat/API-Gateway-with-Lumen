<?php

namespace App\Http\Controllers;

use App\Services\AuthorService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Http\ResponseFactory;

class AuthorController extends Controller
{
    use ApiResponse;

    public $authorService;

    /**
     * AuthorController constructor.
     * @param AuthorService $authorService
     */
    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * list of authors
     * @return Response|ResponseFactory
     */
    public function index()
    {
        return $this->successResponse($this->authorService->getAuthors());
    }

    /**
     *  create new author
     * @param Request $request
     * @return Response|ResponseFactory
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->authorService->createAuthor($request->all()), 201);
    }

    /**
     *  show author profile
     * @param $author
     * @return Response|ResponseFactory
     */
    public function show($author)
    {
        return $this->successResponse($this->authorService->getAuthor($author));
    }

    /**
     * update author info
     * @param Request $request
     * @param $author
     * @return Response|ResponseFactory
     */
    public function update(Request $request, $author)
    {
        return $this->successResponse($this->authorService->editAuthor($request->all(), $author));
    }

    /**
     * remove author
     * @param $author
     * @return Response|ResponseFactory
     */
    public function destroy($author)
    {
        return $this->successResponse($this->authorService->deleteAuthor($author));
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\AuthorService;
use App\Services\BookService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Http\ResponseFactory;

class BookController extends Controller
{
    use ApiResponse;

    public $bookService;
    public $authorService;

    public function __construct(BookService $bookService, AuthorService $authorService)
    {
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

    /**
     * list of books
     * @return Response|ResponseFactory
     */
    public function index()
    {
        return $this->successResponse($this->bookService->getBooks());
    }

    /**
     *  create new book
     * @param Request $request
     * @return Response|ResponseFactory
     */
    public function store(Request $request)
    {
        $this->authorService->getAuthor($request->author_id);

        return $this->successResponse($this->bookService->createBook($request->all()), 201);
    }

    /**
     *  show book profile
     * @param $book
     * @return Response|ResponseFactory
     */
    public function show($book)
    {
        return $this->successResponse($this->bookService->getBook($book));
    }

    /**
     * update book info
     * @param Request $request
     * @param $book
     * @return Response|ResponseFactory
     */
    public function update(Request $request, $book)
    {
        return $this->successResponse($this->bookService->editBook($request->all(), $book));
    }

    /**
     * remove book
     * @param $book
     * @return Response|ResponseFactory
     */
    public function destroy($book)
    {
        return $this->successResponse($this->bookService->deleteBook($book));
    }
}

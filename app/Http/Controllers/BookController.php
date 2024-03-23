<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        $title = $req->input('title');
        $filter = $req->input('filter','');

        $books = Book::when($title, function (Builder $query, $title) {
            return $query->title($title);
        });

        $books = match($filter){
                 
                "" => $books->latest(),
                "popular_last_month" => $books->popularLastMonth(),
                "popular_last_6month" => $books->popularLast6Month(),
                "highest_rated_last_month" => $books->highestRatedLastMonth(),
                "highest_rated_last_6month" => $books->highestRatedLast6Month(),
                default => $books->latest(),
            
        };
       
        return view('books.index', ['books' => $books->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
$cacheKey = 'book:' . $book->id;
$book =cache()->remember($cacheKey,3600,fn()=>$book->load(['reviews'=>fn($query)=>$query->latest()]));
       return view('books.show',['book'=>$book]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

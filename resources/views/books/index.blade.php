        @extends('layouts.app')

        @section('content')
            <h1 class="mb-10 text-2xl">Books</h1>
            <form class="flex gap-3 pr-2 my-3 justify-center align-middle items-center" method="GET" action="{{route('books.index')}}">
            <input class='input h-10' type="text" name="title" placeholder="Search by title" value="{{request('title')}}"/>
            <input hidden name="filter" value="{{request('filter')}}"/>
            <button class='btn h-10' type="submit">Search</button>
            <a class="btn h-10" href="{{route('books.index')}}">Clear</a>
            </form>
            <div class="filter-container mb-3 flex">
                @php
                    $filters =[
                        ""=>'Latest',
                        "popular_last_month"=>"Popular last month",
                        "popular_last_6month"=>"Popular last 6 months",
                        "highest_rated_last_month"=>"Highest rated last month",
                        "highest_rated_last_6month"=>"Highest rated last 6 months",
                    ]; 
                @endphp
                @foreach ($filters as $key=> $label)
                    <a href="{{route('books.index',[...request()->query(),'filter'=>$key])}}" class="{{request('filter')== $key ? "filter-item-active":"filter-item"}}">
                        {{$label}}
                    </a>
                @endforeach
            </div>
            <ul> 
            @forelse ($books as $book)
            <li class="mb-4">
        <div class="book-item">
            <div
            class="flex flex-wrap items-center justify-between">
            <div class="w-full flex-grow sm:w-auto">
                <a href="{{route('books.show',$book)}}" class="book-title">{{$book->title}}</a>
                <span class="book-author">by {{$book->author}}</span>
            </div>
            <div>
                <div class="book-rating">
                {{number_format($book->reviews_avg_rating,1)}}
                </div>
                <div class="book-review-count">
                out of {{$book->reviews_count}} {{Str::plural('review',$book->reviews_count)}}
                </div>
            </div>
            </div>
        </div>
        </li>
        
    @empty
    <li class="mb-4">
    <div class="empty-book-item">
        <p class="empty-text">No books found</p>
        <a href="{{route('books.index')}}" class="reset-link">Reset criteria</a>
    </div>
    </li>
    @endforelse
    <div>{{$books->links()}}</div>

            </ul>
    @endsection
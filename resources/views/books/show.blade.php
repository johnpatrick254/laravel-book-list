@extends('layouts.app')

@section('content')
  <div class="mb-4">
    <h1 class="sticky top-0 mb-2 text-2xl">{{ $book->title }}</h1>

    <div class="book-info">
      <div class="book-author mb-4 text-lg font-semibold">by {{ $book->author }}</div>
      <div class="book-rating flex items-center">
        <div class="mr-2 text-sm font-medium text-slate-700">
          
          <x-star-rating :rating="$book->author/>
        </div>
        <span class="book-review-count text-sm text-gray-500 ">
          {{ $book->reviews_count }} {{ Str::plural('review', 5) }}
        </span>
      </div>
    </div>
  </div>

  <div>
    <h2 class="mb-4 text-xl font-semibold">Reviews</h2>
    <ul>
      @forelse ($book->reviews as $review)
        <li class="book-item mb-4">
          <div>
            <div class="mb-2 flex items-center gap-x-3 justify-between">
              <div class="font-semibold">Rating: {{ $review->rating }}</div>
            <p class="text-gray-700 truncate w-[70%]" >{{ $review->review }}</p>

              <div class="book-review-count w-max">
                {{ $review->created_at->format('M j, Y') }}</div>
            </div>
          </div>
        </li>
      @empty
        <li class="mb-4">
          <div class="empty-book-item">
            <p class="empty-text text-lg font-semibold">No reviews yet</p>
          </div>
        </li>
      @endforelse
    </ul>
  </div>
@endsection
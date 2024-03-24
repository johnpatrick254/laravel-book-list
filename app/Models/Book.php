<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Book extends Model
{
     use HasFactory;

     public function reviews()
     {
          return $this->hasMany(Review::class);
     }
     public function scopeWithReviewsCount(Builder $query, $from = null, $to = null): Builder|QueryBuilder
     {
          return $query->withCount([
               'reviews' => fn (Builder $q) => $this->dateFilter($q, $from, $to)
          ]);
     }

     public function scopeWithAvgRating(Builder $query, $from = null, $to = null): Builder|QueryBuilder
     {
          return $query->withAvg([
               'reviews' => fn (Builder $q) => $this->dateFilter($q, $from, $to)
          ], 'rating');
     }
     public function scopeTitle(Builder $query, string $title): Builder | QueryBuilder
     {
          return $query->where('title', 'LIKE', '%' . $title . '%');
     }
     public function scopePopular(Builder $query, $from = null, $to = null): Builder | QueryBuilder
     {
          return $query->withCount(['reviews' => fn ($q) => $this->dateFilter($q, $from, $to)])->orderBy('reviews_count', 'desc');
     }
     public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder | QueryBuilder
     {
          return $query->withAvg(['reviews' => fn ($q) => $this->dateFilter($q, $from, $to)], 'rating')->orderBy('reviews_avg_rating', 'desc');
     }

     public function scopeMinReviews(Builder $query, int $number)
     {
          return $query->having('reviews_count', ">=", $number);
     }
     private function dateFilter(Builder $query, $from = null, $to = null)
     {
          if ($from) {
               $query->where("created_at", ">=", $from);
          };

          if ($to) {
               $query->where("created_at", "<=", $to);
          }
     }

     public function scopePopularLastMonth(Builder $query)
     {
          return $query->popular(now()->subMonth(6), now())->highestRated(now()->subMonth(6), now())->minReviews(2);
     }
     public function scopePopularLast6Month(Builder $query)
     {
          return $query->popular(now()->subMonth(6), now())->highestRated(now()->subMonth(6), now())->minReviews(2);
     }
     public function scopeHighestRatedLastMonth(Builder $query)
     {
          return $query->highestRated(now()->subMonth(1), now())->popular(now()->subMonth(1), now())->minReviews(2);
     }
     public function scopeHighestRatedLast6Month(Builder $query)
     {
          return $query->highestRated(now()->subMonth(6), now())->popular(now()->subMonth(6), now())->minReviews(2);
     }

     protected static function booted()
     {
          static::updated(fn (Book $book) => cache()->forget('Book:' + $book->id));
     }
}

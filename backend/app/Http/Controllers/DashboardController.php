<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function stats()
    {
        $totalAuthors = Author::count();
        $totalBooks = Book::count();
        
        $genresCount = Book::whereNotNull('genre')->distinct('genre')->count('genre');
        
        $avgPerAuthor = $totalAuthors > 0 ? round($totalBooks / $totalAuthors, 1) : 0;

        $booksByGenre = Book::select('genre', DB::raw('count(*) as total'))
            ->whereNotNull('genre')
            ->groupBy('genre')
            ->orderByDesc('total')
            ->get();

        $mostProlificAuthors = Author::withCount('books')
            ->orderByDesc('books_count')
            ->take(5)
            ->get(['id', 'name', 'books_count']);

        return response()->json([
            'total_authors' => $totalAuthors,
            'total_books' => $totalBooks,
            'genres_count' => $genresCount,
            'avg_per_author' => $avgPerAuthor,
            'books_by_genre' => $booksByGenre,
            'most_prolific_authors' => $mostProlificAuthors,
        ]);
    }
}

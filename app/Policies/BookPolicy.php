<?php

namespace App\Policies;

use App\User;
use App\Book;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class BookPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if(Auth::user()->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the book.
     *
     * @param  \App\User  $user
     * @param  \App\Book  $book
     * @return mixed
     */
    public function view(User $user, Book $book)
    {
        return true;
    }

    /**
     * Determine whether the user can create books.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the book.
     *
     * @param  \App\User  $user
     * @param  \App\Book  $book
     * @return mixed
     */
    public function update(User $user, Book $book)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the book.
     *
     * @param  \App\User  $user
     * @param  \App\Book  $book
     * @return mixed
     */
    public function delete(User $user, Book $book)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the book.
     *
     * @param  \App\User  $user
     * @param  \App\Book  $book
     * @return mixed
     */
    public function restore(User $user, Book $book)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the book.
     *
     * @param  \App\User  $user
     * @param  \App\Book  $book
     * @return mixed
     */
    public function forceDelete(User $user, Book $book)
    {
        return false;
    }
}

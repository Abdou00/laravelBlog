<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postRepository;
    protected $nbPages;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
        $this->nbPages = config('app.nbPages.posts');
    }

    public function index()
    {
        $posts = $this->postRepository->getActiveOrderByDate($this->nbPages);
        $heroes = $this->postRepository->getHeroes();

        return view('front.index', compact('posts', 'heroes'));
    }
}

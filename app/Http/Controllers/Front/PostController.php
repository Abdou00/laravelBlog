<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\SearchRequest;
use App\Models\{Category, User, Tag};
use App\Repositories\PostRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Http\Request;

/**
 * Class PostController
 * @package App\Http\Controllers\Front
 */
class PostController extends Controller
{
    protected $postRepository;
    protected $nbPages;

    /**
     * PostController constructor.
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
        $this->nbPages = config('app.nbPages.posts');
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $posts = $this->postRepository->getActiveOrderByDate($this->nbPages);
        $heros = $this->postRepository->getHeroes();

        return view('front.index', compact('posts', 'heros'));
    }

    /**
     * @param Request $request
     * @param $slug
     * @return Application|Factory|View
     */
    public function show(Request $request, $slug)
    {
        $post = $this->postRepository->getPostBySlug($slug);
        return view('front.post', compact('post'));
    }

    /**
     * @param Category $category
     * @return Application|Factory|View
     */
    public function category(Category $category)
    {
        $posts = $this->postRepository->getActiveOrderByDateForCategory($this->nbPages, $category->slug);
        $title = __('Posts pour la catégorie ') . '<strong>' . $category->title . '</strong>';

        return view('front.index', compact('posts', 'title'));
    }

    /**
     * @param User $user
     * @return Application|Factory|View
     */
    public function user(User $user)
    {
        $posts = $this->postRepository->getActiveOrderByDateForUser($this->nbPages, $user->id);
        $title = __('Posts pour l\’auteur ') . '<strong>' . $user->name . '</strong>';

        return view('front.index', compact('posts', 'title'));
    }

    /**
     * @param Tag $tag
     * @return Application|Factory|View
     */
    public function tag(Tag $tag)
    {
        $posts = $this->postRepository->getActiveOrderByDateForTag($this->nbPages, $tag->slug);
        $title = __('Posts for tag ') . '<strong>' . $tag->tag . '</strong>';
        return view('front.index', compact('posts', 'title'));
    }

    /**
     * @param SearchRequest $request
     * @return Application|Factory|View
     */
    public function search(SearchRequest $request)
    {
        $search = $request->search;
        $posts = $this->postRepository->search($this->nbPages, $search);
        $title = __('Posts found with search: ') . '<strong>' . $search . '</strong>';
        return view('front.index', compact('posts', 'title'));
    }
}

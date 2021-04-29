<?php
namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    /**
     * @return mixed
     * On utilise un SELECT pour éviter de charger le contenu des articles qui peut être volumineux et qui est inutile pour la page d’accueil.
     * On charge aussi (eager loading) pour chaque article le nom de son auteur pour l’afficher).
     */
    protected function queryActive()
    {
        return Post::select(
            'id',
            'slug',
            'image',
            'title',
            'excerpt',
            'user_id')
            ->with('user:id,name')
            ->whereActive(true);
    }

    /**
     * @return mixed
     */
    protected function queryActiveOrderByDate()
    {
        return $this->queryActive()->latest();
    }

    /**
     * @param $nbPages
     * @return mixed
     * La fonction d’entrée est getActiveOrderByDate.
     * On lui transmet le nombre de pages et elle renvoie les articles concernés.
     */
    public function getActiveOrderByDate($nbPages)
    {
        return $this->queryActiveOrderByDate()->paginate($nbPages);
    }

    /**
     * @return mixed
     *Les heroes sont les 5 derniers articles créés ou modifiés.
     * On charge aussi les catégories parce qu’on doit les afficher.
     */
    public function getHeroes()
    {
        return $this->queryActive()->with('categories')->latest('updated_at')->take(5)->get();
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getPostBySlug($slug)
    {
        // Publier pour slug avec l'utilisateur, les tags et les catégories
        $post = Post::with('user:id,name,email', 'tags:id,tag,slug', 'categories:title,slug')->withCount('validComments')->whereSlug($slug)->firstOrFail();
        // Article précédent
        $post->previous = $this->getPreviousPost($post->id);
        // Article suivant
        $post->next = $this->getNextPost($post->id);

        return $post;
    }

    /**
     * @param $id
     * @return mixed
     */
    protected function getPreviousPost($id)
    {
        return Post::select('title', 'slug')->whereActive(true)->latest('id')->firstWhere('id', '<', $id);
    }

    /**
     * @param $id
     * @return mixed
     */
    protected function getNextPost($id)
    {
        return Post::select('title', 'slug')->whereActive(true)->oldest('id')->firstWhere('id', '>', $id);
    }

    /**
     * @param $nbPages
     * @param $category_slug
     * @return mixed
     */
    public function getActiveOrderByDateForCategory($nbPages, $category_slug)
    {
        return $this->queryActiveOrderByDate()->whereHas('categories', function ($q) use ($category_slug) {
            $q->where('categories.slug', $category_slug);
        })->paginate($nbPages);
    }

    /**
     * @param $nbPages
     * @param $user_id
     * @return mixed
     */
    public function getActiveOrderByDateForUser($nbPages, $user_id)
    {
        return $this->queryActiveOrderByDate()->whereHas('user', function ($q) use ($user_id) {
            $q->where('users.id', $user_id);
        })->paginate($nbPages);
    }

    /**
     * @param $nbPages
     * @param $tag_slug
     * @return mixed
     */
    public function getActiveOrderByDateForTag($nbPages, $tag_slug)
    {
        return $this->queryActiveOrderByDate()->whereHas('tags', function ($q) use ($tag_slug) {
            $q->where('tags.slug', $tag_slug);
        })->paginate($nbPages);
    }

    /**
     * @param $n
     * @param $search
     * @return mixed
     */
    public function search($n, $search)
    {
        return $this->queryActiveOrderByDate()->where(function ($q) use ($search) {
            $q->where('excerpt', 'like', "%$search%")
                ->orWhere('body', 'like', "%$search%")
                ->orWhere('title', 'like', "%$search%");
        })->paginate($n);
    }
}

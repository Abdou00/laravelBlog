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
        return Post::select('id',
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
     *Les heros sont les 5 derniers articles créés ou modifiés.
     * On charge aussi les catégories parce qu’on doit les afficher.
     */
    public function getHeros()
    {
        return $this->queryActive()->with('categories')->latest('updated_at')->take(5)->get();
    }
}

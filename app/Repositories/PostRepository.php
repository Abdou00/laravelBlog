<?php
namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
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

    protected function queryActiveOrderByDate()
    {
        return $this->queryActive()->latest();
    }

    public function getActiveOrderByDate($nbPages)
    {
        return $this->queryActiveOrderByDate()->paginate($nbPages);
    }
}

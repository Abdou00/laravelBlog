<?php
	namespace App\Http\ViewComposers;

	use Illuminate\View\View;
	use App\Models\Category;

	class HomeComposer
	{
        /**
         * On envoie dans la vue les catégories qui possèdent des articles.
         * @param View $view
         * @return void
         */
        public function compose(View $view)
        {
            $view->with([
                'categories' => Category::has('posts')->get(),
            ]);
        }
	}

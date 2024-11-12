<?php

namespace Botble\Blog\Http\Controllers;

use BaseHelper;
use Botble\Blog\Models\Category;
use Botble\Blog\Models\Post;
use Botble\Blog\Models\Tag;
use Botble\Blog\Repositories\Interfaces\PostInterface;
use Botble\Blog\Services\BlogService;
use Botble\Theme\Events\RenderingSingleEvent;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use SeoHelper;
use SlugHelper;
use Theme;

class PublicController extends Controller
{
    public function getSearch(Request $request, PostInterface $postRepository)
    {
        $query = BaseHelper::stringify($request->input('q'));

        $title = __('Search result for: ":query"', compact('query'));

        SeoHelper::setTitle($title)
            ->setDescription($title);

        $posts = $postRepository->getSearch($query, 0, 12);

        Theme::breadcrumb()
            ->add(__('Home'), route('public.index'))
            ->add($title, route('public.search'));

        return Theme::scope('search', compact('posts'))
            ->render();
    }

    public function getTag(string $slug, BlogService $blogService)
    {
        $slug = SlugHelper::getSlug($slug, SlugHelper::getPrefix(Tag::class));

        if (! $slug) {
            abort(404);
        }

        $data = $blogService->handleFrontRoutes($slug);

        if (isset($data['slug']) && $data['slug'] !== $slug->key) {
            return redirect()->to(route('public.single', SlugHelper::getPrefix(Tag::class) . '/' . $data['slug']));
        }

        event(new RenderingSingleEvent($slug));

        return Theme::scope($data['view'], $data['data'], $data['default_view'])
            ->render();
    }

    public function getPost(string $slug, BlogService $blogService)
    {
        $slug = SlugHelper::getSlug($slug, SlugHelper::getPrefix(Post::class));

        if (! $slug) {
            abort(404);
        }

        $data = $blogService->handleFrontRoutes($slug);

        if (isset($data['slug']) && $data['slug'] !== $slug->key) {
            return redirect()->to(route('public.single', SlugHelper::getPrefix(Post::class) . '/' . $data['slug']));
        }

        event(new RenderingSingleEvent($slug));

        Theme::asset()->add('ckeditor-content-styles', 'vendor/core/core/base/libraries/ckeditor/content-styles.css');

        return Theme::scope($data['view'], $data['data'], $data['default_view'])
            ->render();
    }

    public function getCategory(string $slug, BlogService $blogService)
    {
        $slug = SlugHelper::getSlug($slug, SlugHelper::getPrefix(Category::class));

        if (! $slug) {
            abort(404);
        }

        $data = $blogService->handleFrontRoutes($slug);

        if (isset($data['slug']) && $data['slug'] !== $slug->key) {
            return redirect()->to(route('public.single', SlugHelper::getPrefix(Category::class) . '/' . $data['slug']));
        }

        event(new RenderingSingleEvent($slug));

        return Theme::scope($data['view'], $data['data'], $data['default_view'])
            ->render();
    }
    public function videos()
    {
        // dd(auth('account')->user());
        //return view('supervisor.opsreview');
        
        $consultants = Account::where('type', '=', 'consultant')
            ->with('consultantReviews')
            ->get();
            $events = Event::get();



        //$file = $this->fileRepository->findOrFail(206);
        // dd($consultants);



        return Theme::scope(
            'job-board.startmeeting',
            ['auth' => auth()->user(),
            'events' => $events],
            'plugins/job-board::themes.startmeeting'
        )->render();



        /*return Theme::scope(
            'job-board.consultants',
            [],
            'plugins/job-board::themes.consultants'
        )->render();*/
    }
    
}

<?php

namespace Botble\JobBoard\Listeners;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\JobBoard\Repositories\Interfaces\CategoryInterface;
use Botble\JobBoard\Repositories\Interfaces\JobInterface;
use Botble\JobBoard\Repositories\Interfaces\TagInterface;
use JobBoardHelper;
use SiteMapManager;

class RenderingSiteMapListener
{
    protected JobInterface $jobRepository;

    protected CategoryInterface $categoryRepository;

    protected TagInterface $tagRepository;

    public function __construct(
        JobInterface $jobRepository,
        CategoryInterface $categoryRepository,
        TagInterface $tagRepository
    ) {
        $this->jobRepository = $jobRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
    }

    public function handle(): void
    {
        $jobs = $this->jobRepository->getModel()
            ->notExpired()
            ->where(JobBoardHelper::getJobDisplayQueryConditions())
            ->orderBy('jb_jobs.created_at', 'desc')
            ->with(['slugable'])
            ->get();

        foreach ($jobs as $job) {
            SiteMapManager::add($job->url, $job->updated_at, '0.8');
        }

        $categories = $this->categoryRepository->getModel()
            ->where('jb_categories.status', BaseStatusEnum::PUBLISHED)
            ->with(['slugable'])
            ->get();

        foreach ($categories as $category) {
            SiteMapManager::add($category->url, $category->updated_at, '0.8');
        }

        $tags = $this->tagRepository->getModel()
            ->where('jb_tags.status', BaseStatusEnum::PUBLISHED)
            ->with(['slugable'])
            ->get();

        foreach ($tags as $tag) {
            SiteMapManager::add($tag->url, $tag->updated_at, '0.4');
        }
    }
}

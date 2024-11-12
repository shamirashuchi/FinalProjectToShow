<?php

namespace Botble\JobBoard\Listeners;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\JobBoard\Repositories\Interfaces\CategoryInterface;
use Botble\JobBoard\Repositories\Interfaces\JobInterface;
use Botble\JobBoard\Repositories\Interfaces\TagInterface;
use Botble\Theme\Events\RenderingSiteMapEvent;
use JobBoardHelper;
use SiteMapManager;

class RenderingSiteMapListener
{
    public function __construct(
        protected JobInterface $jobRepository,
        protected CategoryInterface $categoryRepository,
        protected TagInterface $tagRepository
    ) {
    }

    public function handle(RenderingSiteMapEvent $event): void
    {
        if ($key = $event->key) {
            switch ($key) {
                case 'jobs':

                    $jobs = $this->jobRepository->getModel()
                        ->notExpired()
                        ->where(JobBoardHelper::getJobDisplayQueryConditions())
                        ->latest('updated_at')
                        ->with(['slugable'])
                        ->get();

                    foreach ($jobs as $job) {
                        SiteMapManager::add($job->url, $job->updated_at, '0.8');
                    }

                    break;

                case 'job-categories':

                    $categories = $this->categoryRepository->getModel()
                        ->where('status', BaseStatusEnum::PUBLISHED)
                        ->latest('updated_at')
                        ->with(['slugable'])
                        ->get();

                    foreach ($categories as $category) {
                        SiteMapManager::add($category->url, $category->updated_at, '0.8');
                    }

                    break;

                case 'job-tags':

                    $tags = $this->tagRepository->getModel()
                        ->where('status', BaseStatusEnum::PUBLISHED)
                        ->latest('updated_at')
                        ->with(['slugable'])
                        ->get();

                    foreach ($tags as $tag) {
                        SiteMapManager::add($tag->url, $tag->updated_at, '0.4');
                    }

                    break;
            }

            return;
        }

        $jobLastUpdated = $this->jobRepository
            ->getModel()
            ->notExpired()
            ->where(JobBoardHelper::getJobDisplayQueryConditions())
            ->latest('updated_at')
            ->value('updated_at');

        SiteMapManager::addSitemap(SiteMapManager::route('jobs'), $jobLastUpdated);

        $categoryLastUpdated = $this->categoryRepository
            ->getModel()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->latest('updated_at')
            ->value('updated_at');

        SiteMapManager::addSitemap(SiteMapManager::route('job-categories'), $categoryLastUpdated);

        $tagLastUpdated = $this->tagRepository
            ->getModel()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->latest('updated_at')
            ->value('updated_at');

        SiteMapManager::addSitemap(SiteMapManager::route('job-tags'), $tagLastUpdated);
    }
}

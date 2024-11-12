<?php

namespace Botble\JobBoard\Commands;

use Botble\JobBoard\Models\Account;
use Botble\JobBoard\Repositories\Interfaces\JobInterface;
use EmailHandler;
use Illuminate\Console\Command;
use JobBoardHelper;

class CheckExpiredJobsSoonCommand extends Command
{
    public JobInterface $jobRepository;

    protected $signature = 'cms:jobs:check-expired-soon';

    protected $description = 'Check expired jobs will be expired in 3 days';

    public function __construct(JobInterface $jobRepository)
    {
        parent::__construct();
        $this->jobRepository = $jobRepository;
    }

    public function handle(): int
    {
        $this->info('Checking...');

        $jobs = $this->jobRepository->getModel()
            ->notExpired()
            ->where('never_expired', false)
            ->where(JobBoardHelper::getJobDisplayQueryConditions())
            ->where('author_type', Account::class)
            ->join('jb_accounts', 'jb_accounts.id', '=', 'jb_jobs.author_id')
            ->with(['author'])
            ->select('jb_jobs.*')
            ->get();

        $count = 0;
        foreach ($jobs as $job) {
            $expiredAfter = $job->expire_date->diffInDays(now());
            if ($expiredAfter > 3) {
                continue;
            }

            $count++;

            EmailHandler::setModule(JOB_BOARD_MODULE_SCREEN_NAME)
                ->setVariableValues([
                    'job_name' => $job->name,
                    'job_url' => $job->url,
                    'job_author' => $job->author->name,
                    'job_list' => route('public.account.jobs.index'),
                    'job_expired_after' => $expiredAfter,
                ])
                ->sendUsingTemplate('job-expired-soon', $job->employer_emails);
        }

        $this->info($count . ' jobs will be expired in next 3 days!');

        return self::SUCCESS;
    }
}

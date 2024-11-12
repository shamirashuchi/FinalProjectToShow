<?php

namespace Botble\JobBoard\Commands;

use Botble\JobBoard\Models\Account;
use Botble\JobBoard\Repositories\Interfaces\JobInterface;
use EmailHandler;
use Illuminate\Console\Command;
use JobBoardHelper;

class RenewJobsCommand extends Command
{
    public JobInterface $jobRepository;

    protected $signature = 'cms:jobs:renew';

    protected $description = 'Renew jobs';

    public function __construct(JobInterface $jobRepository)
    {
        parent::__construct();
        $this->jobRepository = $jobRepository;
    }

    public function handle(): int
    {
        $jobs = $this->jobRepository->getModel()
            ->expired()
            ->where(JobBoardHelper::getJobDisplayQueryConditions())
            ->where('author_type', Account::class)
            ->join('jb_accounts', 'jb_accounts.id', '=', 'jb_jobs.author_id')
            ->where('jb_accounts.credits', '>', 0)
            ->where('jb_jobs.auto_renew', 1)
            ->with(['author'])
            ->select('jb_jobs.*')
            ->get();

        foreach ($jobs as $job) {
            if ($job->author->credits <= 0) {
                continue;
            }

            $job->expire_date = now()->addDays(JobBoardHelper::jobExpiredDays());
            $job->save();

            if (JobBoardHelper::isEnabledCreditsSystem() && $job->author->credits > 0) {
                $job->author->credits--;
                $job->author->save();
            }

            EmailHandler::setModule(JOB_BOARD_MODULE_SCREEN_NAME)
                ->setVariableValues([
                    'job_name' => $job->name,
                    'job_url' => $job->url,
                    'job_author' => $job->author->name,
                ])
                ->sendUsingTemplate('job-renewed', $job->employer_emails);
        }

        $this->info('Renew ' . $jobs->count() . ' jobs successfully!');

        return self::SUCCESS;
    }
}

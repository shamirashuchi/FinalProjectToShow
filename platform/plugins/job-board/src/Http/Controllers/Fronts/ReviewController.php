<?php

namespace Botble\JobBoard\Http\Controllers\Fronts;

use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\JobBoard\Http\Requests\AjaxReviewRequest;
use Botble\JobBoard\Http\Requests\StoreReviewRequest;
use Botble\JobBoard\Repositories\Interfaces\CompanyInterface;
use Botble\JobBoard\Repositories\Interfaces\ReviewInterface;
use JobBoardHelper;

class ReviewController
{
    protected ReviewInterface $reviewRepository;

    protected CompanyInterface $companyRepository;

    public function __construct(ReviewInterface $reviewRepository, CompanyInterface $companyRepository)
    {
        $this->reviewRepository = $reviewRepository;
        $this->companyRepository = $companyRepository;

        if (! JobBoardHelper::isEnabledReview()) {
            abort(404);
        }
    }

    public function store(StoreReviewRequest $request, BaseHttpResponse $response)
    {
        $account = auth('account')->user();
        $company = $this->companyRepository->findById($request->get('company_id'));

        if (! $account->canReviewCompany()) {
            return $response->setError()
                ->setMessage(__('Only jobseeker can review company'));
        }

        if ($account->hasReviewedCompany($company)) {
            return $response->setError()
                ->setMessage(__('You have already reviewed this company'));
        }

        $data = array_merge($request->validated(), [
            'account_id' => $account->id,
        ]);

        $this->reviewRepository->create($data);

        return $response->setMessage(__('Added review successfully!'));
    }

    public function loadMore(AjaxReviewRequest $request)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $reviews = $this->reviewRepository
            ->getModel()
            ->where('company_id', $request->input('company_id'))
            ->paginate(10);

        return JobBoardHelper::view('partials.review-load', compact('reviews'))->render();
    }
}

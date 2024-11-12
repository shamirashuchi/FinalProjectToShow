<?php

namespace Botble\JobBoard\Http\Controllers;

use Assets;
use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\JobBoard\Repositories\Interfaces\InvoiceInterface;
use Botble\JobBoard\Supports\InvoiceHelper;
use Botble\JobBoard\Tables\InvoiceTable;
use Exception;
use Illuminate\Http\Request;

class InvoiceController extends BaseController
{
    protected InvoiceInterface $invoiceRepository;

    public function __construct(InvoiceInterface $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    public function index(InvoiceTable $table)
    {
        page_title()->setTitle(trans('plugins/job-board::invoice.name'));

        return $table->renderTable();
    }

    public function edit(int $id, Request $request)
    {
        $invoice = $this->invoiceRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $invoice));

        page_title()->setTitle(trans('plugins/job-board::invoice.edit') . ' "' . $invoice->code . '"');

        Assets::addStylesDirectly('vendor/core/plugins/job-board/css/invoice.css');

        return view('plugins/job-board::invoice.edit', ['invoice' => $invoice]);
    }

    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $invoice = $this->invoiceRepository->findOrFail($id);

            $this->invoiceRepository->delete($invoice);

            event(new DeletedContentEvent(INVOICE_MODULE_SCREEN_NAME, $request, $invoice));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $invoice = $this->invoiceRepository->findOrFail($id);
            $this->invoiceRepository->delete($invoice);
            event(new DeletedContentEvent(INVOICE_MODULE_SCREEN_NAME, $request, $invoice));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }

    public function getGenerateInvoice(int $invoiceId, Request $request, InvoiceHelper $invoiceHelper)
    {
        $invoice = $this->invoiceRepository->findOrFail($invoiceId);

        if ($request->input('type') === 'print') {
            return $invoiceHelper->streamInvoice($invoice);
        }

        return $invoiceHelper->downloadInvoice($invoice);
    }
}

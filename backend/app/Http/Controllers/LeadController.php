<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use MailchimpMarketing\ApiClient;

class LeadController extends Controller
{
    // Store new lead
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:leads,email',
            'consent' => 'required|boolean'
        ]);

        $lead = Lead::create($data);

        // Sync to Mailchimp
        //$this->syncToMailchimp($lead);

        return response()->json($lead, 201);
    }

    // List all leads
    public function index()
    {
       
        return response()->json(Lead::all());
    }

    // Update lead
    public function update(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);

        $data = $request->validate([
            'name'    => 'string|max:255',
            'email'   => 'email|unique:leads,email,' . $lead->_id,
            'consent' => 'boolean'
        ]);

        $lead->update($data);

        // Sync updates to Mailchimp
        //$this->syncToMailchimp($lead);

        return response()->json($lead);
    }

    private function syncToMailchimp(Lead $lead)
    {
        $mailchimp = new ApiClient();
        $mailchimp->setConfig([
            'apiKey' => env('MAILCHIMP_API_KEY'),
            'server' => env('MAILCHIMP_SERVER_PREFIX')
        ]);

        $listId = env('MAILCHIMP_LIST_ID');

        try {
            $mailchimp->lists->setListMember(
                $listId,
                md5(strtolower($lead->email)),
                [
                    'email_address' => $lead->email,
                    'status_if_new' => $lead->consent ? 'subscribed' : 'unsubscribed',
                    'merge_fields'  => [
                        'FNAME' => $lead->name,
                    ],
                ]
            );
        } catch (\Exception $e) {
            \Log::error('Mailchimp sync failed: ' . $e->getMessage());
        }
    }
}

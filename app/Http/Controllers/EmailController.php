<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\GenericEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EmailController extends Controller
{
    public function paparBorangEmail()
    {
        // Show the form view to send email
        return view('email.template-borang');
    }

    public function hantarEmail(Request $request)
    {
        // Validate the form data
        $request->validate([
            'tajuk_email' => 'required|min:3',
            'kandungan_email' => ['required', 'min:3'],
            'attachments.*' => 'nullable|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpeg,jpg,png,gif|max:2048',
        ]);

        // Get email subject and content
        $tajukEmail = $request->input('tajuk_email');
        $kandunganEmail = $request->input('kandungan_email');

        // Handle attachments
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('email-attachments');
                $attachmentPaths[] = $path;
            }
        }

        // Get the list of users to send emails to
        $users = User::all();

        // Start timing the email process
        $startTime = microtime(true);

        // Send emails to all users
        foreach ($users as $user) {
            Mail::to($user->email)->send(new GenericEmail($tajukEmail, $kandunganEmail, $attachmentPaths));
        }

        // End timing the email process
        $endTime = microtime(true);

        // Calculate elapsed time
        $elapsedTime = $endTime - $startTime;

        // Flash the elapsed time message
        session()->flash('message', 'Emails successfully sent in (seconds): ' . $elapsedTime);

        // Redirect back to the email form
        return redirect()->route('papar.borang.email');
    }
}

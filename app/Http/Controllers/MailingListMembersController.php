<?php

namespace App\Http\Controllers;

use App\MailingList\Member;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MailingListMembersController extends Controller
{
    /**
     * Add a new mailing list member.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $data = request()->validate([
            'email' => ['required', 'email', Rule::unique('mailing_list_members')]
        ], [
            'email.requied' => "I'm going to need your email address.",
            'email.email' => "That doesn't look like a valid email address.",
            'email.unique' => "Looks like you're already signed up."
        ]);

        $member = Member::create($data);

        return $member;
    }
}

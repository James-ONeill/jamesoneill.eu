<?php

namespace App\MailingList;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'mailing_list_members';

    protected $guarded = [];
}

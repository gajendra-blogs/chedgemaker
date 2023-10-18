<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailsQueue extends Model
{
    use HasFactory;

    protected $fillable = ['from_mail' , 'to_mail' , 'cc_mail' , 'bcc_mail' , 'subject' , 'attachment' , 'body' , 'priority' , 'status' , 'failed_message' , 'created_by' , 'updated_by '];

}

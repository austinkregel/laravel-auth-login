<?php

namespace Kregel\AuthLogin\Models;

use Illuminate\Database\Eloquent\Model;
use Kregel\FormModel\Traits\Formable;

class AccountActivity extends Model
{
    use Formable;
    protected $table = 'auth_activity';

    protected $form_name = 'name';

    protected $fillable = [
        'request','server', 'failed', 'reason'
    ];

}

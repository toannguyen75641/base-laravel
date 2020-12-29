<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class SalesPerson
 *
 * @package App\Models
 *
 * @property int id
 * @property string name
 * @property int departments_id
 * @property bool status
 * @property bool type
 * @property string code
 * @property int offices_id
 * @property string type_detail
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted
 */
class SalesPerson extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sales_persons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'departments_id',
        'status',
        'type',
        'code',
        'offices_id',
        'type_detail',
        'deleted_at'
    ];

    /**
     * Get the department for the sales person.
     *
     * @return belongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'departments_id');
    }
}

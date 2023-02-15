<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends ModelBase
{
    use HasFactory,
        SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['id','name','status','data','uuid','checksum'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at','updated_at','syncronized_at','deleted_at','status_changed_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $cast = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'syncronized_at' => 'timestamp',
        'deleted_at' => 'timestamp',
        'status_changed_at' => 'timestamp',
    ];
}

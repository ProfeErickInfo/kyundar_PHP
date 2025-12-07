<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Organizacion Model
 * 
 * Eloquent model for the trn25_organizacion table.
 * Represents clubs, leagues, federations, and other organizations.
 */
class Organizacion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trn25_organizacion';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_liga',
        'id_instituto',
        'id_disciplina',
        'nombre',
        'id_municipio',
        'id_barrio',
        'direccion',
        'entrenador',
        'telefono',
        'representante',
        'cel',
        'email',
        'website',
        'escudo',
        'valinscripcion',
        'valmes',
        'fec_reg',
        'tipo_U',
    ];

    /**
     * Get the users for the organization.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'id_asocc', 'id');
    }
}

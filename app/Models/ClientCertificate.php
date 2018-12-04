<?php
namespace Gameap\Models;

/**
 * Class ClientCertificate
 * @package Gameap\Models
 *
 * @property int $id
 * @property string $certificate
 * @property string $private_key
 * @property string $private_key_pass
 */
class ClientCertificate
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'certificate', 'private_key', 'private_key_pass'
    ];

    /**
     * @var array
     */
    protected static $rules = [
        'certificate' => 'required',
        'private_key' => 'required',
        'private_key_pass' => '',
    ];

    /**
     * One to many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function servers()
    {
        return $this->hasMany(DedicatedServer::class, 'client_certificate_id');
    }
}
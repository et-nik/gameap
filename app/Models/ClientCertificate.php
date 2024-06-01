<?php

namespace Gameap\Models;

use Gameap\Services\Daemon\CertificateService;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ClientCertificate
 * @package Gameap\Models
 *
 * @property int $id
 * @property string $fingerprint
 * @property string $expires
 * @property string $certificate
 * @property string $private_key
 * @property string $private_key_pass
 * @property array $info
 */
class ClientCertificate extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fingerprint', 'expires', 'certificate', 'private_key', 'private_key_pass',
    ];

    /**
     * @var array
     */
    protected static $rules = [
        'certificate'      => 'required',
        'private_key'      => 'required',
        'private_key_pass' => '',
    ];

    /**
     * One to many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dedicatedServers()
    {
        return $this->hasMany(DedicatedServer::class);
    }

    public function getInfoAttribute()
    {
        return CertificateService::certificateInfo($this->certificate);
    }
}

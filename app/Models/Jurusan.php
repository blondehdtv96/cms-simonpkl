<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jurusan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jurusan';

    protected $fillable = [
        'kode_jurusan',
        'nama_jurusan'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relationships
    public function kaprog()
    {
        return $this->belongsTo(User::class, 'kaprog_id')->withTrashed();
    }

    public function siswa()
    {
        return $this->hasMany(User::class)->where('role', 'siswa');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nama_jurusan', 'LIKE', "%{$search}%")
              ->orWhere('kode_jurusan', 'LIKE', "%{$search}%");
        });
    }

    // Validation Rules
    public static function rules($id = null)
    {
        return [
            'kode_jurusan' => 'required|string|max:10|unique:jurusan,kode_jurusan,' . $id,
            'nama_jurusan' => 'required|string|max:100'
        ];
    }
} 
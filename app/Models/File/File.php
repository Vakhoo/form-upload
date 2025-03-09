<?php

namespace App\Models\File;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string url
 * @property string url_without_extension
 * @property string filename
 * @property string path
 * @property string path_without_extension
 * @property string public_path
 * @property string full_path
 */
class File extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'path',
        'extension',
        'mime',
        'size',
        'filename',
        'hash',
        'is_local',
    ];

    /**
     * @var string[]
     */
    protected $appends = [
        'url',
    ];


    public function getUrlAttribute(string $url = null)
    {
        return sprintf('%s.%s', $this->url_without_extension, $this->extension);
    }

    public function getUrlWithoutExtensionAttribute()
    {
        return sprintf(
            '%s%s%s%s%s%s%s',
            config('custom.constants.app_url'),
            DIRECTORY_SEPARATOR,
            'storage',
            DIRECTORY_SEPARATOR,
            $this->path,
            DIRECTORY_SEPARATOR,
            $this->filename
        );
    }

    public function getFullPathAttribute()
    {
        return sprintf('%s.%s', $this->path_without_extension, $this->extension);
    }

    public function getPublicPathAttribute()
    {
        return sprintf('%s%s%s.%s', $this->path, DIRECTORY_SEPARATOR, $this->filename, $this->extension);
    }

    public function getPathWithoutExtensionAttribute()
    {
        return public_path(sprintf('%s%s%s', $this->path, DIRECTORY_SEPARATOR, $this->filename));
    }
}

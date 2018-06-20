<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FcmUser extends Model
{
    protected $fillable = ['token', 'device' ,'user_id', 'lang'];

    /**
     * FCM Device user
     * @return [type] [description]
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }


    /**
     * scope to get android devices
     * @param  [type]  $query 
     * @param  [integer]  $gender
     * @return void      
     */
    public function scopeAndroid($query)
    {
        $query->where('device', 'android');
    }

    /**
     * scope to get ios devices
     * @param  [type]  $query 
     * @param  [integer]  $gender
     * @return void      
     */
    public function scopeIos($query)
    {
        $query->where('device', 'ios');
    }

    /**
     * scope to get ios devices
     * @param  [type]  $query 
     * @param  [integer]  $gender
     * @return void      
     */
    public function scopeLang($query, $lang = 'ar')
    {
        $query->where('lang', $lang);
    }

    /**
     * delete all tokens
     * @param  [integer]  $tokens
     * @return void      
     */
    public static function deleteTokens($tokens)
    {
        if(!empty($tokens)){
            self::whereIn('token', $tokens)->delete();
        }
    }
}

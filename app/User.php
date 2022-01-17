<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Model\StaffPermission;

class User extends Authenticatable implements JWTSubject
{
    use SoftDeletes, Notifiable;

    protected $fillable = [
        'role_id',
        'name',
        'phone',
        'password',
        'email',
        'category_id',
        'change_password',
    ];
    public function hasRole($role)
    {
        if ($this->role()->where('en', $role)->first()) {
            return true;
        }
        return false;
    }

    public function isAdmin()
    {
        return $this->hasRole('Admin');
    }

    public function isAdminStaff()
    {
        // die($this->role()->where('en', 'Admin Staff')->first());
        return $this->hasRole('Admin Staff');
    }

    public function isAdminStaffAllowed($page)
    {   
        $id = Auth()->user()->id;
        $permissions = StaffPermission::where("user_id",$id)->first();
   
        if ( isset($permissions->$page) && $permissions->$page ) {
            return true;
        }
        return false;
    }

    
    public function isPharmacist()
    {
        return $this->hasRole('Pharmacist');
    }

    public function isDriver()
    {
        return $this->hasRole('Driver');
    }

    public function isCustomer()
    {
        return $this->hasRole('Customer');
    }

    public function staffPermission()
    {
        return $this->belongsTo('App\Model\StaffPermission');
    }

    public function role()
    {
        return $this->belongsTo('App\Model\Role')->withTrashed();
    }

    public function city()
    {
        return $this->belongsTo('App\Model\City')->withTrashed();
    }

    public function gender()
    {
        return $this->belongsTo('App\Model\Gender')->withTrashed();
    }

    public function notifications()
    {
        return $this->hasMany('App\Model\Notification');
    }

    public function getNotificationsCountAttribute()
    {
        return $this->notifications->count();
    }

    public function user_addresses()
    {
        return $this->hasMany('App\Model\UserAddress', 'user_id');
    }

    public function my_addresses()
    {
        return $this->hasMany('App\Model\UserAddress', 'user_id');
    }

    public function default_user_address()
    {
        return $this->belongsTo('App\Model\UserAddress');
    }
    public function carts()
    {
        return $this->hasMany('App\Model\Cart', 'user_id');
    }
    public function purchases()
    {
        return $this->hasMany('App\Model\Purchase', 'user_id');
    }

    public function pharmacy_purchases()
    {
        return $this->hasMany('App\Model\Purchase', 'pharmacy_id');
    }

    public function deliveries()
    {
        return $this->hasMany('App\Model\Purchase', 'driver_id');
    }
    public function sent_reviews()
    {
        return $this->hasMany('App\Model\Review', 'user_id');
    }
    public function driver_received_reviews()
    {
        return $this->hasMany('App\Model\Review', 'driver_id');
    }
    public function inquiries()
    {
        return $this->hasMany('App\Model\Inquiry', 'user_id');
    }

    public function product_categories()
    {
        return $this->hasMany('App\Model\ProductCategory');
    }

    public function pharmacy_received_reviews()
    {
        return $this->hasMany('App\Model\Review', 'pharmacy_id');
    }

    public function favorites()
    {
        return $this->belongsToMany('App\Model\Service', 'favorites', 'user_id', 'service_id');
    }
    public function getPharmacistReviewAttribute()
    {
        $reviews = $this->hasMany('App\Model\Review', 'pharmacy_id');
        $total = ($reviews->count() != 0) ? round($reviews->sum('star_pharmacy') / $reviews->count()) : 0;
        return $total;
    }
    public function getDriverReviewAttribute()
    {
        $reviews = $this->hasMany('App\Model\Review', 'driver_id');
        $total = ($reviews->count() != 0) ? round($reviews->sum('star_driver') / $reviews->count()) : 0;
        return $total;
    }
    public function getPharmacistReviewCount()
    {
        $reviews = $this->hasMany('App\Model\Review', 'pharmacy_id');
        $total = $reviews->count();
        return $total;
    }
    public function getDriverReviewCount()
    {
        $reviews = $this->hasMany('App\Model\Review', 'driver_id');
        $total = $reviews->count();
        return $total;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
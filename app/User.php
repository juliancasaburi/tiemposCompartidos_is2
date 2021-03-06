<?php

namespace App;

use App\Notifications\ReservationCancelled;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use App\Notifications\VerificarEmail;
use App\Notifications\ResetPassword;
use App\Notifications\EmailChanged;
use App\Notifications\PaymentDetailsChanged;
use App\Notifications\AuctionStarted;
use App\Notifications\PremiumAccepted;
use App\Notifications\PremiumRejected;
use App\Notifications\AuctionCancelled;
use App\Notifications\BookedByAPremiumUser;
use App\Notifications\ReservationObtained;
use App\Notifications\HotsaleReservationObtained;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'nombre', 'apellido', 'pais', 'DNI', 'fecha_nacimiento', 'creditos', 'saldo', 'password', 'premium',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'usuarios';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /* public function sendEmailVerificationNotification()
    {
        $this->notify(new Email);
    } */

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerificarEmail); // notificacion
    }

    /**
     * Send the email change notification.
     *
     * @return void
     */
    public function sendEmailChangedNotification()
    {
        $this->notify(new EmailChanged); // notificacion
    }

    /**
     * Send the payment details changed notification.
     *
     * @return void
     */
    public function sendPaymentDetailsChangedNotification()
    {
        $this->notify(new PaymentDetailsChanged); // notificacion
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Send the reservation cancelled notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendReservationCancelledNotification($propertyName, $date, $balance)
    {
        $this->notify(new ReservationCancelled($propertyName, $date, $balance));
    }

    /**
     * Send the reservation obtained notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendReservationObtainedNotification($propertyName, $date)
    {
        $this->notify(new ReservationObtained($propertyName, $date));
    }

    public function sendHotsaleReservationObtainedNotification($propertyName, $date)
    {
        $this->notify(new HotsaleReservationObtained($propertyName, $date));
    }

    /**
     * Send the auction started notification.
     *
     * @return void
     */
    public function sendAuctionStartedNotification($propertyName, $date, $auctionID)
    {
        $this->notify(new AuctionStarted($propertyName, $date, $auctionID));
    }

    /**
     * Send the Premium Request Accepted notification
     *
     * @return void
     */
    public function sendPremiumAcceptedNotification($date)
    {
        $this->notify(new PremiumAccepted($date));
    }

    /**
     * Send the Premium Request Rejected notification
     *
     * @return void
     */
    public function sendPremiumRejectedNotification($date)
    {
        $this->notify(new PremiumRejected($date));
    }

    /**
     * Send the Auction Cancelled notification
     *
     * @return void
     */
    public function sendAuctionCancelledNotification($propertyName, $date, $auctionID){
        $this->notify(new AuctionCancelled($propertyName, $date, $auctionID));
    }

    /**
     * Send the Booked By A Premium User notification
     *
     * @return void
     */
    public function sendBookedByAPremiumUserNotification($propertyName, $date, $weekID){
        $this->notify(new BookedByAPremiumUser($propertyName, $date, $weekID));
    }

    /**
     * Accessor for Age.
     */
    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['fecha_nacimiento'])->age;
    }

    public function auctionInscriptions(){
        return $this->hasMany(InscriptionForFutureAuction::class, 'usuario_id', 'id');
    }

    public function reservations(){
        return $this->hasMany(Reservation::class, 'usuario_id', 'id');
    }

    public function reservationsWithTrashed(){
        return $this->hasMany(Reservation::class, 'usuario_id', 'id')->withTrashed();
    }

    public function bids(){
        return $this->hasMany(Bid::class, 'usuario_id', 'id');
    }

    public function premiumRequest(){
        return $this->hasOne(PremiumRequest::class, 'usuario_id', 'id');
    }

    public function card(){
        return $this->hasOne(Card::class, 'usuario_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, "usuario_id", "id")->whereNull('parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, "usuario_id", "id")->whereNotNull('parent_id');
    }

    /**
     * Scope a query to only include premium users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePremium($query)
    {
        return $query->where('premium', 1);
    }
}


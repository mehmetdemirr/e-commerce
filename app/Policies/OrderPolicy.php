<?php

namespace App\Policies;

use App\Enum\UserRole;
use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class OrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAnyAdmin(User $user): bool
    {
        return $user->hasRole(UserRole::ADMIN);
    }

    public function viewAnyCompany(User $user): bool
    {
        return $user->hasRole(UserRole::COMPANY);
    }

    public function viewAny(User $user): bool
    {
        return $user->hasRole(UserRole::USER);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): bool
    {
        // Kullanıcının belirli bir siparişi görüntüleme iznine sahip olup olmadığını kontrol eder.
        return $user->id === $order->user_id || 
                ($user->business->user_id === $order->business_id && $user->hasRole(UserRole::COMPANY)) || 
                $user->hasRole(UserRole::ADMIN);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('user') || $user->hasRole(UserRole::ADMIN);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Order $order): bool
    {
        return ($user->business->user_id === $order->business_id && $user->hasRole(UserRole::COMPANY)) || 
                $user->hasRole(UserRole::ADMIN);
    }

    /**
     * Determine whether the user can update the status of the order.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Order  $order
     * @return bool
     */
    public function updateOrderStatus(User $user, Order $order): bool
    {
        return ($user->business->user_id === $order->business_id && $user->hasRole(UserRole::COMPANY)) || 
                $user->hasRole(UserRole::ADMIN);
    }

    /**
     * Determine whether the user can update the payment status of the order.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Order  $order
     * @return bool
     */
    public function updatePaymentStatus(User $user, Order $order): bool
    {
        return $user->hasRole(UserRole::ADMIN);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Order $order): bool
    {
        return $user->hasRole(UserRole::ADMIN);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Order $order): bool
    {
        return $user->hasRole(UserRole::ADMIN);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Order $order): bool
    {
        return $user->hasRole(UserRole::ADMIN);
    }
}

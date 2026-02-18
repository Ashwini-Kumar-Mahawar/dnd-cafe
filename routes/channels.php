<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('kitchen', function ($user) {
    // Allow kitchen staff and admins to listen to kitchen channel
    return $user->hasRole(['admin', 'kitchen']);
});

Broadcast::channel('orders.{orderId}', function ($user, $orderId) {
    // Users can listen to their own order updates
    return true;
});
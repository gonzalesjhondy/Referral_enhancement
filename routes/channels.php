<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('chat', function ($user) {
    return $user;
});

Broadcast::channel('new_referral', function ($referral) {
    return $referral;
});

Broadcast::channel('reco', function ($reco) {
    return $reco;
});

Broadcast::channel('referral_seen', function ($referral_seen) {
    return $referral_seen;
});

Broadcast::channel('referral_accepted', function ($referral_accepted) {
    return $referral_accepted;
});

Broadcast::channel('referral_rejected', function ($referral_rejected) {
    return $referral_rejected;
});

Broadcast::channel('referral_call', function ($referral_call) {
    return $referral_call;
});

Broadcast::channel('referral_departed', function ($referral_departed) {
    return $referral_departed;
});

Broadcast::channel('referral_arrived', function ($referral_arrived) {
    return $referral_arrived;
});

Broadcast::channel('referral_not_arrived', function ($referral_not_arrived) {
    return $referral_not_arrived;
});

Broadcast::channel('referral_admitted', function ($referral_admitted) {
    return $referral_admitted;
});

Broadcast::channel('referral_discharged', function ($referral_discharged) {
    return $referral_discharged;
});

Broadcast::channel('referral_update', function ($referral_update) {
    return $referral_update;
});

Broadcast::channel('admin_notifs', function ($admin_notifs) {
    return $admin_notifs;
});

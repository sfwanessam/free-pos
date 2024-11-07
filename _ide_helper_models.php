<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereUpdatedAt($value)
 */
	class Client extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $client_id
 * @property int $sub_total
 * @property int $tax
 * @property int $discount
 * @property int $grand_total
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PosSale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PosSale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PosSale query()
 * @method static \Illuminate\Database\Eloquent\Builder|PosSale whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosSale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosSale whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosSale whereGrandTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosSale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosSale whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosSale whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosSale whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosSale whereUpdatedAt($value)
 */
	class PosSale extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $product_id
 * @property int|null $purchase_id
 * @property int $quantity
 * @property int $price
 * @property int $total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PosSaleItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PosSaleItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PosSaleItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|PosSaleItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosSaleItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosSaleItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosSaleItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosSaleItem wherePurchaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosSaleItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosSaleItem whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosSaleItem whereUpdatedAt($value)
 */
	class PosSaleItem extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property string $price
 * @property int $is_a_service
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsAService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $client_id
 * @property int $sub_total
 * @property int $tax
 * @property int $discount
 * @property int $grand_total
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase query()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereGrandTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereUpdatedAt($value)
 */
	class Purchase extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $product_id
 * @property int|null $purchase_id
 * @property int $quantity
 * @property int $price
 * @property int $total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem wherePurchaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereUpdatedAt($value)
 */
	class PurchaseItem extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}


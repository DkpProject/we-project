<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\BalanceLog
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $action
 * @property float $value
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BalanceLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BalanceLog whereItemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BalanceLog whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BalanceLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BalanceLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BalanceLog whereAction($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BalanceLog whereValue($value)
 */
	class BalanceLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Catalog
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $cat_id
 * @property string $name
 * @property string $descr
 * @property \Carbon\Carbon $stop_date
 * @property float $cost
 * @property boolean $used
 * @property string $deal_type
 * @property integer $views
 * @property boolean $visible
 * @property integer $disabled
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $evaluation
 * @property integer $limitations
 * @property string $flaw
 * @property boolean $stock
 * @property string $place
 * @property-read \App\Models\User $user
 * @property-read \App\Models\ForumDiscussion $discussion
 * @property-read \App\Models\CatalogCats $cat
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Image[] $images
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Deal[] $deal
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Catalog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Catalog whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Catalog whereCatId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Catalog whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Catalog whereDescr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Catalog whereStopDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Catalog whereCost($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Catalog whereUsed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Catalog whereDealType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Catalog whereViews($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Catalog whereVisible($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Catalog whereDisabled($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Catalog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Catalog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Catalog whereEvaluation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Catalog whereLimitations($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Catalog whereFlaw($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Catalog whereStock($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Catalog wherePlace($value)
 */
	class Catalog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CatalogCats
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CatalogCats[] $child
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalog[] $items
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CatalogCats whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CatalogCats whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CatalogCats whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CatalogCats whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CatalogCats whereUpdatedAt($value)
 */
	class CatalogCats extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ForumDiscussion[] $discussions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $childs
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category onlyChild()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category ordered()
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Deal
 *
 * @property integer $id
 * @property integer $seller_id
 * @property integer $purchaser_id
 * @property integer $item_id
 * @property float $cost
 * @property string $item_type
 * @property string $type
 * @property integer $status
 * @property integer $closed_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $state
 * @property-read \App\Models\User $seller
 * @property-read \App\Models\User $purchaser
 * @property-read \App\Models\User $closed
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DealsMessages[] $messages
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $item
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Receipt[] $receipts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DeliveryAddress[] $addresses
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Deal whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Deal whereSellerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Deal wherePurchaserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Deal whereItemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Deal whereCost($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Deal whereItemType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Deal whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Deal whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Deal whereClosedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Deal whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Deal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Deal whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Deal module()
 */
	class Deal extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DealsMessages
 *
 * @property integer $id
 * @property integer $deal_id
 * @property integer $user_id
 * @property string $comment
 * @property integer $rating
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property boolean $finish
 * @property-read \App\Models\Deal $deal
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DealsMessages whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DealsMessages whereDealId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DealsMessages whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DealsMessages whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DealsMessages whereRating($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DealsMessages whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DealsMessages whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DealsMessages whereFinish($value)
 */
	class DealsMessages extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DeliveryAddress
 *
 * @property integer $id
 * @property integer $deal_id
 * @property string $address
 * @property \Carbon\Carbon $datetime
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Deal $deal
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DeliveryAddress whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DeliveryAddress whereDealId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DeliveryAddress whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DeliveryAddress whereDatetime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DeliveryAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DeliveryAddress whereUpdatedAt($value)
 */
	class DeliveryAddress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\District
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\District whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\District whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\District whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\District whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\District whereUpdatedAt($value)
 */
	class District extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ForumDiscussion
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property integer $user_id
 * @property boolean $sticky
 * @property integer $views
 * @property boolean $answered
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $slug
 * @property string $color
 * @property integer $evaluation
 * @property integer $evaluation_item
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ForumPost[] $posts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ForumPost[] $post
 * @property-read \App\Models\Catalog $item
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ForumDiscussion whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ForumDiscussion whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ForumDiscussion whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ForumDiscussion whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ForumDiscussion whereSticky($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ForumDiscussion whereViews($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ForumDiscussion whereAnswered($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ForumDiscussion whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ForumDiscussion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ForumDiscussion whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ForumDiscussion whereColor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ForumDiscussion whereEvaluation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ForumDiscussion whereEvaluationItem($value)
 */
	class ForumDiscussion extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ForumPost
 *
 * @property integer $id
 * @property integer $discussion_id
 * @property integer $category_id
 * @property integer $first
 * @property integer $thanks
 * @property integer $price
 * @property integer $user_id
 * @property string $body
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\ForumDiscussion $discussion
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ForumPost whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ForumPost whereDiscussionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ForumPost whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ForumPost whereFirst($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ForumPost whereThanks($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ForumPost wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ForumPost whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ForumPost whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ForumPost whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ForumPost whereUpdatedAt($value)
 */
	class ForumPost extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Image
 *
 * @property integer $id
 * @property integer $owner_id
 * @property string $owner_type
 * @property string $file
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $owner
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Image whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Image whereOwnerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Image whereOwnerType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Image whereFile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Image module()
 */
	class Image extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Invite
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $key
 * @property integer $used_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\User $used
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Invite whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Invite whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Invite whereKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Invite whereUsedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Invite whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Invite whereUpdatedAt($value)
 */
	class Invite extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Message
 *
 * @property integer $id
 * @property integer $from
 * @property integer $to
 * @property string $text
 * @property boolean $read
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $type
 * @property string $variable
 * @property-read \App\Models\User $author
 * @property-read \App\Models\User $recipient
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereTo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereRead($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereVariable($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message lastMessage($auth, $user)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message allMessages($auth, $user)
 */
	class Message extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Poll
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\CatalogCats $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PollsQuestion[] $questions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PollsAnswer[] $answers
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Poll whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Poll whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Poll whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Poll whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Poll whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Poll findPolls($cat, $user = false)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Poll passedPolls($user = false)
 */
	class Poll extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PollsAnswer
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $question_id
 * @property integer $poll_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $answer
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Poll $poll
 * @property-read \App\Models\PollsQuestion $question
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PollsAnswer whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PollsAnswer whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PollsAnswer whereQuestionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PollsAnswer wherePollId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PollsAnswer whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PollsAnswer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PollsAnswer whereAnswer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PollsAnswer category($cat)
 */
	class PollsAnswer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PollsQuestion
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $poll_id
 * @property string $question
 * @property string $answers
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\CatalogCats $category
 * @property-read \App\Models\Poll $poll
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PollsQuestion whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PollsQuestion whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PollsQuestion wherePollId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PollsQuestion whereQuestion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PollsQuestion whereAnswers($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PollsQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PollsQuestion whereUpdatedAt($value)
 */
	class PollsQuestion extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Receipt
 *
 * @property integer $id
 * @property integer $deal_id
 * @property string $action
 * @property integer $price
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $paid
 * @property-read \App\Models\Deal $deal
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Receipt whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Receipt whereDealId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Receipt whereAction($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Receipt wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Receipt whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Receipt whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Receipt wherePaid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Receipt toPay()
 */
	class Receipt extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Service
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $cat_id
 * @property string $name
 * @property string $descr
 * @property \Carbon\Carbon $stop_date
 * @property float $cost
 * @property integer $views
 * @property integer $visible
 * @property integer $disabled
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\ServiceCats $cat
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Image[] $images
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Deal[] $deal
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Service whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Service whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Service whereCatId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Service whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Service whereDescr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Service whereStopDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Service whereCost($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Service whereViews($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Service whereVisible($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Service whereDisabled($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Service whereUpdatedAt($value)
 */
	class Service extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ServiceCats
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ServiceCats[] $child
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Service[] $items
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ServiceCats whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ServiceCats whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ServiceCats whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ServiceCats whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ServiceCats whereUpdatedAt($value)
 */
	class ServiceCats extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Setting
 *
 * @property integer $id
 * @property string $key
 * @property string $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Setting whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Setting whereKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Setting whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Setting balance()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Setting getValue($key)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Specialty
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $spec_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\CatalogCats $spec
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Specialty whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Specialty whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Specialty whereSpecId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Specialty whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Specialty whereUpdatedAt($value)
 */
	class Specialty extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property integer $id
 * @property string $firstname
 * @property string $surname
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property float $balance
 * @property boolean $is_admin
 * @property boolean $confirmed
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $district
 * @property string $about
 * @property \Carbon\Carbon $birthday
 * @property string $gender
 * @property integer $group_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Invite[] $invites
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Image[] $images
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalog[] $catalog
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Service[] $service
 * @property-read \App\Models\Invite $invited_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $invited_users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Deal[] $purchase_deals
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Deal[] $sell_deals
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Deal[] $deals
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BalanceLog[] $balanceLog
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ForumPost[] $posts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Specialty[] $specs_list
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CatalogCats[] $specs
 * @property-read \App\Models\UsersRole $myGroup
 * @property-read \App\Models\District $userDistrict
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Wish[] $wishes
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereFirstname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereSurname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereBalance($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereIsAdmin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereConfirmed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereDistrict($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereAbout($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereBirthday($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereGroupId($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UsersGroup
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 */
	class UsersGroup extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UsersRole
 *
 * @property integer $id
 * @property string $name
 * @property integer $sort
 * @property integer $default
 * @property boolean $changeable
 * @property string $permission
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UsersRolesRule[] $rules
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersRole whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersRole whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersRole whereSort($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersRole whereDefault($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersRole whereChangeable($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersRole wherePermission($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersRole changeable()
 */
	class UsersRole extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UsersRolesRule
 *
 * @property integer $id
 * @property integer $role_id
 * @property string $type
 * @property string $if
 * @property integer $value
 * @property-read \App\Models\UsersRole $role
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersRolesRule whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersRolesRule whereRoleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersRolesRule whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersRolesRule whereIf($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersRolesRule whereValue($value)
 */
	class UsersRolesRule extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Wish
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $text
 * @property boolean $active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wish whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wish whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wish whereText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wish whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wish whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wish whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wish active()
 */
	class Wish extends \Eloquent {}
}


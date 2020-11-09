namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class {{ $data['singular'] }} extends Model
{

 use Notifiable;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

      /**
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
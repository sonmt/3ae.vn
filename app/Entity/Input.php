<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Input extends Model
{
    protected $table = 'input';

    protected $primaryKey = 'input_id';

    protected $fillable = [
        'input_id',
        'type_input_slug',
        'content',
        'post_id',
        'updated_at'
    ];

    public static function getPostMeta($slug, $postId) {
        $inputOld = static::where([
            'post_id' => $postId,
            'type_input_slug' => $slug
        ])->first();

        if (empty($inputOld)) {
            return '';
        }

        return $inputOld->content;
    }
    public function updateInput($typeInputDatabase, $request, $postId, $typePost='post') {
        foreach($typeInputDatabase as $typeInput) {
            $token = explode(',', $typeInput->post_used);

            if (in_array($typePost, $token)) {
                $this->where([
                    'type_input_slug' => $typeInput->slug,
                    'post_id' =>  $postId
                ])->delete();

                $contentInput =  $request->input($typeInput->slug);
                $this->insert([
                    'type_input_slug' => $typeInput->slug,
                    'content' => $contentInput,
                    'post_id' => $postId
                ]);
            }
        }
    }

    public static function showTitle($postId) {
        $input = static::where('post_id', $postId)->first();

        return $input->content;
    }
}

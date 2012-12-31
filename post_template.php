<?php
/**
 * Each element of the array $photos contains an object like this:
 * stdClass Object
(
    [id] => 21719327
    [user_id] => 152172
    [name] => Hills
    [description] => Fog rises over the hills in Shenandoah National Park
    [camera] => 
    [lens] => 
    [focal_length] => 130
    [iso] => 640
    [shutter_speed] => 1/400
    [aperture] => 5.6
    [times_viewed] => 2
    [rating] => 0
    [status] => 1
    [created_at] => 2012-12-28T14:15:37-05:00
    [category] => 8
    [location] => 
    [privacy] => 
    [latitude] => 
    [longitude] => 
    [taken_at] => 
    [hi_res_uploaded] => 0
    [for_sale] => 
    [width] => 900
    [height] => 600
    [votes_count] => 0
    [favorites_count] => 0
    [comments_count] => 0
    [nsfw] => 
    [sales_count] => 0
    [for_sale_date] => 
    [highest_rating] => 0
    [highest_rating_date] => 
    [license_type] => 0
    [converted] => 3
    [image_url] => http://pcdn.500px.net/21719327/934caf230a867ee120b3d96f8dfca612dc680dc2/4.jpg
    [images] => Array
        (
            [0] => stdClass Object
                (
                    [size] => 4
                    [url] => http://pcdn.500px.net/21719327/934caf230a867ee120b3d96f8dfca612dc680dc2/4.jpg
                )

        )

    [store_download] => 
    [store_print] => 

)
 * 
 * Any fields can be used in the post content.
 */

$text = '<a href="http://500px.com/photo/' . $photos[0]->id . '"><img src="' . $photos[0]->image_url . '" /></a><br />'
		. $photos[0]->description;
if (count($photos) > 1) {
	$text .= '<br />';
	foreach ($photos as $photo) {
		$text .= '<a href="http://500px.com/photo/' . $photo->id . '"><img src="'
				. str_replace('4.jpg', '3.jpg', $photo->image_url) . '" /></a>';
	}
}
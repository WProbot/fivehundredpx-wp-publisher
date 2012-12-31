<?php
/*
Plugin Name: 500px WP Publisher
Plugin URI: http://danosipov.com/500
Description: Import shots from 500px profile as Wordpress posts
Version: 1.0
Author: Dan Osipov
Author URI: http://danosipov.com/
License: MIT
*/

/*
 * Some "constants".
 * Could be defined as global variables, but I try to stay away from them.
 */
// API endpoint
function fhp_api_endpoint() { return 'https://api.500px.com/v1/'; }
// Consumer key for an app I've setup.
function fhp_consumer_key() { return 'IHrT4iwQXR9Wb0E9XmCplJsJbAB6uA6b7oJnQoWV'; }


/**
 * Main function, triggering the execution of the process.
 * Will find new photos, create a post with them, and publish it.
 */
function fhp_run() {
	$photos = fhp_get_all_photos();
	$filtered_photos = fhp_filter_photos($photos);
	if (count($filtered_photos) > 0) {
		$post = fhp_get_post_text($filtered_photos);
		fhp_insert_post($post, $filtered_photos);
	} else {
		echo 'No new photos';
	}
}

/**
 * Get all photos
 * Only gets the first page - more is probably unnecessary
 * 
 * @return array	Array of photos
 * @throws Exception
 */
function fhp_get_all_photos() {
	$user = get_option('fivehundredpx_username');
	if (empty($user)) {
		throw new Exception('Plugin not setup yet - username missing');
	}
	
	$url = fhp_api_endpoint() . 'photos?feature=user&username=' . $user
			. '&consumer_key=' . fhp_consumer_key();
	$response = fhp_curl_get($url);
	if (empty($response)) {
		throw new Exception('API request failed');
	}
	
	$parsed_response = json_decode($response);
	if (isset($parsed_response->error)) {
		throw new Exception('API error: ' . $parsed_response->error);
	}

	return $parsed_response->photos;
}

/**
 * Pick out photos added since the last check. Need to watch out for timezone issues
 * Sort the resulting list by rating, so highest rating is on top.
 * 
 * @param array $photos
 * @return array
 */
function fhp_filter_photos($photos) {
	$cutoff = get_option('fivehundredpx_last_update');
	if (empty($cutoff)) {
		update_option('fivehundredpx_last_update', time());
		return array();
	} else {
		$fresh_photos = array();
		foreach ($photos as $photo) {
			if (strtotime($photo->created_at) > $cutoff) {
				$url = fhp_api_endpoint() . 'photos/' . $photo->id
					. '?tags=1&consumer_key=' . fhp_consumer_key();
				$photo_detail = fhp_curl_get($url);
				
				if (empty($photo_detail)) {
					throw new Exception('API request for detail photo info failed');
				}

				$parsed_photo_detail = json_decode($photo_detail);
				if (isset($parsed_photo_detail->error)) {
					throw new Exception('API error: ' . $parsed_photo_detail->error);
				}
								
				$fresh_photos[] = $parsed_photo_detail->photo;
			}
		}
		// Sort photos
		usort($fresh_photos, "fhp_photosort_comparator");
		
		update_option('fivehundredpx_last_update', time());
		
		return $fresh_photos;
	}
}

/**
 * Get contents of a URL.
 * Uses cURL.
 * 
 * @param string $url
 * @return string	Contents of the result
 */
function fhp_curl_get($url) {
	$ch = curl_init($url);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, 0);

	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}

/**
 * Get post content based on the photos
 * Loads in the template
 * 
 * @param array $photos
 * @return string	Post
 */
function fhp_get_post_text($photos) {
	include('post_template.php');
	return $text;
}

/**
 * Call WP API to publish the post
 * 
 * @param string $post
 * @param array $photos
 */
function fhp_insert_post($post, $photos) {
	require_once(ABSPATH . WPINC . '/post.php');

	$post_array = array(
		'post_status' => 'publish',
		'post_author' => get_option('fivehundredpx_userid'),
		'post_type' => 'post', 
		'post_content' => $post, 
		'post_title' => $photos[0]->name,
	);
	
	$result = wp_insert_post($post_array, true);
	
	if (intval($result)) {
		if (is_array($photos[0]->tags)) {
			wp_set_post_tags($result, implode(',', $photos[0]->tags));
		}
		wp_set_post_categories($result, array(get_option('fivehundredpx_categoryid')));
		
		echo 'Post ' . $result . ' added successfully.';
	} else {
		echo 'Problem adding post. More info: ' . $result;
	}
}

/**
 * Sorting help function
 * Works on photo objects returned by 500px API
 * Sorts them by rating.
 * 
 * @param StdClass $p1
 * @param StdClass $p2
 * @return int
 */
function fhp_photosort_comparator($p1, $p2) {
	return $p1->rating - $p2->rating;
}

if (is_admin()) {
	require_once('fivehundredpx_admin.php');
}
?>
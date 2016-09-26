<?php

defined('ACCESS_SYSTEM') or die;

model('User');
model('Image');
model('ImageLike');
model('ImageUnlike');
model('FriendRelation');
model('FriendRequest');
model('Favorite');
model('Follow');
model('Helper/UserHelper');
model('Helper/FavoriteHelper');
model('Helper/FollowHelper');
model('Helper/FriendRelationHelper');
model('Helper/FriendRequestHelper');
import('libraries/uploadimage');

class AjaxController extends Controller
{
	public function updateIntro($request) 
	{
		$user = new User();

		$user->find(UserHelper::getUserId());
		$user->attr('about', $request['intro']);

		if ($user->save()) {
			return json_encode(['flag' => 1]);
		}

		return json_encode(['flag' => 0]);
	}

	public function updateUserFullName($request) 
	{
		$fullname = trim($request['fullname']);

		// Only a-Z and Letters, least 4 and max 30
		if ($fullname == '') {
			return json_encode(array('flag' => '0', 'message' => 'Please enter fullname.'));
		}

		if (checkLetter($fullname, 4, 30) == 0) {
			return json_encode(array('flag' => '0', 'message' => 'Fullname contain a-Z and letters, length at least 4 characters and maximum length of 30'));
		}

		$user = new User();

		$user->find(UserHelper::getUserId());
		$user->attr('fullname', $request['fullname']);

		if ($user->save()) {
			return json_encode(array('flag' => '1'));
		}

		return json_encode(array('flag' => '0', 'message' => 'There is error!'));
	}

	public function updateUserEmail($request) 
	{
		if (trim($request['email']) == '') {
			return json_encode(array('flag' => '0', 'message' => 'Please enter email.'));
		}

		if (filter_var($request['email'], FILTER_VALIDATE_EMAIL) === false) {
			return json_encode(array('flag' => '0', 'message' => 'Email is incorrect.'));
		}

		$user = new User();

		$user->find(UserHelper::getUserId());
		$user->attr('email', $request['email']);

		if ($user->save()) {
			return json_encode(array('flag' => '1'));
		}

		return json_encode(array('flag' => '0'));
	}

	public function updateUserAddress($request) 
	{
		$user = new User();

		$user->find(UserHelper::getUserId());
		$user->attr('address', $request['address']);

		if ($user->save()) {
			return json_encode(['flag' => 1]);
		}

		return json_encode(['flag' => 0]);
	}

	public function updateUserMap($request) 
	{
		$user = new User();

		$user->find(UserHelper::getUserId());
		$user->attr('map', $request['map']);

		if ($user->save()) {
			return json_encode(['flag' => 1]);
		}

		return json_encode(['flag' => 0]);
	}

	public function updateUserSex($request) 
	{
		$sex = $request['sex'];

		if ($request['sex'] != 1 && $request['sex'] != 2) {
			$sex = 1;
		}

		$user = new User();

		$user->find(UserHelper::getUserId());
		$user->attr('sex', $sex);

		if ($user->save())
			return json_encode(['flag' => 1]);
		return json_encode(['flag' => 0]);
	}

	public function updateUserBirthday($request)
	{
		// Check date
		if (strtotime($request['birthday']) === false) {
			return json_encode(array('flag' => '0', 'message' => 'Birthday is incorrect.'));
		}

		// Check birthday < now
		$date = date('Y-m-d', strtotime($request['birthday']));
		$dateNow = date('Y-m-d');

		if ($date > $dateNow) {
			return json_encode(array('flag' => '0', 'message' => 'Birthday is incorrect.'));
		}
		
		$user = new User();

		$user->find(UserHelper::getUserId());
		$user->attr('birthday', $date);

		if ($user->save()) {
			return json_encode(array('flag' => '1'));
		}

		return json_encode(array('flag' => '0', 'message' => 'Birthday is incorrect.'));
	}

	public function unfriend($req) 
	{
		$userid = $this->getUserId();

		// Check user
		$user = new User();

		$user->where('id', $req['userid']);

		if ($user->has() && ($req['userid'] != $userid)) {
			// Check friend
			$friend = new FriendRelation();

			$str = sprintf(" AND (user_id = %d and user_id_to = %d) OR (user_id = %d and user_id_to = %d)", $req['userid'], $userid, $userid, $req['userid']);

			$friend->whereRaw($str);
			$friend->findSingle();

			if ($friend->destroy()) {
				/*
				// Delete favorite
				$fa = new Favorite();
				$fa->where([['user_id', $userid], ['user_id_to', $req['userid']]]);
				$fa->findSingle();
				$fa->destroy();

				// Delete follow
				$fo = new Follow();
				$fo->where([['user_id', $userid], ['user_id_to', $req['userid']]]);
				$fo->findSingle();
				$fo->destroy();
				*/

				// Delete like
				// Delete Unlike				

				// Log User's action
				UserHelper::logHistoryUser($userid, 2, $req['userid']);
				return json_encode(['flag' => 1]);
			}
		}

		return json_encode(['flag' => 0]);
	}

	public function unfavorite($request) 
	{
		$userid = $this->getUserId();

		// Check user
		$user = new User();

		$user->where('id', $request['userid']);

		if ($user->has() && ($request['userid'] != $userid)) {
			// Check friend
			$favorite = new Favorite();
			$favorite->where([['user_id', $userid],
				              ['user_id_to', $request['userid']]]);

			$favorite->findSingle();

			if ($favorite->destroy()) {
				return json_encode(['flag' => 1]);
			}
		}
		return json_encode(['flag' => 0]);
	}

	public function unRequest($request) 
	{
		$userid = $this->getUserId();

		// Check user
		$user = new User();

		$user->where('id', $request['userid']);

		if ($user->has() && ($request['userid'] != $userid)) {
			// Check friend
			$friendRequest = new FriendRequest();
			$friendRequest->where([['user_id', $userid],
				              ['user_id_to', $request['userid']]]);

			$friendRequest->findSingle();

			if ($friendRequest->destroy()) {
				return json_encode(['flag' => 1]);
			}
		}
		return json_encode(['flag' => 0]);
	}

	public function addfavorite($req) 
	{
		$userid = $this->getUserId();

		// Check user
		$user = new User();

		$user->where('id', $req['userid']);

		// Check id is exist
		if ($user->has() & ($req['userid'] != $userid)) {
			$favorite = new Favorite();
			$favorite->attr('user_id', $userid);
			$favorite->attr('user_id_to', $req['userid']);
			
			if ($favorite->save()) {
				return json_encode(['flag' => 1]);
			}
		}

		return json_encode(['flag' => 0]);
	}

	public function unfollow($req) 
	{
		$userid = $this->getUserId();

		// Check user
		$user = new User();

		$user->where('id', $req['userid']);

		if ($user->has() && ($req['userid'] != $userid)) {
			// Check friend
			$follow = new Follow();
			$follow->where([['user_id', $userid],
				            ['user_id_to', $req['userid']]]);

			$follow->findSingle();

			if ($follow->destroy()) {
				return json_encode(['flag' => 1]);
			}
		}
		return json_encode(['flag' => 0]);
	}

	public function addFollow($req) 
	{
		$userid = $this->getUserId();

		// Check user
		$user = new User();

		$user->where('id', $req['userid']);

		// Check id is exist
		if ($user->has() & ($req['userid'] != $userid)) {
			$follow = new Follow();
			$follow->attr('user_id', $userid);
			$follow->attr('user_id_to', $req['userid']);
			
			if ($follow->save()) {
				return json_encode(['flag' => 1]);
			}
		}

		return json_encode(['flag' => 0]);
	}

	public function addFriend($re) 
	{
		$user = new User();

		$userid = $this->getUserId();

		$user->where('id', $re['userid']);

		// Has user
		if ($user->has() & ($re['userid'] != $userid)) {
			if (!UserHelper::isFriend($userid, $re['userid'])) {
				$requestObj = new FriendRequest();

				$request = UserHelper::getRequest($userid, $re['userid']);
				
				// Insert new request if there is no request
				if (empty($request)) {
					$requestObj->attr('user_id', $userid);
					$requestObj->attr('user_id_to', $re['userid']);

					if ($requestObj->save()) {
						// Log User's action
						UserHelper::logHistoryUser($userid, 3, $re['userid']);
						return json_encode(['flag' => 1]);
					} else {
						return json_encode(['flag' => 0]);
					}
				} else {
					// If there is request but user's request to user_to then no action
					if ($request['request_type'] == 1) {
						return json_encode(['flag' => 1]);
					} elseif ($request['request_type'] == 2) {
						// If there is request but user_to's request to user then user and user_to are friend each other. Then, delete request
						 
						// Add new request
						$friendObj = new FriendRelation();
						$friendObj->attr('user_id', $userid);
						$friendObj->attr('user_id_to', $re['userid']);

						if ($friendObj->save()) {
							// Log User's action
							UserHelper::logHistoryUser($userid, 1, $re['userid']);

							FriendRequest::delete('friend_request', 'id', $request['id']);
							return json_encode(['flag' => 1]);
						} else {
							return json_encode(['flag' => 0]);
						}
					}
				}		
			}
		}
		return json_encode(['flag' => 0]);
	}

	/* Friend request */
	public function acceptRequest($req) 
	{
		$flag = json_encode(['flag' => 0]);

		// Step 1: Get info request
		$requestObj = new FriendRequest();
		$result = $requestObj->find($req['requestid']);

		// Step 2: Compare info and session
		if ($result['user_id_to'] == $this->getUserId()) {
			if (!UserHelper::isFriend($result['user_id'], $result['user_id_to'])) {
				// Step 3: Add Relation
				$friendObj = new FriendRelation();
				$friendObj->attr('user_id', $result['user_id']);
				$friendObj->attr('user_id_to', $result['user_id_to']);

				if ($friendObj->save()) {
					// Log User's action
					UserHelper::logHistoryUser($result['user_id'], 1, $result['user_id_to']);
					// Step 2: Remove Request
					$flag = $this->removeRequest($req);
				} else {
					$flag = json_encode(['flag' => 0]);
				}
			} else {
				$flag = $this->removeRequest($req);
			}
		}
		return $flag;
	}

	public function removeRequest($req)
	{
		// Delete request
		$request = new FriendRequest();
		$request->where('id', $req['requestid']);
		$request->findSingle();
		if (!empty($request)) {
			if ($request->destroy()) {
				return json_encode(['flag' => 1]);
			}
		}
		return json_encode(['flag' => 0]);
	}

	public function addImage()
	{
		$upload = new Upload($_FILES['file'], array('bigDir' => 'uploads/images'));
		$result =  $upload->uploadTemp();
		$flag = array();

		if ($result['flag'] == 1) {
			$final = $upload->uploadImage($result['filename']);
			
			$image = new Image();
			$image->attr('user_id', UserHelper::getUserId());
			$image->attr('image', $final);

			if ($image->save()) {
				$image->where('image', $final);
				$item = $image->findSingle();

				$flag['filename'] = $final;
				$flag['id'] = $item['id'];
			} else {
				$flag['flag'] = 0;
				$flag['filename'] = $final;
				$flag['message'] = 'Error';
			}
		} elseif ($result['flag'] == 2) {
			$flag['flag'] = 0;
			$flag['message'] = 'Format of image: ' . $result['message'];
			$flag['fileName'] = $result['fileName'];
		} elseif ($result['flag'] == 3) {
			$flag['flag'] = 0;
			$flag['message'] = 'Max size of image <= ' . $result['message'];
			$flag['fileName'] = $result['fileName'];
		}
		return json_encode($flag, JSON_UNESCAPED_UNICODE);
	}

	public function changeAvatar() 
	{
		$upload = new Upload($_FILES['file'], array('bigDir' => 'uploads/avatar'));
		$result =  $upload->uploadTemp();

		if ($result['flag'] == 1) {
			$final = $upload->uploadImage($result['filename']);

			if ($final === false) {
				$result['flag'] = 0;
				$result['message'] = 'Image is incorrect';
				return json_encode($result, JSON_UNESCAPED_UNICODE);
			}
			
			// Delete image
			$user = new User();
			$obj = $user->find(UserHelper::getUserId());

			$avatar = $obj['avatar'];

			// Update new avatar
			$user->attr('avatar', $final);
			if ($user->save()) {
				$result['filename'] = $final;

				// Delete image
				$fileSmall = getAvatar($avatar, true, false);
				$fileBig = getAvatar($avatar, false, false);

				if (file_exists($fileSmall)) {
					unlink($fileSmall);
				}

				if (file_exists($fileBig)) {
					unlink($fileBig);
				}
			} else {
				$result['flag'] = 0;
				$result['message'] = 'There is error.';
			}
		} elseif ($result['flag'] == 2) {
			$result['flag'] = 0;
			$result['message'] = 'Format of image: ' . $result['message'];
		} elseif ($result['flag'] == 3) {
			$result['flag'] = 0;
			$result['message'] = 'Max size of image <= ' . $result['message'];
		}

		return json_encode($result, JSON_UNESCAPED_UNICODE);
	}

	public function like($request) 
	{
		$image = new Image();
		$like = new ImageLike();
		$imgId = $request['imageid'];

		// Check user permission
		$query = sprintf('SELECT img.*, IFNULL(imgl.user_id, 0) user_liked
						    FROM image img
						    LEFT JOIN (SELECT * FROM image_like WHERE user_id = %d) imgl ON imgl.image_id = img.id
						   WHERE img.id = %d', UserHelper::getUserId(), $imgId);

		$result = $image->query($query);
		$result = $image->getSingle($result);

		if (!empty($result)) {
			// If not liked
			if ($result['user_liked'] == 0) {
				if (UserHelper::getUserId() == $result['user_id']) {
					return json_encode(['flag' => 1, 'count' => $this->doLike($image, $imgId, $like)]);
				} else {
					if (UserHelper::isFriend(UserHelper::getUserId(), $result['user_id'])) {
						return json_encode(['flag' => 1, 'count' => $this->doLike($image, $imgId, $like)]);
					}
				}
			} else { // If liked
				if (UserHelper::getUserId() == $result['user_id']) {
					return json_encode(['flag' => 1, 'count' => $this->doUnlike($image, $imgId, $like)]);
				} else {
					if (UserHelper::isFriend(UserHelper::getUserId(), $result['user_id'])) {
						return json_encode(['flag' => 1, 'count' => $this->doUnlike($image, $imgId, $like)]);
					}
				}
			}
		}

		$flag = json_encode(['flag' => 0]);
	}

	protected function doLike($image, $imgId, $like) 
	{
		// Update like 'image' table
		$image->where('id', $imgId);
		$result = $image->findSingle();
		
		$count = $result['like'] + 1;

		$image->attr('like', $count);
		$image->save();

		// Insert like 'image_like' table
		$like->attr('image_id', $imgId);
		$like->attr('user_id', UserHelper::getUserId());
		$like->save();

		return $count;
	}

	protected function doUnlike($image, $imgId, $like) 
	{
		// Update like 'image' table
		$image->where('id', $imgId);
		$result = $image->findSingle();
		
		$count = $result['like'] - 1;

		$image->attr('like', $count);
		$image->save();

		$like->where([['image_id', $imgId], ['user_id', UserHelper::getUserId()]]);
		$like->findSingle();
		$like->destroy();

		return $count;
	}

	public function deleteImage($request) 
	{
		$image = new Image();
		$imgId = $request['imageid'];

		$image->where('id', $imgId);
		$result = $image->findSingle();

		if (!empty($result)) {
			if ($result['user_id'] == UserHelper::getUserId()) {
				// Step 1: Delete image like
				$builder = new QueryBuilder();
				$builder->delete('image_like', 'image_id', $imgId);

				// Step 3: Delete image
				if ($image->destroy())
				{
					// Delete image
					$fileSmall = getUserImage($result['image'], true, false);
					$fileBig = getUserImage($result['image'], false, false);

					if (file_exists($fileSmall)) {
						unlink($fileSmall);
					}

					if (file_exists($fileBig)) {
						unlink($fileBig);
					}

					return json_encode(['flag' => 1]);
				}
			}
		}

		return json_encode(['flag' => 0]);
	}

	public function viewImage($request) 
	{
		$imageObj = new Image();
		$imageObj->where('id', $request['imageid']);
		$image = $imageObj->findSingle();
		$count = $image['view'];
		
		if (!empty($image)) {
			$userid = $image['user_id'];

			// Check permission view
			if (UserHelper::getUserId() != $userid) {
				// Is other friend
				if (UserHelper::isFriend(UserHelper::getUserId(), $userid)) {
					$count = $count + 1;
					$imageObj->attr('view', $count);
					if ($imageObj->save()) {
						return json_encode(['flag' => 1, 'count' => $count]);
					} else {
						return json_encode(['flag' => 0]);
					}
				}
			}
		}
		
		return json_encode(['flag' => 1, 'count' => $count]);
	}

	/* AJAX VIEW */
	public function searchFriend($key, $p = 1)
	{
		$list = array();
        $display = 6;

		$page = (int)abs($p);
		$page =  $page == 0 ? 1 : $page;
		$limit = ($page - 1) * $display;

    	$key = quote(str_replace('_', ' ', $key));

    	if ($key != '') {
    		$list = UserHelper::getSearch($key, $limit, $display);
    	}
    	
        App::setPageTitle('Search friends');

    	return view('ajax/searchFriend', compact('list', 'display'));
	}

	public function favoriteList($username = '', $p = 1) 
    {
    	$layout = 'ajax/favoriteList';
    	$result = array();
        $display = 6;

		$page = (int)abs($p);
		$page =  $page == 0 ? 1 : $page;
		$limit = ($page - 1) * $display;

        $user = UserHelper::getUserInfo($username);

        if (!empty($user)) {
        	if (UserHelper::isUser($user['id'])) {
        		$result = FavoriteHelper::getFavoriteOfUser($limit, $display);
	        } else {
	        	$result = FavoriteHelper::getFavoriteOfFriend($user['id'], $limit, $display);
	        	$layout = 'ajax/favoriteListOther';
	        }
        } else {
        	$layout = 'ajax/blank';
        }

        return view($layout, compact('result'));
    }

    public function followList($p = 1)
    {
        $layout = 'ajax/followList';
    	$result = array();
        $display = 5;

		$page = (int)abs($p);
		$page =  $page == 0 ? 1 : $page;
		$limit = ($page - 1) * $display;
        
    	$result = FollowHelper::getList($limit, $display);
    	$followTemp = array();

    	$count = count($result);

    	// Get readed follow
        if ($count > 0) {

        	foreach ($result as $item) {
                if ($item['is_new'] == 1) {
                    $followTemp[] = $item;
                } else {
                    break;
                }
            }

            if (!empty($followTemp)) {
            	$dateFrom = $followTemp[$count - 1]['regist_datetime'];
	            $dateTo = $followTemp[0]['regist_datetime'];

	            // Update read datetime
	            $user = new User();
	            $user->where('id', UserHelper::getUserId());
	            $tmp = $user->findSingle();

	            if ($tmp['read_follow_from'] == '') {
	                $user->attr('read_follow_from', $dateFrom);
	            } else {
	                if ($dateFrom < $tmp['read_follow_from']) {
	                    $user->attr('read_follow_from', $dateFrom);
	                }
	            }

	            if ($tmp['read_follow_to'] == '') {
	                $user->attr('read_follow_to', $dateTo);
	            } else {
	                if ($dateTo > $tmp['read_follow_to']) {
	                    $user->attr('read_follow_to', $dateTo);
	                }
	            }

	            $user->save();
            }
        }

    	if (empty($result)) {
    		$layout = 'ajax/blank';
    	}

    	return view($layout, compact('result'));
    }

    public function friendRequest($p = 1)
    {
        $layout = 'ajax/friendRequest';
    	$result = array();
        $display = 5;

		$page = (int)abs($p);
		$page =  $page == 0 ? 1 : $page;
		$limit = ($page - 1) * $display;
        
    	$result = FriendRequestHelper::getList($limit, $display);

    	if (empty($result)) {
    		$layout = 'ajax/blank';
    	}

    	return view($layout, compact('result'));
    }

    public function imageList($username, $p = 1)
    {
        $layout = 'ajax/imageList';
    	$result = array();
        $display = 12;

		$page = (int)abs($p);
		$page =  $page == 0 ? 1 : $page;
		$limit = ($page - 1) * $display;

		$user = UserHelper::getUserInfo($username);

		if (!empty($user)) {
        	if (UserHelper::isUser($user['id'])) {
        		$result = UserHelper::getImages(UserHelper::getUserId(), $limit, $display);
	        } else {
	        	$result = UserHelper::getImages($user['id'], $limit, $display);
	        	$layout = 'ajax/imageListOther';
	        }
        } else {
        	$layout = 'ajax/blank';
        }

    	return view($layout, compact('result'));
    }

    public function friendList($username, $p = 1)
    {
        $layout = 'ajax/friendList';
    	$result = array();
        $display = 6;

		$page = (int)abs($p);
		$page =  $page == 0 ? 1 : $page;

		$limit = ($page - 1) * $display;
        
    	$user = UserHelper::getUserInfo($username);

        if (!empty($user)) {
        	if (UserHelper::isUser($user['id'])) {
        		$result = FriendRelationHelper::friendsOfUser($limit, $display);
	        } else {
	        	$result = FriendRelationHelper::friendsOfFriend($user['id'], $limit, $display);
	        	$layout = 'ajax/friendListOther';
	        }
        } else {
        	$layout = 'ajax/blank';
        }

    	return view($layout, compact('result'));
    }

    public function countFollow() {
    	return json_encode(['count' => FollowHelper::getFollowQuantity(UserHelper::getUserId())]);
    }

	/* Extends function */
	protected function getUserId() 
	{
		return Session::get('userid');
	}

	protected function checkUserId($userid) 
	{
		if (!is_numeric($userid)) {
			return false;
		}

		if (Session::get('userid') == $userid) {
			return true;
		}
		return false;
	}
}

?>
<?php

defined('ACCESS_SYSTEM') or die;

model('Helper/UserHelper');
model('Helper/FollowHelper');
model('User');

class FollowController extends Controller
{
    public function getList()
    {
        $user = new User();

        $display = 5;

        $follow = FollowHelper::getList(0, $display);
        $followTemp = array();
        
    	$result = ['follow' => $follow,
                   'user'   => UserHelper::getUserInfo(),
                   'display' => $display];

        $count = count($follow);

        // Get readed follow
        if ($count > 0) {
            foreach ($follow as $item) {
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

        App::setPageTitle('Follow');

    	return view('follow_list', $result);
    }
}

?>
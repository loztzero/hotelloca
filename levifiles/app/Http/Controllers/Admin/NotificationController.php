<?php namespace App\Http\Controllers\Admin;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Input, Auth, Session, Redirect, Hash, DateTime, StdClass, Validator, Mail;
use App;
use App\User;
use App\Libraries\Helpers;
use DB, PDF;
use App\Models\Notification;
use App\Http\Controllers\Controller;
class NotificationController extends Controller {

	public function getIndex(Request $request){
        // echo 'kambing';
        $notifications = Notification::query();

		if($request->has('tranfer_date_from')){
			$notifications = $notification->where('transfer_date', '>=', Helpers::dateFormatter($request->tranfer_date_from));
		}

		if($request->has('tranfer_date_to')){
			$notifications = $notification->where('transfer_date', '>=', Helpers::dateFormatter($request->tranfer_date_from));
		}

		if($request->has('order_no')){
			$notifications = $notification->where('order_no', 'like', $request->order_no);
		}

		if($request->has('order_date_from')){
			$notifications = $notification->where('order_date', '>=', Helpers::dateFormatter($request->order_date_from));
		}

		if($request->has('order_date_to')){
			$notifications = $notification->where('order_date', '<=', Helpers::dateFormatter($request->order_date_to));
		}
		$notifications = $notifications->orderBy('created_at', 'desc')->paginate(25);

        return view('admin.notification.admin-notification-browse')
        ->with('notifications', $notifications);
	}

	public function postMarkAsRead(Request $request){
		if($request->has('id')){
			$notification = Notification::find($request->id);
			if($notification){
				$notification->read_flag = 'Yes';
				$notification->save();
				return response()->json(['message' => 'Succes'], 200);
			}
		}
		return response()->json(['error' => json_encode($request->all())], 404);
	}

	//return limited notification
	public function getNotificationUnreadList(){

		$notifications = Notification::where('read_flag', '=', 'No')
						->orderBy('transfer_date', 'desc')
						->take(10)
						->get(['order_no']);

		return response()->json($notifications);
	}

}

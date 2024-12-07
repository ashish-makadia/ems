<?php
namespace App\Repositories;

use App\Models\AccessIps;

class AccessIpsRepository
{
    // insert new entry
	public function create(array $input)
	{
		return AccessIps::create($input);
	}

    // update existing data;
	public function update($accessip,array $input)
	{
		return $accessip->update($input);
	}
    // softdelete existing data;
	public function delete($accessip)
	{
		if($accessip)
        {
           	if($accessip->delete())
            {
                \LogActivity::addToLog(__('messages.ipdelete'));
                return response(['status'=>'1','msg'=>__('messages.ipnotdelete')]);
            }
            else
            {
                \LogActivity::addToLog(__('messages.ipnotdelete'));
                return response(['status'=>'0','msg'=>__('messages.ipnotdelete')]);
            }

        }else
        {
            \LogActivity::addToLog(__('messages.datanotfound'));
            return response(['status'=>'0','msg'=>__('messages.datanotfound')]);
        }
	}

	// update status in database
	public function updatestatus($id)
	{
		$ip = AccessIps::findOrfail($id);
        if($ip->status =='Active')
        {
            $ip->status = 'Inactive';
        }
        else
        {
            $ip->status = 'Active';
        }
        if($ip->save())
        {
            \LogActivity::addToLog(__('messages.statusmsg'));
            return response(['status'=>'1','msg'=>__('messages.statusmsg')]);
        }
        else{
            \LogActivity::addToLog(__('messages.datanotfound'));
            return response(['status'=>'0','msg'=>__('messages.datanotfound')]);
        }
	}
}
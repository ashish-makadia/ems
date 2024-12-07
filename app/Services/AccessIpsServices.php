<?php namespace App\Services;
use App\Repositories\AccessIpsRepository;
use App\Models\AccessIps;
use App\Models\Product;

class AccessIpsServices
{

	protected $accessIpsRepository;
	
	public function __construct()
    {
        $this->accessIpsRepository =  new AccessIpsRepository;
    }

	// insert new entry
	public function createAccessip(array $input)
	{
		if($this->accessIpsRepository->create($input))
		{
			\LogActivity::addToLog(__('messages.ipadd'));
            return response(['status'=>'1','msg'=>__('messages.ipadd')]);
		}else
		{
			\LogActivity::addToLog(__('messages.ipnotadd'));
            return response(['status'=>'0','msg'=>__('messages.ipnotadd')]);
		}
	}

	// update existing data;
	public function updateAccessip($accessid,array $input)
	{
		$input['status'] = isset($input['status']) ? 'Active' :'Inactive';
		if($this->accessIpsRepository->update($accessid,$input))
		{
			\LogActivity::addToLog(__('messages.ipupdate'));
			return response(['status'=>'1','msg'=>__('messages.ipupdate')]);
		}else
		{
			\LogActivity::addToLog(__('messages.ipnotupdate'));
			return response(['status'=>'0','msg'=>__('messages.ipnotupdate')]);
		}
	}

	// show datatable 
	public function getDatatable(object $request)
	{
		$json = array();
        $sql = AccessIps::where(function ($query) use ($request) {
                $query->where('ip', 'like', '%' . $request->search['value']. '%')
                    ->orWhere('status', 'like', '%' . $request->search['value']. '%')
                    ->orWhere('type', 'like', '%' . $request->search['value']. '%');
                    
            })->orderBy($request->columns[$request->order[0]['column']]['name'],$request->order[0]['dir']);
        $recordsTotal = $sql->count(); 
        $data= $sql->limit($request->length)->skip($request->start)->get();
        $recordsFiltered = count($data);

        $json['data'] = $data;
        $json['draw'] = $request->draw;
        $json['recordsTotal'] = $recordsFiltered;
        $json['recordsFiltered'] = $recordsTotal;
        
        return $json;
	    
    }
	
	// softdelete existing data;
	public function deleteAccessip($accessip)
	{
		return $this->accessIpsRepository->delete($accessip);
	}

	// update status 
	public function updatestatus($id)
	{
		return $this->accessIpsRepository->updatestatus($id);
	}
}
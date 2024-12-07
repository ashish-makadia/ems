<?php
 
namespace App;
 
use Illuminate\Http\Request;
use Image;
 
trait ImageUpload {
 
    /**
     * Does very basic image validity checking and stores it. Redirects back if somethings wrong.
     * @Notice: This is not an alternative to the model validation for this field.
     *
     * @param Request $request
     * @return $this|false|string
     */
    public function verifyAndStoreImage($request, $fieldname, $path ,$x,$y) {
        if( $request) {
        	
            if (!$request) {
 
                flash('Invalid Image!')->error()->important();
 
                return redirect()->back()->withInput();
 
            }else{
            	$image_resize = Image::make($path);
                $image_resize->fit($x, $y);
                return $image_resize->save($path);
            }


        }
 	
        return null;
 
    }
 
}
<?php

namespace App\Imports;

use App\Models\BookingSystem;
use App\Models\Customer;
use App\Models\Agents;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\RoleHasPermission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use DateTime;

class OrderBookingImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if(count($row) != 37){
            throw ValidationException::withMessages([
                'file' => 'Fields doest not match!!',
            ]);
        };

        $email = $row[12];
        $couponCode = $row[34];
        $date = intval($row[2]);
        $formatteddate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('d/m/Y');
        // $agentDetail = Agents::where('id', $couponCode)->first();

        $agentDetail = Agents::where('company_name', 'Frantoiogentili')->first();

        if(isset($agentDetail)){
            $agent_id = $agentDetail->id;
        } else {
            $add_data = new Agents();
            $add_data->company_name = 'Frantoiogentili';
            $add_data->vat_id = 12;
            $add_data->firstname = 'Frantoio';
            $add_data->lastname = 'gentili';
            $add_data->email = 'info@frantoiogentili.it';
            $add_data->phone = '3494995305';
            $add_data->mobile = '3494995305';
            $add_data->country = '1';
            $add_data->region = '9';
            $add_data->province = '25';
            $add_data->municipality = '300';
            $add_data->lat = '42.544548';
            $add_data->long = '11.731836';
            $add_data->meeting_point = 'GPVJ+RP, 01010 Farnese VT, Italia';
            $add_data->address = 'GPVJ+RP, 01010 Farnese VT, Italia';
            $add_data->reselling_per = 2;
            $add_data->reseller_coupon_code = 'franto401';
            $add_data->discount = 3;
            $add_data->zipcode = '01010';
            $add_data->status ='Active';
            $add_data->agent_active = "1";
            $add_data->save();

            $agent_id = $add_data->id;

            if ($add_data) {
                $role = Role::where('name', 'Supplier')->first();

                if ($role) {
                    $role_name = $role->name;
                } else {
                    $role = Role::create([
                        'name' => 'Supplier',
                        'guard_name' => 'web'
                    ]);

                    $role_name = $role->name;
                }

                $user_data = [
                    'name' => $add_data->firstname . " " . $add_data->lastname,
                    'email' => $add_data->email,
                    'password' => Hash::make('root'),
                    'role' => $role_name,
                    'mobile_no' => $add_data->mobile,
                    'status' => "Active",
                ];

                $user = User::create($user_data);

                if ($user) {
                    $permissions = RoleHasPermission::where('role_id', $role->id)->pluck('permission_id')->toArray();
                    $user->syncRoles($role->id);
                    $user->syncPermissions($permissions);
                }
            }
        }

        $customer_details = Customer::where('email', $email)->first();

        if (isset($customer_details)) {
            $customer_id = $customer_details->id;
            $customer_details->order_count = ($customer_details->order_count + 1);
            $customer_details->save();
        } else {
            $customer_data = [
                'wp_id' => '0', 
                'firstname' => $row[4],
                'lastname' => $row[5],
                'email' => $row[12],
                'username' => 'N/A',
                'zip_code' => $row[10],
                'phone_no' => $row[13],
                'country' => $row[11],
                'region' => $row[9],
                'municipality' => $row[8],
                'address' => $row[7],
                'shipping_country' => $row[20],
                'shipping_region' => $row[18],
                'shipping_municipality' => $row[17],
                'shipping_address' => $row[16],
                'order_count' => 1,
                'status' => 'Active',
                'shipping_zip' => $row[19],
            ];

            $newcustomer = Customer::create($customer_data);
            $customer_id = $newcustomer->id;
        }

        $booking_data = [ 
            'first_name' => $row[4],
            'last_name' => $row[5],
            'email' => $row[12],
            'phone' => $row[13],
            'order_date' => $formatteddate,
            'agent_id' => $agent_id,
            'customer_id' => $customer_id,
            'full_name' => $row[4].$row[5],
            'product_info' => json_encode([
                'product_id' => '',
                'product_image_url' => '',
                'product_name'=>  $row[31],
                'product_desc' => '',
                'quantity'=>  $row[32],
                'price' => $row[33],
            ]),
        ];

        $booking_order = BookingSystem::where('woo_order_id', $row[0])->first();
        if (isset($booking_order)) {
            $old_booking_Data = $booking_order;
            $booking_order->update($booking_data);
        } else {
            $order_data = [ 
                'first_name' => $row[4],
                'last_name' => $row[5],
                'company' => 'Frantoiogentili',
                'email' => $row[12],
                'phone' => $row[13],
                'address' => $row[7],
                'town' => $row[8],
                'zip' => $row[10],
                'state' => $row[9],
                'country' => $row[11],
                'shipping_address' => $row[16],
                'shipping_town' => $row[17],
                'shipping_zip' => $row[19],
                'shipping_state' => $row[18],
                'shipping_country' => $row[20],
                'total_shipping_price' => $row[25],
                'cart_price' => $row[23],
                'total_price' => $row[27],
                'woo_order_id' => $row[0],
                'order_date' => $formatteddate,
                'agent_id' => $agent_id,
                'customer_id' => $customer_id,
                'wp_customer_id' => '0',
                'full_name' => $row[4].$row[5],
                'woo_status' => $row[1],
                'product_info' => json_encode([
                    'product_id' => '',
                    'product_image_url' => '',
                    'product_name'=>  $row[31],
                    'product_desc' => '',
                    'quantity'=>  $row[32],
                    'price' => $row[33],
                ]),
            ];

            $neworder = BookingSystem::create($order_data);
        }
    }

    //ingoreheading from csv file
    public function startRow(): int
    {
        return 2;
    }
}

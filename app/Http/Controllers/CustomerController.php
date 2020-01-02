<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Customer;
use Image; //เรียกใช้ library จัดการรูปภาพเข้ามาใช้งาน
use File;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        
        $customers = Customer::all()->toArray();
        return view('customer.customerhome',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'fname' => 'required',
            'lname' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required'],[
            'fname.required' => 'กรุณากรอกชื่อด้วย',
            'lname.required' => 'กรุณากรอกนามสกุลด้วย',
            'phone.required' => 'กรุณากรอกเบอร์โทรศัพท์ด้วย',
            'email.required' => 'กรุณากรอกอีเมลด้วย',
            'address.required' => 'กรุณากรอกที่อยู่ด้วย']);
        $customer = new Customer(['fname' => $request->get('fname'),
        'lname' => $request->get('lname'),
        'phone' => $request->get('phone'),
        'email' => $request->get('email'),
        'address' => $request->get('address')]);

        
        // 'image' => $request->get('image')
        //dd($request->get('image'));
        //รูปภาพ-------
        if ($request->hasFile('image')) {
            $filename = Str::random(10) . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path() . '/images/', $filename);
            Image::make(public_path() . '/images/' . $filename)->resize(50, 50)->save(public_path() . '/images/resize/' . $filename);
            $customer->image = $filename;
        } else {
            $customer->image = 'nopic.png';
        }
        //รูปภาพ-------
        //dd($request->get('image'));
        $customer->save();
        return redirect()->route('customer.index')->with('success','บันทึกข้อมูลเรียบร้อย');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customer.edit',compact('customer','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'fname' => 'required',
            'lname' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required']);
        $customer = Customer::findOrFail($id);
        $customer = new Customer(['fname' => $request->get('fname'),
        'lname' => $request->get('lname'),
        'phone' => $request->get('phone'),
        'email' => $request->get('email'),
        'address' => $request->get('address')]);
        // $customer->fname = $request->get('fname');
        // $customer->lname = $request->get('lname');
        // $customer->phone = $request->get('phone');
        // $customer->email = $request->get('email');
        // $customer->address = $request->get('address');
        // $customer->image = $request->get('image');

        //dd($request->get('image'));

        if ($request->hasFile('image')) {
            // delete old file before update
            if ($customer->image != 'nopic.png') {
                File::delete(public_path() . '\\images\\' . $customer->image);
                File::delete(public_path() . '\\images\\resize\\' . $customer->image);
            }

            $filename = Str::random(10) . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path() . '/images/', $filename);
            Image::make(public_path() . '/images/' . $filename)->resize(50, 50)->save(public_path() . '/images/resize/' . $filename);
            $customer->image = $filename;
         }else{
            $customer->image = $request->get('image');
         }

        $customer->save();
        return redirect()->route('customer.index')->with('success','แก้ไขข้อมูลเรียบร้อย');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        if ($customer->image != 'nopic.png') {
            File::delete(public_path() . '\\images\\' . $customer->image);
            File::delete(public_path() . '\\images\\resize\\' . $customer->image);
        }
        $customer->delete();
        return redirect()->route('customer.index')->with('success','ลบข้อมูลเรียบร้อย');
    }
}

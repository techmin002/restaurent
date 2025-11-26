<?php

namespace Modules\Restaurent\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Product\Entities\Product;
use Modules\Restaurent\Models\Employee;
use Spatie\Permission\Models\Role;
use Modules\Restaurent\Models\Restaurent;
use Modules\Restaurent\Models\Order;
use Modules\Restaurent\Models\OfficeRegister;
use Modules\Restaurent\Models\Menu;
use Modules\Restaurent\Models\MenuVariation;
use Modules\Restaurent\Models\Customer;
use Modules\Restaurent\Models\Category;
use Modules\Restaurent\Models\RestaurentTable;
use Modules\Restaurent\Models\RestaurentTableMenu;


class RestaurentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurents = Restaurent::with('employees', 'user')->get();
        // dd($restaurents);
        return view('restaurent::restaurent.index', compact('restaurents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('restaurent::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => ['required'],
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:255|confirmed',
            'phone' => ['required'],
            'address' => ['required'],
            'admin_name' => ['required'],
            'admin_email' => ['required'],
            'admin_phone' => ['required'],
            'admin_address' => ['required'],
        ]);
        $role = Role::where('name', 'Admin')->first();
        $restaurent = new Restaurent();
        $restaurent->name = $request['name'];
        $restaurent->email = $request['email'];
        $restaurent->phone = $request['phone'];
        $restaurent->register_date = now();
        $restaurent->address = $request['address'];
        $restaurent->status = $request['status'] ?? 'on';
        $restaurent->save();
        $user = User::create([
            'name'     => $request->admin_name,
            'email'    => $request->admin_email,
            'restaurent_id'    => $restaurent->id,
            'created_by'    => auth()->user()->id,
            'access_type'    => $role->name,
            'password' => Hash::make($request->password),
            'role_id'    => $role->id,
            'status' => $request->status
        ]);
        $user->assignRole('Admin');
        $employee = new Employee();
        $employee->name = $request['admin_name'];
        $employee->email = $request['admin_email'];
        $employee->phone = $request['admin_phone'];
        $employee->address = $request['admin_address'];
        $employee->role = $role->name;
        $employee->restaurent_id = $restaurent['id'];
        $employee->created_by = auth()->user()->id;
        $employee->user_id = $user->id;
        $employee->status = $request['status'] ?? 'on';
        $employee->save();

        return back()->with('success', 'Restaurent Created Successfully');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('restaurent::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('restaurent::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $restaurent = Restaurent::findOrfail($id);
        $restaurent->name = $request['name'];
        $restaurent->email = $request['email'];
        $restaurent->phone = $request['phone'];
        $restaurent->address = $request['address'];
        $restaurent->save();

        $user = User::where('id', $request['userId'])->first();
        $user->name = $request['admin_name'];
        $user->email = $request['admin_email'];
        $user->save();
        $user->assignRole('Admin');
        $employee = Employee::where('user_id', $request['userId'])->first();
        $employee->name = $request['admin_name'];
        $employee->email = $request['admin_email'];
        $employee->phone = $request['admin_phone'];
        $employee->address = $request['admin_address'];
        $employee->save();
        return back()->with('success', 'Restaurent Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);

            // Delete related items first if needed
            if ($order->items) {
                $order->items()->delete(); // if you have items relationship
            }

            $order->delete();

            return back()->with('success', 'Order Deleted Successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting order: ' . $e->getMessage());
        }
        $branch->delete();
        return back()->with('success', 'Restaurent Deleted Successfully');
    }

    //receptionist
    public function moveToKitchen(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Update order_source column
        $order->order_source = 'Kitchen';
        $order->status = 'Sent to Kitchen';
        $order->save();

        return response()->json([
            'success' => true,
            'order_source' => $order->order_source,
            'status' => $order->status
        ]);
    }


    //kitchen
    // Start Cooking
    public function startCooking($id)
    {
        $order = Order::find($id);
        if (!$order) return response()->json(['success' => false, 'message' => 'Order not found'], 404);

        $order->status = 'Cooking';
        $order->save();

        return response()->json(['success' => true, 'message' => 'Order status updated to Cooking', 'status' => 'Cooking']);
    }

    // Mark Served
    public function markServed($id)
    {
        $order = Order::find($id);
        if (!$order) return response()->json(['success' => false, 'message' => 'Order not found'], 404);

        $order->status = 'Completed';
        $order->save();

        return response()->json(['success' => true, 'message' => 'Order status updated to Completed', 'status' => 'Completed']);
    }

    public function table_order($id)
    {
        $categories = Category::where('restaurent_id', auth()->user()->restaurent_id)->get();

        $menus = Menu::with('variations')->where('restaurent_id', auth()->user()->restaurent_id)->get();
        $restaurent_table = RestaurentTable::where('id', $id)->first();
        // dd($restaurent_table);
        $orders = Order::with('items', 'table', 'office', 'customer')->get();
        return view('restaurent::orders.order', compact('id', 'orders', 'restaurent_table', 'categories', 'menus'));
    }

    public function checkCustomerByPhone(Request $request)
    {
        $phone = $request->phone;
        $restaurant_id = auth()->user()->restaurent_id;

        $customer = Customer::where('phone', $phone)
            ->where('restaurent_id', $restaurant_id)
            ->first();

        return response()->json([
            'exists' => !is_null($customer),
            'customer' => $customer
        ]);
    }

    public function getRestaurantProducts(Request $request)
    {
        $restaurant_id = auth()->user()->restaurent_id;
        $query = $request->query('query', '');

        $products = Product::where('restaurent_id', $restaurant_id)
            ->where('name', 'like', '%' . $query . '%')
            ->get();

        return response()->json($products);
    }

    public function getProductWithVariations($id)
    {
        $restaurant_id = auth()->user()->restaurent_id;

        $product = Product::where('id', $id)
            ->where('restaurent_id', $restaurant_id)
            ->with('variations')
            ->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    public function storeCustomer(Request $request)
    {
        $restaurant_id = auth()->user()->restaurent_id;

        $customer = Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'restaurent_id' => $restaurant_id,
        ]);

        return response()->json($customer);
    }
    public function office_order(Request $request, $id)
    {
        $categories = Category::where('restaurent_id', auth()->user()->restaurent_id)->get();
        $office = OfficeRegister::where('id', $id)->first();
        $menus = Menu::with('variations')->where('restaurent_id', auth()->user()->restaurent_id)->get();
        $restaurent_table = RestaurentTable::where('id', $id)->first();
        $customers = Customer::where('restaurent_id', auth()->user()->restaurent_id)->get();
        // dd($restaurent_table);
        $orders = Order::with('items', 'table', 'office', 'customer')->get();
        return view('restaurent::orders.office_order', compact('id', 'orders', 'office', 'categories', 'menus', 'customers'));
    }
}
